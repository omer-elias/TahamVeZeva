<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author WooThemes
 * @package WooCommerce/Templates/Emails/HTML
 * @version 3.7.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit;
 }

$theme_path	=	get_stylesheet_directory_uri().'/woocommerce/emails/images'; // Image Path
$banner = $theme_path . '/order-forget.png';

if (!empty($email->get_option('banner_img'))) {
    $banner = $email->get_option('banner_img');
}
/**
	* @hooked WC_Emails::email_header() Output the email header
*/
 do_action( 'woocommerce_email_header', $email_heading, $email ); ?>


<tr>
	<td align="center" valign="top" style="padding-bottom:20px" class="imgHero">
		<!-- Hero Image // -->
		<a href="#" target="_blank" style="text-decoration:none;">
			<img src="<?php echo $banner; ?>" width="600" alt="" border="0" style="width:100%; max-width:600px; height:auto; display:block;" />
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
	* @hooked WC_Structured_Data::generate_order_data() Generates structured data.
	* @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
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
 do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
?>

<?php if ( $order->has_status( 'pending' ) ) : ?>
	
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
	<tr>
		<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
			<!-- Medium Title Text // -->
			<p class="text font-primary">
				<?php printf(  __( 'Your Order is Pending', 'matat' ) ); ?>
			</p>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" style="padding-bottom:20px;" class="description">
			<!-- Description Text// -->
			<p class="text font-secondary">
				<?php printf( __( 'An order has been created for you on %1$s. To pay for this order please use the following link.', 'matat' ), get_bloginfo( 'name', 'display' ) ); ?>
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
						<a href="<?php echo esc_url( admin_url( 'post.php?post=' . $order->get_id() . '&action=edit' ) ); ?>">
							<?php printf(  __( 'Pay Now', 'matat' ) ); ?>
						</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php else : ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
	<tr>
		<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
			<!-- Medium Title Text // -->
			<p class="text font-primary">
				<?php printf(  __( 'Order Details', 'matat' ) ); ?>
			</p>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" style="padding-bottom:20px;" class="description">
			<!-- Description Text// -->
			<p class="text font-secondary">
				<?php printf( __( 'View a summary of an order on %1$s.', 'matat' ), get_bloginfo( 'name', 'display' ) ); ?>
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
						<a href="<?php echo esc_url( admin_url( 'post.php?post=' . $order->get_id() . '&action=edit' ) ); ?>">
							<?php __( 'View Order', 'matat' ); ?>
						</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php endif; ?>


 <?php
 /**
	* @hooked WC_Emails::email_footer() Output the email footer
	*/
 do_action( 'woocommerce_email_footer', $email );
