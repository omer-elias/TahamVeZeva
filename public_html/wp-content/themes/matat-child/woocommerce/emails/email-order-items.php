<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';

?>

<tr>
	<td align="center" valign="top" style="padding-left:20px;padding-right:20px;" class="containtTable">

<?php
foreach ( $items as $item_id => $item ) :
	if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		$product = $item->get_product();

?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableProduct">
	<?php if ( $show_image ) : ?>
	<tr>
		<td align="center" valign="top" style="padding-bottom:20px;" class="productImg">
			<!-- Product Image and Link // -->
			<a href="<?php echo $url = get_permalink( $item['product_id'] ); ?>" target="_blank" style="text-decoration:none;">

				<?php echo apply_filters( 'woocommerce_order_item_thumbnail', '<img src="' . ( $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'medium' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'matat' ) . '" width="' . esc_attr( $image_size[0] ) . '" style="max-width:' . esc_attr( $image_size[0] ) . 'px;" />', $item ); ?>
			</a>
		</td>
	</tr>
	<?php else : ?>

	<?php endif;?>
	<tr>
		<td align="center" valign="top" style="padding-bottom:10px;" class="productName">
			<!-- Offer Title Text// -->
			<p class="text font-primary">
				<?php echo apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false );
					// SKU
					if ( $show_sku && is_object( $product ) && $product->get_sku() ) {
						echo '&nbsp;(' . $product->get_sku() .')';
					}
				?>

				<?php 
					// allow other plugins to add additional product information here
					do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

					wc_display_item_meta( $item );

					if ( $show_download_links ) {
						wc_display_item_downloads( $item );
					}

					// allow other plugins to add additional product information here
					do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );
				?>

			</p>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" style="padding-bottom:10px;" class="productQty">
			<!-- Offer Title Text// -->
			<p class="text font-primary">
                <?php printf(__('Qty', 'matat')); ?><?php echo ':  <strong>' . apply_filters( 'woocommerce_email_order_item_quantity', $item->get_quantity(), $item ) . '</strong>'; ?>
			</p>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" style="padding-bottom:20px;" class="productPrice">
			<!-- Offer Code Text// -->
			<p class="text font-primary">
                <?php printf(__('Price', 'matat')); ?><?php echo ':  <strong>' . $order->get_formatted_line_subtotal( $item ). '</strong>'; ?>
			</p>
		</td>
	</tr>
	<?php if ( $show_purchase_note && is_object( $product ) && ( $purchase_note = $product->get_purchase_note() ) ) : ?>
	<tr>
		<td align="center" valign="top" style="padding-bottom:20px;" class="description">
			<!-- Description Text// -->
			<p class="text font-primary">
				<?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?>
			</p>
		</td>
	</tr>
	<?php endif; ?>
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
<?php }
endforeach; ?>





