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
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit;
 }

$theme_path	=	get_stylesheet_directory_uri().'/woocommerce/emails/images'; // Image Path
$banner = $theme_path . '/order-delivered.png';
$pimg = $theme_path . '/approval.png';

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
 //do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );


$order = wc_get_order($order->get_id());
$items = $order->get_items();
//foreach ($items as $item) {
//    $product_name = $item->get_name();
//    $product_id = $item->get_id();
//    $product_variation_id = $item->get_variation_id();
//   /// echo $product_name;
//
//
//}





/**
  * @hooked WC_Emails::order_meta() Shows order meta data.
  */
// do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

 /**
  * @hooked WC_Emails::customer_details() Shows customer details
  * @hooked WC_Emails::email_address() Shows email address
  */
 do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
 ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
        <tr>
            <td align="center" valign="top" style="padding-bottom:30px;padding-left:20px;padding-right:20px">

                <h4 style="font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;text-align:center;padding:0;font-family:'Poppins',Helvetica,Arial,sans-serif;color:#8a8a8a;margin:0">
                    <a href="https://legale.matat.io/my-account/view-order/2122/" style="color:#b1b1b1;text-decoration:none" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://legale.matat.io/my-account/view-order/2122/&amp;source=gmail&amp;ust=1610454993788000&amp;usg=AFQjCNHvcJ6ybXJY5m01D6f60OIcd1wgAw">

                        מזהה הזמנה.  <?php echo $order->get_id();?>                           | תאריך הזמנה                            : <time datetime="<?php echo $order->get_date_created()->format ('d-m-Y');;?>"><?php echo $order->get_date_created()->format ('d-m-Y');;?></time>
                    </a>
                </h4>
            </td>
        </tr>
    <tr>
        <?php foreach ($items as $item) :?>
        <?php $product_name = $item->get_name();;?>
        <?php  $product_id = $item->get_product_id();?>
             <?php $product_email_url = get_field('product_email_url',$product_id);?>
        <?php $product_email_url_text = get_field('product_email_url_text',$product_id);?>


    <td align="center" valign="top" style="padding-bottom:10px">

        <img src="<?php echo $pimg;?>" alt="תמונת מוצר" width="140" style="max-width:140px" class="CToWUd">
        <p style="font-size:18px;font-weight:600;font-style:normal;letter-spacing:normal;line-height:26px;text-transform:none;text-align:center;padding:0;margin:0;font-family:'Poppins',Helvetica,Arial,sans-serif;color:#3c3c3c">
        <?php echo $product_name;?>
        </p>


    </td>
    </tr>
<?php if($product_email_url):?>
<tr>
    <td align="center" valign="top" style="padding-bottom:10px">

        <a href="<?php echo $product_email_url;?>">
        <p>
            <?php echo $product_email_url_text;?>
        </p>
        </a>



    </td>
</tr>

<?php endif;?>
<?php endforeach;?>
    </table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
	<tr>
		<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
			<!-- Medium Title Text // -->
			<p class="text font-primary">
				<?php printf(  __( 'Thank you!', 'matat' ) ); ?>
			</p>

		</td>
	</tr>

<!--	<tr>-->
<!--		<td align="center" valign="top" style="padding-bottom:20px;" class="description">-->
<!--			Description Text// -->
<!--			<p class="text font-secondary">-->
<!--				--><?php //printf( __( 'Item has been delivered! Hope you liked our service. We would love to get your feedback.', 'matat' ), $order->get_order_number(), $order->get_formatted_billing_full_name() ); ?>
<!--			</p>-->
<!--		</td>-->
<!--	</tr>-->
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton">
	<tr>
		<td align="center" valign="top" style="padding-top:20px;padding-bottom:20px;">
			<!-- Button Table // -->
			<table align="center" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" class="ctaButton">
						<!-- Button Link // -->
						<a class="text font-secondary" href="<?php echo $order->get_view_order_url(); ?>" target="_blank">
							<?php printf(  __( 'View Order', 'matat' ) ); ?>
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
