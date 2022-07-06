<?php
/**
 * Cancelled Subscription email
 *
 * @author	Prospress
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
			<img src="<?php echo $theme_path . '/subscription-expired.png' ; ?>" width="600" alt="" border="0" style="width:100%; max-width:600px; height:auto; display:block;" />
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

<?php do_action( 'woocommerce_subscriptions_email_order_details', $subscription, $sent_to_admin, $plain_text, $email ); ?>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
					<!-- Medium Title Text // -->
					<p class="text font-primary">
						<?php esc_html_e( 'Subscription', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>

			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						#<?php echo esc_html( $subscription->get_order_number() ); ?>
					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
					<!-- Medium Title Text // -->
					<p class="text font-primary">
						<?php echo esc_html_x( 'Last Payment', 'table heading', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>

			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php
							$last_payment_time = $subscription->get_time( 'last_payment', 'site' );
							if ( ! empty( $last_payment_time ) ) {
								echo esc_html( date_i18n( wc_date_format(), $last_payment_time ) );
							} else {
								esc_html_e( '-', 'woocommerce-subscriptions' );
							}
						?>
					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
					<!-- Medium Title Text // -->
					<p class="text font-primary">
						<?php echo esc_html_x( 'Price', 'table headings in notification email', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>

			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?>
					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
					<!-- Medium Title Text // -->
					<p class="text font-primary">
						<?php echo esc_html_x( 'Date Suspended', 'table headings in notification email', 'woocommerce-subscriptions' ); ?>
					</p>
				</td>
			</tr>

			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php echo esc_html( date_i18n( wc_date_format(), time() ) ); ?>
					</p>
				</td>
			</tr>
		</table>

<?php do_action( 'woocommerce_email_customer_details', $subscription, $sent_to_admin, $plain_text, $email ); ?>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
			<tr>
				<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
					<!-- Medium Title Text // -->
					<p class="text font-primary">
						<?php printf(  __( 'Subscription Suspended', 'woocommerce-subscriptions' ) ); ?>	
					</p>
				</td>
			</tr>

			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php // translators: $1: customer's billing first name and last name
							printf( esc_html__( 'A subscription belonging to %1$s has been suspended by the user. Their subscription\'s details:', 'woocommerce-subscriptions' ), esc_html( $subscription->get_formatted_billing_full_name() ) );
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
									<?php printf(  __( 'Manage Order', 'woocommerce-subscriptions' ) ); ?>
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
