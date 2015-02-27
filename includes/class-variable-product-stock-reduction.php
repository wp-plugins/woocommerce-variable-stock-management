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
class Variable_product_stock_reduction{
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

		//Display Fields
		add_action( 'woocommerce_product_after_variable_attributes', array($this, 'variable_fields' ), 10, 3 );
		//JS to add fields for new variations
		add_action( 'woocommerce_product_after_variable_attributes_js', array($this, 'variable_fields_js') );
		//Save variation fields
		add_action( 'woocommerce_process_product_meta_variable', array($this, 'save_variable_fields'), 10, 1 );
		//
		//add_action( "woocommerce_checkout_order_processed", array($this, 'update_stock_on_checkout') );
		add_action( "woocommerce_payment_complete", array($this, 'update_stock_on_checkout') );
		//Stop woocommerce from reducing stock amounts
		add_filter( 'woocommerce_payment_complete_reduce_order_stock', '__return_false' );

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
	 * Create new fields for variations
	 *
	*/
	public function variable_fields( $loop, $variation_data, $varPost ) {
		$post_id 	= $varPost->ID;
		$meta 		= get_post_meta( $post_id );
		?>
		<tr>
			<td>
				<?php
				// Select
				woocommerce_wp_select( 
				array( 
					'id'          => '_deductornot['.$loop.']', 
					'label'       => __( 'Deduct from stock total', 'woocommerce' ), 
					'description' => __( 'Choose a value.', 'woocommerce' ),
					'value'       => $meta['_deductornot'][0],
					'options' => array(
						'no'   => __( 'No', 'woocommerce' ),
						'yes'   => __( 'Yes', 'woocommerce' ),
						)
					)
				);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				// Number Field
				woocommerce_wp_text_input( 
					array( 
						'id'          => '_deductamount['.$loop.']', 
						'label'       => __( 'Amount to deduct from total', 'woocommerce' ), 
						'desc_tip'    => 'true',
						'description' => __( 'The amount of stock to deduct from the product total stock upon purchase.', 'woocommerce' ),
						'value'       => $meta['_deductamount'][0],
						'custom_attributes' => array(
										'step' 	=> 'any',
										'min'	=> '0'
									) 
					)
				);
				?>
			</td>
		</tr>	
		<?php
	}

	/**
	* Create new fields for new variations
	*
	*/
	public function variable_fields_js() {
				?>
					<tr>
						<td>
							<?php
							// Select
							woocommerce_wp_select( 
							array( 
								'id'          => '_deductornot[ + loop + ]', 
								'label'       => __( 'Deduct from stock total', 'woocommerce' ), 
								'description' => __( 'Choose a value.', 'woocommerce' ),
								'value'       => $variation_data['_deductornot'][0],
								'options' => array(
									'no'   => __( 'No', 'woocommerce' ),
									'yes'   => __( 'Yes', 'woocommerce' ),
									)
								)
							);
							?>
						</td>
					</tr>				
					<tr>
						<td>
							<?php
							// Number Field
							woocommerce_wp_text_input( 
								array( 
									'id'                => '_deductamount[ + loop + ]', 
									'label'             => __( 'Amount to deduct from total', 'woocommerce' ), 
									'desc_tip'          => 'true',
									'description'       => __( 'The amount of stock to deduct from the product total stock upon purchase.', 'woocommerce' ),
									'value'             => $variation_data['_deductamount'][0],
									'custom_attributes' => array(
													'step' 	=> 'any',
													'min'	=> '0'
												) 
								)
							);
							?>
						</td>
					</tr>
				<?php
	}

	/**
	* Save new fields for variations
	*
	*/
	public function save_variable_fields( $post_id ) {
				if (isset( $_POST['variable_sku'] ) ) :

					$variable_sku          = $_POST['variable_sku'];
					$variable_post_id      = $_POST['variable_post_id'];
					
					
					// Number Field
					$_deductamount = $_POST['_deductamount'];
					for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
						$variation_id = (int) $variable_post_id[$i];
						if ( isset( $_deductamount[$i] ) ) {
							update_post_meta( $variation_id, '_deductamount', stripslashes( $_deductamount[$i] ) );
						}
					endfor;
					
					
					// Select
					$_deductornot = $_POST['_deductornot'];
					for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
						$variation_id = (int) $variable_post_id[$i];
						if ( isset( $_deductornot[$i] ) ) {
							update_post_meta( $variation_id, '_deductornot', stripslashes( $_deductornot[$i] ) );
						}
					endfor;
	
				endif;
	}
	/**
	 * 
	 */
	public function update_stock_on_checkout($order_id){
		global $woocommerce;

		// order object (optional but handy)
		
		$order 			= new WC_Order( $order_id );
		$items 			= $order->get_items();
		$varation_ids 	= array();	
		$i 				= 0;

		foreach ($items as $key => $value) {
			# code...
			$variation_ids[$i]['variation_id'] 	= $value['variation_id'];
			$variation_ids[$i]['product_id'] 	= $value['product_id'];
			$variation_ids[$i]['qty']			= $value['qty'];
			$i++;
		}
		foreach($variation_ids as $key => $value){
		
			$deductornot 	= get_post_meta( $value["variation_id"], '_deductornot', true );;
			$deductamount 	= get_post_meta( $value["variation_id"], '_deductamount', true );;
			$product_id		= $value['product_id'];
			$qty			= $value['qty'];
			$product 		= wc_get_product( $product_id );

			if($deductornot == "yes"){
				$currentstock 	= $product->get_stock_quantity();
				$reduceamount	= intval($qty) * intval($deductamount);
				$newstock 		= intval($currentstock) - $reduceamount; 
				$updatestock 	= $product->set_stock( $newstock );;
								
			}else{
				$product->reduce_stock( $qty );
			}

		}
		//return false;
		//die();
	}
}