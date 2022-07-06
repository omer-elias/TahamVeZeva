<?php
/**
 * Customer renewal invoice email
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
			<img src="<?php echo $theme_path . '/subscription-completed.png' ; ?>" width="600" alt="" border="0" style="width:100%; max-width:600px; height:auto; display:block;" />
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

<?php do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
		<tr>
			<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
				<!-- Medium Title Text // -->
				<p class="text font-primary">
					<?php printf(  __( 'Renewal Invoice', 'woocommerce-subscriptions' ) ); ?>	
				</p>
			</td>
		</tr>

		<tr>
			<td align="center" valign="top" style="padding-bottom:20px;" class="description">
				<!-- Description Text// -->
				<p class="text font-secondary">
					<?php if ( $order->status == 'pending' ) : ?>
						<?php
							// translators: %1$s: name of the blog, %2$s: link to checkout payment url, note: no full stop due to url at the end
							echo wp_kses( sprintf( _x( 'An invoice has been created for you to renew your subscription with %1$s. To pay for this invoice please use the following link: %2$s', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), esc_html( get_bloginfo( 'name' ) ), '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'woocommerce-subscriptions' ) . '</a>' ), array( 'a' => array( 'href' => true ) ) );
							?>
					
						<?php elseif ( 'failed' == $order->status ) : ?>
						
						<?php
							// translators: %1$s: name of the blog, %2$s: link to checkout payment url, note: no full stop due to url at the end
							echo wp_kses( sprintf( _x( 'The automatic payment to renew your subscription with %1$s has failed. To reactivate the subscription, please login and pay for the renewal from your account page: %2$s', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), esc_html( get_bloginfo( 'name' ) ), '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'woocommerce-subscriptions' ) . '</a>' ), array( 'a' => array( 'href' => true ) ) ); ?></p>
					<?php endif; ?>
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
							<a class="text font-secondary" href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" target="_blank">
								<?php printf(  __( 'Retry', 'woocommerce-subscriptions' ) ); ?>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
