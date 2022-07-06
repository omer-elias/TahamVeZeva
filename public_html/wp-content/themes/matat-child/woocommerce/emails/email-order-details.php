<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates/Emails
 * @version     3.7.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$text_align = is_rtl() ? 'right' : 'left';

if (isset($order_type) == false) {
    $order_type = 'order';
}

do_action('woocommerce_email_before_' . $order_type . '_table', $order, $sent_to_admin, $plain_text, $email);

$link_element_url = ($order_type != 'order') ? wcs_get_edit_post_link(wcs_get_objects_property($order, 'id')) : $order->get_view_order_url();

?>
<?php if ('cancelled_subscription' != $email->id) : ?>
    <?php if ('order' == $order_type) : ?>

        <?php if ($sent_to_admin) : ?>
            <tr>
                <td align="center" valign="top" style="padding-bottom:30px;padding-left:20px;padding-right:20px;"
                    class="subTitle">
                    <!-- Sub Title Text // -->
                    <h4 class="text font-primary">
                        <a href="<?php echo esc_url($link_element_url); ?>">

                            <?php printf(__('Order ID.', 'matat')); ?>  <?php echo $order->get_order_number(); ?>

                            | <?php printf(__('Order Date', 'matat')); ?>
                            : <?php printf('<time datetime="%s">%s</time>', $order->get_date_created()->format('c'), wc_format_datetime($order->get_date_created())); ?>

                        </a>
                    </h4>
                </td>
            </tr>
        <?php else : ?>

            <tr>
                <td align="center" valign="top" style="padding-bottom:30px;padding-left:20px;padding-right:20px;"
                    class="subTitle">
                    <!-- Sub Title Text // -->
                    <h4 class="text font-primary">
                        <a href="<?php echo esc_url($link_element_url); ?>">

                            <?php printf(__('Order ID.', 'matat')); ?>  <?php echo $order->get_order_number(); ?>
                            | <?php printf(__('Order Date', 'matat')); ?>
                            : <?php printf('<time datetime="%s">%s</time>', $order->get_date_created()->format('c'), wc_format_datetime($order->get_date_created())); ?>

                        </a>
                    </h4>
                </td>
            </tr>

        <?php endif; ?>

    <?php else : ?>

        <?php if ($sent_to_admin) : ?>
            <tr>
                <td align="center" valign="top" style="padding-bottom:30px;padding-left:20px;padding-right:20px;"
                    class="subTitle">
                    <!-- Sub Title Text // -->
                    <h4 class="text font-primary">
                        <a href="<?php echo esc_url($link_element_url); ?>">

                            <?php printf(__('Order ID.', 'matat')); ?>  <?php echo $order->get_order_number(); ?>
                            | <?php printf(__('Order Date', 'matat')); ?>
                            : <?php printf('<time datetime="%s">%s</time>', $order->get_date_created()->format('c'), wc_format_datetime($order->get_date_created())); ?>

                        </a>
                    </h4>
                </td>
            </tr>
        <?php else : ?>
            <tr>
                <td align="center" valign="top" style="padding-bottom:30px;padding-left:20px;padding-right:20px;"
                    class="subTitle">
                    <!-- Sub Title Text // -->
                    <h4 class="text font-primary">
                        <?php printf(__('Subscription ID #%s', 'Used in email notification', 'matat'), $order->get_order_number()); ?>
                    </h4>
                </td>
            </tr>
        <?php endif; ?>

    <?php endif; ?>
<?php endif; ?>

<?php if ('order' == $order_type) : ?>
    <?php echo wc_get_email_order_items($order, array(
        'show_sku' => $sent_to_admin,
        'show_image' => true,
        'image_size' => array(140, 140),
        'plain_text' => $plain_text,
        'sent_to_admin' => $sent_to_admin,
    )); ?>
<?php else : ?>
    <?php echo wp_kses_post(WC_Subscriptions_Email::email_order_items_table($order, $order_items_table_args)); ?>
<?php endif; ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTotalTitle">
    <tr>
        <td align="center" valign="top" style="padding-bottom:20px;" class="totalTitle">
            <!-- Total Title Text // -->

            <?php
            if ($totals = $order->get_order_item_totals()) {
                $numItems = count($totals);
                $i = 0;
                foreach ($totals as $total) {
                    $i++;
                    if ($i === $numItems) {
                        echo '<h2 class="totalTitle font-primary" style="font-size:20px;font-weight:600;font-style:normal;letter-spacing:normal;line-height:28px;text-transform:none;text-align:center;padding:0;margin:0;padding-bottom: 20px;">' . $total['label'] . '&nbsp;<strong>' . $total['value'] . '</strong></h2>';
                    } else {
                        echo '<p class="smlTotalTitle font-primary" style="font-size: 14px; font-weight: 600; font-style: normal; letter-spacing: normal; line-height: 22px; text-transform: none; text-align: center; padding: 0; margin: 0; padding-bottom: 10px;">' . $total['label'] . '&nbsp;<strong>' . $total['value'] . '</strong></p>';
                    }
                }
            }
            ?>
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

<?php do_action('woocommerce_email_after_' . $order_type . '_table', $order, $sent_to_admin, $plain_text, $email); ?>
