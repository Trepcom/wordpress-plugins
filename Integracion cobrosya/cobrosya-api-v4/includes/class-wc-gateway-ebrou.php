<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Ebrou Standard Payment Gateway
 *
 * Provides a Ebrou Standard Payment Gateway.
 *
 * @class 		WC_Ebrou
 * @extends		WC_Gateway_Ebrou
 * @version		2.0.0
 * @package		WooCommerce/Classes/Payment
 * @author 		WooThemes
 */
class WC_Gateway_Ebrou extends WC_Payment_Gateway {

	public function __construct() {
		$this->id 		= 'ebrou';
		$this->icon 	= get_site_url().'/wp-content/plugins/integracion_cobrosya/img/ebrou.png';
		$this->has_fields = false;
		$this->method_title = 'eBrou';
		$this->notify_url   = WC()->api_request_url( 'WC_Gateway_Ebrou' );
		$this->form_submission_method = true;
		$this->medioPago = 2;
		
		//Se definen y se cargan las opciones del panel.
		$this->init_form_fields();
		$this->init_settings();
		
		//Se cargan las opciones seteadas por el usuario
		$this->title 			 = $this->get_option( 'title' );
		$this->description 		 = $this->get_option( 'description' );
		
		//Accion para guardar las opciones del usuario.
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );	
	}
	
	
	/**
	 * Método que define los campos del Gateway   
	 */
	function init_form_fields() {

		$this->form_fields = array(
			'enabled' => array(
							'title' => __( 'Enable/Disable', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Habilitar eBrou', 'woocommerce' ),
							'default' => 'no'
						),
			'title' => array(
							'title' => __( 'Title', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'eBrou', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'description' => array(
							'title' => __( 'Description', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Usted puede pagar mediante eBrou.', 'woocommerce' )
						)
			);
	}
	
	/**
	 * Método que crea la transaccion en cobrosya (Pasos 2, 3, 4, 5 y 6).
	 */
	function process_payment( $order_id ) {
		
		include_once( 'envio_formulario_post.php' );
		
		return array(
			'result'   => 'success',
			'redirect' => $redireccionar
		);
		
	}
}
