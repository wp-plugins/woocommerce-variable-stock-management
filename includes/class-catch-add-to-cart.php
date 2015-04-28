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

/**
 * GQ class.
 *
 * @package GQ
 * @author  vimes1984 <churchill.c.j@gmail.com>
 */
class catchaddtocart{
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

    //add_filter( 'woocommerce_available_variation', array($this, 'jk_woocommerce_available_variation') );
    add_filter( 'woocommerce_add_to_cart_validation', array($this,'filter_woocommerce_add_to_cart_validation'), 10, 10 );
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
   *
   */
   public function filter_woocommerce_add_to_cart_validation($valid, $product_id, $quantity, $variation_id = '', $variations = '' ){
     global $woocommerce;

     $product 			= wc_get_product( $product_id );
		if($product->product_type === "variable"){
		     $deductornot 	= get_post_meta( $variation_id, '_deductornot', true );
		     $deductamount 	= get_post_meta( $variation_id, '_deductamount', true );
		     $getvarclass   = new WC_Product_Variation($variation_id);
		     //reset($array);
		     $aatrs         = $getvarclass->get_variation_attributes();
		     foreach($aatrs as $key => $value){
		       $slug = $value;
		       $cat  = str_replace('attribute_', '', $key);
		     }
		     $titlevaria 	  = get_term_by('slug', $slug, $cat );

		     $backorder     = get_post_meta( $product->post->ID, '_backorders', true );

		     $string        = WC_Cart::get_item_data( $cart_item, $flat );

		     //var_dump($string);
		     if($backorder == 'no'){
		         if($deductornot == "yes"){
		           $currentstock 	= $product->get_stock_quantity();

		           $reduceamount	= intval($quantity) * intval($deductamount);
		           $currentavail  = intval($currentstock / $deductamount);


		            if($reduceamount > $currentstock){
		              $valid = false;
		              wc_add_notice( ''.__( 'You that goes over our availble stock amount.' , 'woocommerce' ) . __( 'We have: ' , 'woocommerce' ) . $currentavail .' '. $product->post->post_title .' ' .$titlevaria->name.'\'s '.__( ' available.' , 'woocommerce' ) , 'error' );
		              return $valid;
		            }else{
		              $valid = true;
		              return $valid;
		            }

		         }else{
		           return true;
		         }
		    }
		}
     return true;

   }
  /**
   *@TODO implement max min quanties on picker
   */
  public function jk_woocommerce_available_variation( $args ) {
/*
      global $product;
      //defaults
      $variation_ids = array();
      $i = 0;

      foreach($product->children as $key => $value){

        $variation_ids[$i] = $value;

        $i++;

      }
      foreach($variation_ids as $key => $value){

        $deductornot 	= get_post_meta( $value, '_deductornot', true );;
        $deductamount 	= get_post_meta( $value, '_deductamount', true );;

      }
  	   $args['max_qty'] = 80; 		// Maximum value (variations)
       $args['min_qty'] = 2;   	// Minimum value (variations)
       return $args;
*/
  }

}
