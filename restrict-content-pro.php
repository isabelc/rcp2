<?php
/*
Plugin Name: RCP2
Plugin URL: http://isabelcastillo.com/@todo
Description: Setup a complete subscription system for your WordPress site and deliver premium content to your subscribers. Unlimited subscription packages, membership management, discount codes, registration / login forms, and more.
Version: 2.1.10-beta3
Author: Isabel Castillo
Author URI: http://isabelcastillo.com
Contributors: isabel104
*/

if ( !defined( 'RCP_PLUGIN_DIR' ) ) {
	define( 'RCP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'RCP_PLUGIN_URL' ) ) {
	define( 'RCP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'RCP_PLUGIN_FILE' ) ) {
	define( 'RCP_PLUGIN_FILE', __FILE__ );
}
if ( !defined( 'RCP_PLUGIN_VERSION' ) ) {
	define( 'RCP_PLUGIN_VERSION', '2.1.10' );
}
if ( ! function_exists( 'isa_log' ) ) {// @todo remove
	function isa_log( $message ) {
	    if (WP_DEBUG === true) {
	        if ( is_array( $message) || is_object( $message ) ) {
	            error_log( print_r( $message, true ) );
	        } else {
	            error_log( $message );
	        }
	    }
	}
}

/*******************************************
* setup DB names
*******************************************/

if ( ! function_exists( 'is_plugin_active_for_network' ) )
	require_once ABSPATH . '/wp-admin/includes/plugin.php';

function rcp_get_levels_db_name() {
	global $wpdb;

	$prefix = is_plugin_active_for_network( 'restrict-content-pro/restrict-content-pro.php' ) ? '' : $wpdb->prefix;

	return apply_filters( 'rcp_levels_db_name', $prefix . 'restrict_content_pro' );
}

function rcp_get_discounts_db_name() {
	global $wpdb;

	$prefix = is_plugin_active_for_network( 'restrict-content-pro/restrict-content-pro.php' ) ? '' : $wpdb->prefix;

	return apply_filters( 'rcp_discounts_db_name', $prefix . 'rcp_discounts' );
}

function rcp_get_payments_db_name() {
	global $wpdb;

	$prefix = is_plugin_active_for_network( 'restrict-content-pro/restrict-content-pro.php' ) ? '' : $wpdb->prefix;

	return apply_filters( 'rcp_payments_db_name', $prefix . 'rcp_payments' );
}


/*******************************************
* global variables
*******************************************/
global $wpdb;

// load the plugin options
$rcp_options = get_option( 'rcp_settings' );

global $rcp_db_name;
$rcp_db_name = rcp_get_levels_db_name();

global $rcp_db_version;
$rcp_db_version = '1.5';

global $rcp_discounts_db_name;
$rcp_discounts_db_name = rcp_get_discounts_db_name();

global $rcp_discounts_db_version;
$rcp_discounts_db_version = '1.2';

global $rcp_payments_db_name;
$rcp_payments_db_name = rcp_get_payments_db_name();

global $rcp_payments_db_version;
$rcp_payments_db_version = '1.4';

/* settings page globals */
global $rcp_members_page;
global $rcp_subscriptions_page;
global $rcp_discounts_page;
global $rcp_payments_page;
global $rcp_settings_page;
global $rcp_reports_page;
global $rcp_export_page;

/*******************************************
* file includes
*******************************************/

// global includes
require RCP_PLUGIN_DIR . 'includes/install.php';
include RCP_PLUGIN_DIR . 'includes/class-rcp-capabilities.php';
include RCP_PLUGIN_DIR . 'includes/class-rcp-integrations.php';
include RCP_PLUGIN_DIR . 'includes/class-rcp-levels.php';
include RCP_PLUGIN_DIR . 'includes/class-rcp-member.php';
include RCP_PLUGIN_DIR . 'includes/class-rcp-payments.php';
include RCP_PLUGIN_DIR . 'includes/class-rcp-discounts.php';
include RCP_PLUGIN_DIR . 'includes/scripts.php';
include RCP_PLUGIN_DIR . 'includes/ajax-actions.php';
include RCP_PLUGIN_DIR . 'includes/cron-functions.php';
include RCP_PLUGIN_DIR . 'includes/deprecated/functions.php';
include RCP_PLUGIN_DIR . 'includes/discount-functions.php';
include RCP_PLUGIN_DIR . 'includes/email-functions.php';
include RCP_PLUGIN_DIR . 'includes/gateways/class-rcp-payment-gateway.php';
include RCP_PLUGIN_DIR . 'includes/gateways/class-rcp-payment-gateway-manual.php';
include RCP_PLUGIN_DIR . 'includes/gateways/class-rcp-payment-gateway-paypal.php';
include RCP_PLUGIN_DIR . 'includes/gateways/class-rcp-payment-gateway-paypal-pro.php';
include RCP_PLUGIN_DIR . 'includes/gateways/class-rcp-payment-gateway-paypal-express.php';
include RCP_PLUGIN_DIR . 'includes/gateways/class-rcp-payment-gateway-stripe.php';
include RCP_PLUGIN_DIR . 'includes/gateways/class-rcp-payment-gateways.php';
include RCP_PLUGIN_DIR . 'includes/gateways/gateway-functions.php';
include RCP_PLUGIN_DIR . 'includes/invoice-functions.php';
include RCP_PLUGIN_DIR . 'includes/login-functions.php';
include RCP_PLUGIN_DIR . 'includes/member-forms.php';
include RCP_PLUGIN_DIR . 'includes/member-functions.php';
include RCP_PLUGIN_DIR . 'includes/misc-functions.php';
include RCP_PLUGIN_DIR . 'includes/registration-functions.php';
include RCP_PLUGIN_DIR . 'includes/subscription-functions.php';
include RCP_PLUGIN_DIR . 'includes/error-tracking.php';
include RCP_PLUGIN_DIR . 'includes/shortcodes.php';
include RCP_PLUGIN_DIR . 'includes/template-functions.php';

if( !class_exists( 'WP_Logging' ) ) {
	include RCP_PLUGIN_DIR . 'includes/libraries/class-wp-logging.php';
}

// admin only includes
if( is_admin() ) {

	include RCP_PLUGIN_DIR . 'includes/upgrades.php';
	include RCP_PLUGIN_DIR . 'includes/admin/admin-pages.php';
	include RCP_PLUGIN_DIR . 'includes/admin/admin-notices.php';
	include RCP_PLUGIN_DIR . 'includes/admin/admin-ajax-actions.php';
	include RCP_PLUGIN_DIR . 'includes/admin/screen-options.php';
	include RCP_PLUGIN_DIR . 'includes/admin/members/members-page.php';
	include RCP_PLUGIN_DIR . 'includes/admin/settings/settings.php';
	include RCP_PLUGIN_DIR . 'includes/admin/subscriptions/subscription-levels.php';
	include RCP_PLUGIN_DIR . 'includes/admin/discounts/discount-codes.php';
	include RCP_PLUGIN_DIR . 'includes/admin/payments/payments-page.php';
	include RCP_PLUGIN_DIR . 'includes/admin/reports/reports-page.php';
	include RCP_PLUGIN_DIR . 'includes/admin/export.php';
	include RCP_PLUGIN_DIR . 'includes/admin/logs.php';
	include RCP_PLUGIN_DIR . 'includes/admin/help/help-menus.php';
	include RCP_PLUGIN_DIR . 'includes/admin/metabox.php';
	include RCP_PLUGIN_DIR . 'includes/admin/categories.php';
	include RCP_PLUGIN_DIR . 'includes/user-page-columns.php';
	include RCP_PLUGIN_DIR . 'includes/process-data.php';
	include RCP_PLUGIN_DIR . 'includes/export-functions.php';
} else {
	include RCP_PLUGIN_DIR . 'includes/content-filters.php';
	include RCP_PLUGIN_DIR . 'includes/feed-functions.php';
	if( isset( $rcp_options['enable_recaptcha'] ) ) {
		require_once RCP_PLUGIN_DIR . 'includes/captcha-functions.php';
	}
	include RCP_PLUGIN_DIR . 'includes/query-filters.php';
	include RCP_PLUGIN_DIR . 'includes/redirects.php';
}
function rcp_deactivation() {
	wp_clear_scheduled_hook( 'rcp_expired_users_check' );
	wp_clear_scheduled_hook( 'rcp_send_expiring_soon_notice' );
}
register_deactivation_hook( RCP_PLUGIN_FILE, 'rcp_deactivation' );