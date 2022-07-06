<?php
/**
 * Admin new switch order email
 *
 * @author	Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 2.6.0
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
			<img src="<?php echo $theme_path . '/subscription-switch.png' ; ?>" width="600" alt="" border="0" style="width:100%; max-width:600px; height:auto; display:block;" />
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

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email ); ?>

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

	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableMediumTitle">
		<tr>
			<td align="center" valign="top" style="padding-bottom:20px;" class="mediumTitle">
				<!-- Medium Title Text // -->
				<p class="text font-primary">
					<?php esc_html_e( 'Switch Order Details', 'woocommerce-subscriptions' ); ?>
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

	<?php do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>


	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableMediumTitle">
		<tr>
			<td align="center" valign="top" style="padding-bottom:20px;" class="mediumTitle">
				<!-- Medium Title Text // -->
				<p class="text font-primary">
					<?php esc_html_e( 'New Subscription Details', 'woocommerce-subscriptions' ); ?>
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

	<?php foreach ( $subscriptions as $subscription ) : ?>
		<?php do_action( 'woocommerce_subscriptions_email_order_details', $subscription, $sent_to_admin, $plain_text, $email ); ?>
	<?php endforeach; ?>

	<?php do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
		<tr>
			<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
				<!-- Medium Title Text // -->
				<p class="text font-primary">
					<?php printf(  __( 'Subscription Switch', 'woocommerce-subscriptions' ) ); ?>	
				</p>
			</td>
		</tr>

		<tr>
			<td align="center" valign="top" style="padding-bottom:20px;" class="description">
				<!-- Description Text// -->
				<p class="text font-secondary">
					<?php $count = count( $subscriptions );
					// translators: $1: customer's first name and last name, $2: how many subscriptions customer switched
					echo esc_html( sprintf( _nx( 'Customer %1$s has switched their subscription. The details of their new subscription are bellow:', 'Customer %1$s has switched %2$d of their subscriptions. ', $count, 'Used in switch notification admin email', 'woocommerce-subscriptions' ), $order->get_formatted_billing_full_name(), $count ) );
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
								<?php printf(  __( 'View Order', 'woocommerce-subscriptions' ) ); ?>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
