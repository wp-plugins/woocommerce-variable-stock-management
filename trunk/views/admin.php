<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
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
?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<!-- TODO: Provide markup for your options page here. -->
<p>
	OK here goes Glynn! we need the file in the folder called import E.G here::<br>
	<strong><?php echo plugins_url("/import/cats.csv", dirname(__FILE__)); ?></strong>
</p>
<p>Download the sample from here: <a href="<?php echo plugins_url("/import/cats.csv", dirname(__FILE__)); ?>">Sample</a></p>
<p>It should be layed out like so</p>
<table class="widefat fixed" cellspacing="0">
    <thead>
    <tr>

            <th id="columnname" class="manage-column column-columnname" scope="col">parent_slug</th> 
            <th id="columnname" class="manage-column column-columnname" scope="col">name</th>
            <th id="columnname" class="manage-column column-columnname num" scope="col">description</th> 
            <th id="columnname" class="manage-column column-columnname num" scope="col">slug</th> 
            <th id="columnname" class="manage-column column-columnname num" scope="col">display_type</th> 

    </tr>
    </thead>

    <tbody>
        <tr class="alternate">
            <td class="column-columnname">0</td>
            <td class="column-columnname">Accessories</td>
            <td class="column-columnname">Accessories description</td>
            <td class="column-columnname">accessories</td>
            <td class="column-columnname">product</td>
        </tr>
        <tr>
            <td class="column-columnname">accessories</td>
            <td class="column-columnname">Tobbaco Accessories</td>
            <td class="column-columnname">Tobbaco Accessories description</td>
            <td class="column-columnname">tobbaco-accessories</td>
            <td class="column-columnname">product</td>
        </tr>
    </tbody>
</table>
<p>And parent must be declared prior to the child since the importer will work from the top down... NO CAPS OR SPACES IN THE SLUG FIELDS!</p>
<p>The first image in the description will be used as the default cat image and text will be used as the description, you can use html in the description but it will all be stripped</p>
<p>For the images just leave the old url in I.E <code>%%GLOBAL_ShopPath%%/path/to/image/image.jpg</code> this plugin will go and find them and upload them to the wordpress media library and assing it to the category :D </p>
<?php 
	$vartest = Import_categories::get_instance();
?>
	<?php
		if(isset( $_GET["settings-updated"] ) ){
			
			$vartest->import_function();

		}else{

		}
	?>
	<form method="post" action="options.php">
	    <?php settings_fields( 'baw-settings-group' ); ?>
	    <?php do_settings_sections( 'baw-settings-group' ); ?>
	    <?php submit_button('Import'); ?>
	</form>

</div>
