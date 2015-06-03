<?php
/**
 * Deprecated functions
 *
 * These are kept here for backwards compatibility with extensions that might be using them
 *
 * @since 1.5
*/

/**
 * Check if a payment already exists
 *
 * @deprecated  1.5
 * @param       $type string The type of payment (web_accept, subscr_payment, Credit Card, etc)
 * @param       $date string/date The date of tpaen
 * @param       $subscriptionkey string The subscription key the payment is connected to
 * @return      bool
*/

function rcp_check_for_existing_payment( $type, $date, $subscription_key ) {

	global $wpdb, $rcp_payments_db_name;

	if( $wpdb->get_results( $wpdb->prepare("SELECT id FROM " . $rcp_payments_db_name . " WHERE `date`='%s' AND `subscription_key`='%s' AND `payment_type`='%s';", $date, $subscription_key, $type ) ) )
		return true; // this payment already exists

	return false; // this payment doesn't exist
}
