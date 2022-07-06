<?php
/**
 * Admin cancelled order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-cancelled-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see       https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
  exit;
 }

$theme_path	=	get_stylesheet_directory_uri().'/woocommerce/emails/images'; // Image Path
$banner = $theme_path . '/order-refund.png';

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


<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
	<tr>
		<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
			<!-- Medium Title Text // -->
			<p class="text font-primary">
				<?php printf(  __( 'Refunded', 'matat' ) ); ?>
			</p>
		</td>
	</tr>

	<tr>
		<td align="center" valign="top" style="padding-bottom:20px;" class="description">
			<!-- Description Text// -->
			<p class="text font-secondary">
			<?php
				if ( $partial_refund ) {
					printf( __( 'Hi there. Your order on %s has been partially refunded.', 'matat' ), get_option( 'blogname' ) );
				} else {
					printf( __( 'Hi there. Your order on %s has been refunded.', 'matat' ), get_option( 'blogname' ) );
				}
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
						<a class="text font-secondary" href="<?php echo get_home_url(); ?>" target="_blank">
							<?php printf(  __( 'Contact Us', 'matat' ) ); ?>
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
