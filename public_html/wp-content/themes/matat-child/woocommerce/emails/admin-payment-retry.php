<?php
/**
 * Admin payment retry email
 *
 * Email sent to admins when an attempt to automatically process a subscription renewal payment has failed
 * and a retry rule has been applied to retry the payment in the future.
 *
 * @author		Prospress
 * @package 	WooCommerce_Subscriptions/Templates/Emails/Plain
 * @version		2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
 }

$theme_path	=	get_stylesheet_directory_uri().'/woocommerce/emails/images'; // Image Path

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<tr>
	<td align="center" valign="top" style="padding-bottom:20px" class="imgHero">
		<!-- Hero Image // -->
		<a href="#" target="_blank" style="text-decoration:none;">
			<img src="<?php echo $theme_path . '/subscription-payment-retry.png' ; ?>" width="600" alt="" border="0" style="width:100%; max-width:600px; height:auto; display:block;" />
		</a>
	</td>
</tr>

<tr>
	<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
		<!-- Main Title Text // -->
		<h2 class="text font-primary">
			<?php echo $email_heading ?>
		</h2>
	</td>
</tr>

<?php

/**
* @hooked WC_Emails::order_details() Shows the order details table.
* @since 2.5.0
*/
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
* @hooked WC_Emails::order_meta() Shows order meta data.
*/
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
* @hooked WC_Emails::customer_details() Shows customer details
* @hooked WC_Emails::email_address() Shows email address
*/
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
		<tr>
			<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
				<!-- Medium Title Text // -->
				<p class="text font-primary">
					<?php printf(  __( 'Payment Retry', 'woocommerce-subscriptions' ) ); ?>	
				</p>
			</td>
		</tr>

		<tr>
			<td align="center" valign="top" style="padding-bottom:20px;" class="description">
				<!-- Description Text// -->
				<p class="text font-secondary">
					<?php 
					// translators: %1$s: an order number, %2$s: the customer's full name, %3$s: lowercase human time diff in the form returned by wcs_get_human_time_diff(), e.g. 'in 12 hours'
					echo esc_html( sprintf( _x( 'The automatic recurring payment for order #%d from %s has failed. The payment will be retried %3$s.', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), $order->get_order_number(), $order->get_formatted_billing_full_name(), strtolower( wcs_get_human_time_diff( $retry->get_time() ) ) ) );
					?>
				</p>
			</td>
		</tr>
	</table>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton">
		<tr>
			<td align="center" valign="top" style="padding-top:20px;padding-bottom:20px;">
				<!-- Button Table // -->
				<table align="center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" class="ctaButton">
							<!-- Button Link // -->
							<a class="text font-secondary" href="<?php echo $subscription->get_view_order_url(); ?>" target="_blank">
								<?php printf(  __( 'Retry', 'woocommerce-subscriptions' ) ); ?>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

<?php

/**
* @hooked WC_Emails::email_footer() Output the email footer
*/
do_action( 'woocommerce_email_footer', $email );
