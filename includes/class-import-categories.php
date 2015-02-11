<?php
/**
 * GQ
 *
 * @package   gq
 * @author    vimes1984 <churchill.c.j@gmail.com>
 * @license   GPL-2.0+
 * @link      http://buildawebdoctor.com
 * @copyright 2-7-2015 BAWD
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
/**
 * GQ class.
 *
 * @package GQ
 * @author  vimes1984 <churchill.c.j@gmail.com>
 */
class Import_categories{
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = "1.0.0";

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = "gq";

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		// Add the options page and menu item.
		add_action("admin_menu", array($this, "add_plugin_admin_menu"));
		//call register settings function
		add_action( 'admin_init',  array($this,  'register_mysettings') );
	}
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn"t been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		$this->plugin_screen_hook_suffix = add_management_page(__("GQ - Administration", $this->plugin_slug), __("GQ Importer", $this->plugin_slug), "read", $this->plugin_slug, array($this, "display_plugin_admin_page"));

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once("views/admin.php");
	}
	/**
	 * 
	 */
	public function parse_csv_file($csvfile) {
		$csv = Array();
		$rowcount = 0;
		if (($handle = fopen($csvfile, "r")) !== FALSE) {
			$max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
			$header = fgetcsv($handle, $max_line_length);
			$header_colcount = count($header);
			while (($row = fgetcsv($handle, $max_line_length)) !== FALSE) {
				$row_colcount = count($row);
				if ($row_colcount == $header_colcount) {
					$entry = array_combine($header, $row);
					$csv[] = $entry;
				}
				else {
					error_log("csvreader: Invalid number of columns at line " . ($rowcount + 2) . " (row " . ($rowcount + 1) . "). Expected=$header_colcount Got=$row_colcount");
					return null;
				}
				$rowcount++;
			}
			//echo "Totally $rowcount rows found\n";
			fclose($handle);
		}
		else {
			error_log("csvreader: Could not read CSV \"$csvfile\"");
			return null;
		}
		return $csv;
	}
	/**
	 * 
	 */
	public function register_mysettings() {
		//register our settings
		register_setting( 'baw-settings-group', 'new_option_name' );
		register_setting( 'baw-settings-group', 'some_other_option' );
		register_setting( 'baw-settings-group', 'option_etc' );
	}
	/**
	 * Public import function
	 */
	public function import_function(){
		global $wpdb;
		set_time_limit(800);
		$path = plugin_dir_path( __FILE__ ) . "import/cats.csv";

		$lines = file($path);

		$csvarray =  $this->parse_csv_file( $path );
		foreach ($csvarray as $key => $value){
				$name 			= $value['name'];
				$slug 			= $value['slug'];
				$description	= $value["description"];
				$parent_slug 	= $value['parent_slug'];
				$display_type 	= $value['display_type'];
				$term_id  		= $value['id'];
				if($parent_slug == "0"){

					$catarr = array(
									 // 'cat_ID' => intval( $term_id ),
									  'cat_name' => $name,
									  'category_description' => $description,
									  'category_nicename' => $slug,
									  'category_parent' => intval( $parent_slug ),
									  'taxonomy' => 'product_cat' );

					$new_tax  		= wp_insert_category( $catarr, true );
				}else{

					$parent_term = term_exists( $parent_slug, 'product_cat' );
					$parent_term_id = $parent_term['term_id'];
					$catarr = array(
									 // 'cat_ID' => intval( $term_id ),
									  'cat_name' => $name,
									  'category_description' => $description,
									  'category_nicename' => $slug,
									  'category_parent' => $parent_term_id,
									  'taxonomy' => 'product_cat' );

					$new_tax  		= wp_insert_category( $catarr, true );
				}

				if ( ! is_wp_error( $new_tax ) ){

								$taxid 			= $new_tax["term_id"];

								if($description != ''){
									$src_preparsed 	= $this->get_img_url($description);
									$src_clean 		= str_replace("%%GLOBAL_ShopPath%%", "YOUR URL HERE!", $src_preparsed);

									$thumbnail 			= media_sideload_image( $src_clean, $new_tax );

									if( ! is_wp_error( $thumbnail ) ){

										$thumbnail_link 	= $this->get_img_url($thumbnail);
										$thumbnail_id		= intval( $this->pn_get_attachment_id_from_url($thumbnail_link) );

										
										$wpdb->insert("wp_woocommerce_termmeta", array(
																						"woocommerce_term_id" => $new_tax, 
																						"meta_key" => "thumbnail_id",   
																						"meta_value" => $thumbnail_id
																						)
										);					
									}else{
										echo "<p>Image error</p>";
				    			 		echo $thumbnail->get_error_message();
									}
								}
								$wpdb->insert("wp_woocommerce_termmeta", array(
																				"woocommerce_term_id" => $new_tax, 
																				"meta_key" => "display_type",   
																				"meta_value" => $display_type
																				)
								);
								echo "<h4>Imported: ". $value['name'] . "</h4>";
				}else{
				     // Trouble in Paradise:
				     echo $new_tax->get_error_message();

				}

		}

	}
	public function get_img_url($html){
		$doc 			= new DOMDocument();
		$doc->loadHTML($html);
		$xpath 			= new DOMXPath($doc);
		$src_preparsed 	= $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
		return $src_preparsed;
	}
	/**
	 * 
	 */
	public	function pn_get_attachment_id_from_url( $attachment_url = '' ) {
	 
		global $wpdb;
		$attachment_id = false;
	 
		// If there is no url, return.
		if ( '' == $attachment_url )
			return;
	 
		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();
	 
		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
		if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
	 
			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
	 
			// Remove the upload path base directory from the attachment URL
			$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
	 
			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
	 
		}
	 
		return $attachment_id;
	}


}