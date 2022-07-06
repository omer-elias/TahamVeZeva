<?php
/**
 * Subscription information template
 *
 * @author	Brent Shepherd / Chuck Mac
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php if ( ! empty( $subscriptions ) ) : ?>

	<?php foreach ( $subscriptions as $subscription ) : ?>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
					<!-- Medium Title Text // -->
					<p class="text font-primary">
						<?php esc_html_e( 'Subscription Information:', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>

			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php _e( 'The details of the Subscription can be found below.', 'woocommerce-subscriptions' ); ?>

					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDivider">
			<tr>
				<td align="center" valign="top" style="padding-top:20px;padding-bottom:40px;">
					<!-- Divider // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td height="1" class="divider">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableSmllTitle">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="smllTitle">
					<!-- Small Title Text // -->
					<p class="text font-primary">
						<?php _e( 'Subscription', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="smllSubTitle">
					<!-- Info Title Text // -->
					<p class="text font-primary">
						<?php echo sprintf( esc_html_x( '#%s', 'subscription number in email table. (eg: #106)', 'woocommerce-subscriptions' ), esc_html( $subscription->get_order_number() ) ); ?>
					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableSmllTitle">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="smllTitle">
					<!-- Small Title Text // -->
					<p class="text font-primary">
						<?php _e( 'Start Date', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="smllSubTitle">
					<!-- Info Title Text // -->
					<p class="text font-primary">
						<?php echo esc_html( date_i18n( wc_date_format(), $subscription->get_time( 'start', 'site' ) ) ); ?>
					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableSmllTitle">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="smllTitle">
					<!-- Small Title Text // -->
					<p class="text font-primary">
						<?php _e( 'End Date', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="smllSubTitle">
					<!-- Info Title Text // -->
					<p class="text font-primary">
						<?php echo esc_html( ( 0 < $subscription->get_time( 'end' ) ) ? date_i18n( wc_date_format(), $subscription->get_time( 'end', 'site' ) ) : _x( 'When Cancelled', 'Used as end date for an indefinite subscription', 'woocommerce-subscriptions' ) ); ?>
					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableSmllTitle">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="smllTitle">
					<!-- Small Title Text // -->
					<p class="text font-primary">
						<?php _e( 'Price', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="smllSubTitle">
					<!-- Info Title Text // -->
					<p class="text font-primary">
						<?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?>
					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDivider">
			<tr>
				<td align="center" valign="top" style="padding-top:20px;padding-bottom:40px;">
					<!-- Divider // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td height="1" class="divider">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

	<?php endforeach; ?>

<?php endif; ?>
