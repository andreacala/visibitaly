<?php

function theme_enqueue_styles() {

    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );

}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



function avada_lang_setup() {

	$lang = get_stylesheet_directory() . '/languages';

	load_child_theme_textdomain( 'Avada', $lang );

}

add_action( 'after_setup_theme', 'avada_lang_setup' );

/**
 * Function per il controllo del checkout esclusivamente sui prodotti di diversi venditori;
 * - lo script viene caricato solamente nella pagina del carrello ('Shopping cart');
 */

function load_cart_scripts_custom_checks() {

	if( is_page( 'cart' ) ) {
		wp_enqueue_script('jquery');
	   	wp_enqueue_script('checks_cart', get_template_directory_uri() . '-Child-Theme/js/custom_checks_sm_cart.js');
	}

	if( is_checkout() ) {
		wp_register_Script('carrier_selection', get_template_directory_uri() . '-Child-Theme/js/carrier-selection.js');
	}

}

add_action( 'wp_enqueue_scripts', 'load_cart_scripts_custom_checks' );

function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        //return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );

function my_shortcode( $atts, $content="" ) {

	$vendors = YITH_Vendors()->get_vendors();

	foreach ( $vendors as $vendor ) {

		$vendors_list[] = $vendor->name . '<br>';

	}

	return implode(' ', $vendors_list);

}
add_shortcode( 'toma', 'my_shortcode' );

/**
 * Funzione che filtra i venditori passando l'id del corriere al file javascript che
 * rimuove le option della select con i corrieri
 *
 * @return void
 * @author Manuel Ricci <info@manuelricci.com>
 */
function filter_vendor_select() {
	global $woocommerce;
	$items = $woocommerce->cart->get_cart();

	$vendors = array();

	foreach($items as $item => $values) {
		$vendors[] = yith_get_vendor($values['product_id'], 'product');
	}

	$carrierId = get_term_meta($vendors[0]->id)['carrier'][0];

	wp_localize_script('carrier_selection', 'params', array(
		'carrierId'	=> $carrierId
	));

	wp_enqueue_script('carrier_selection');
}
add_action('woocommerce_checkout_after_customer_details', 'filter_vendor_select');

/*add_filter( 'woocommerce_checkout_fields' , 'custom_store_pickup_field');

function custom_store_pickup_field( $fields ) {
	$fields['shipping']['store_pickup'] = array(
		'type' => 'select',
		'options' => array(
			'option_1' => 'Option 1 text',
			'option_2' => 'Option 2 text',
			'option_3' => 'Option 2 text'
		),
		'label' => __('Store Pick Up Location', 'woocommerce'),
		'required' => false,
		'class' => array('store-pickup form-row-wide'),
		'clear' => true
	);

	return $fields;
}*/



add_action( 'woocommerce_review_order_before_submit', 'add_privacy_checkbox', 9 );

function add_privacy_checkbox() {

	woocommerce_form_field( 'privacy_policy', array(
		'type' => 'checkbox',
		'class' => array('form-row privacy'),
		'label_class' => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
		'input_class' => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
		'required' => true,
		'label' => 'Ho letto e accetto i <a href="https://shoppingmartesana.it/termini-e-condizioni-sulla-privacy/">termini e condizioni sulla privacy</a> e le <a href="https://shoppingmartesana.it/termini-e-condizioni-di-vendita-e-recesso/">condizioni di vendita e recesso</a>',
	));

}

add_action( 'woocommerce_checkout_process', 'privacy_checkbox_error_message' );

function privacy_checkbox_error_message() {
	if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
		wc_add_notice( __( 'Devi accetare le condizioni sulla privacy per procedere' ), 'error' );
	}
}