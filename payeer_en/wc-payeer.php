<?php
/*
 * Plugin Name: WooCommerce Payeer Payment Gateway
 * Plugin URI: 
 * Description: Module for accepting payments in the payment system Payeer.
 * Author: Muhammed Azharudheen K J
 * Author URI: 
 * Version: 1.0.0
 *
 /*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter( 'woocommerce_payment_gateways', 'misha_add_gateway_class' );
function misha_add_gateway_class( $gateways ) {
	$gateways[] = 'WC_Misha_Gateway'; // your class name is here
	return $gateways;
}
 
/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'misha_init_gateway_class' );
function misha_init_gateway_class() {
 
	class WC_Misha_Gateway extends WC_Payment_Gateway {
 
 		/**
 		 * Class constructor, more about it in Step 3
 		 */
 		public function __construct() {
			
			$this->id = 'payeer';  // payment gateway plugin ID
			$this->icon = apply_filters('woocommerce_payeer_icon', $plugin_dir . 'payeer.png'); // URL of the icon that will be displayed on checkout page near your gateway name
			$this->has_fields = false; // in case you need a custom credit card form
			$this->method_title = 'Payeer payment Gateway';
			$this->method_description = 'Description of Payeer payment gateway'; // will be displayed on the options page

			// Method with all the options fields
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();
			$this->title = $this->get_option('title');
			$this->description = $this->get_option( 'description' );
			$this->payeer_url = $this->get_option('payeer_url');
			$this->payeer_merchant = $this->get_option('payeer_merchant');
			$this->payeer_secret_key = $this->get_option('payeer_secret_key');
			$this->email_error = $this->get_option('email_error');
			$this->ip_filter = $this->get_option('ip_filter');
			$this->log_file = $this->get_option('log_file');

			add_action('woocommerce_receipt_' . $this->id, array($this, 'receipt_page'));
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) ); // This action hook saves the settings
			add_action('woocommerce_api_wc_' . $this->id, array($this, 'check_ipn_response'));

		 
			
		 
			// We need custom JavaScript to obtain a token
		 
			// You can also register a webhook here
			// add_action( 'woocommerce_api_{webhook name}', array( $this, 'webhook' ) );
 
 		}
 
		/**
 		 * Plugin options, we deal with it in Step 3 too
 		 */
 		public function init_form_fields(){
 
			$this->form_fields = array(
				'enabled' => array(
					'title' => __('Enable/Disable', 'woocommerce'),
					'type' => 'checkbox',
					'label' => __('Included', 'woocommerce'),
					'default' => 'yes'
				),
				'title' => array(
					'title' => __('Name', 'woocommerce'),
					'type' => 'text', 
					'description' => __( 'This is the name that the user sees when selecting a payment method.', 'woocommerce' ), 
					'default' => __('Payeer', 'woocommerce')
				),
				'payeer_url' => array(
					'title' => __('URL of the merchant', 'woocommerce'),
					'type' => 'text',
					'description' => __('url to payment system Payeer', 'woocommerce'),
					'default' => 'https://payeer.com/merchant/'
				),
				'payeer_merchant' => array(
					'title' => __('ID of the store', 'woocommerce'),
					'type' => 'text',
					'description' => __('Identifier of store registered in the system "PAYEER".<br/>Get it in <a href="https://payeer.com/account/">Payeer account</a>: the "Account -> Merchant -> Settings".', 'woocommerce'),
					'default' => ''
				),
				'payeer_secret_key' => array(
					'title' => __('Secret key', 'woocommerce'),
					'type' => 'password',
					'description' => __('The secret key notification that payment has been made,<br/>which is used to check the integrity of received information<br/>and unequivocal identification of the sender.<br/>Must match the secret key specified in <a href="https://payeer.com/account/">Payeer account</a>: the "Account -> Merchant -> Settings".', 'woocommerce'),
					'default' => ''
				),
				'log_file' => array(
					'title' => __('Path to file to log payments via Payeer (for example, /payeer_orders.log)', 'woocommerce'),
					'type' => 'text',
					'description' => __('If the path is not specified, the log is not written', 'woocommerce'),
					'default' => ''
				),
				'ip_filter' => array(
					'title' => __('IP filter', 'woocommerce'),
					'type' => 'text',
					'description' => __('The list of trusted ip addresses, you can specify a mask', 'woocommerce'),
					'default' => ''
				),
				'email_error' => array(
					'title' => __('Email for bugs', 'woocommerce'),
					'type' => 'text',
					'description' => __('Email to send payment errors', 'woocommerce'),
					'default' => ''
				),
				'description' => array(
					'title' => __( 'Description', 'woocommerce' ),
					'type' => 'textarea',
					'description' => __( 'A description of the method of payment which the customer will see on your website.', 'woocommerce' ),
					'default' => 'Payment via Payeer'
				)
			);
		}
 
	 	}
 
		/**
		 * You will need it if you want your custom credit card form, Step 4 is about it
		 */
		public function payment_fields() {
 
		...
 
		}
 
		/*
		 * Custom CSS and JS, in most cases required only when you decided to go with a custom credit card form
		 */
	 	public function payment_scripts() {
 
		...
 
	 	}
 
		/*
 		 * Fields validation, more in Step 5
		 */
		public function validate_fields() {
 
		...
 
		}
 
		/*
		 * We're processing the payments here, everything about it is in Step 5
		 */
		public function process_payment( $order_id ) {
 
		...
 
	 	}
 
		/*
		 * In case you need a webhook, like PayPal IPN etc
		 */
		public function webhook() {
 
		...
 
	 	}
 	}
}