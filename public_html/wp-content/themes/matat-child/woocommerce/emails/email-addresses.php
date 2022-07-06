<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
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
 * @version     3.5.4
 */

if (!defined('ABSPATH')) {
    exit;
}

$text_align = is_rtl() ? 'right' : 'left';

?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
    <?php if (!wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ($shipping = $order->get_formatted_shipping_address())) : ?>
        <tr>
            <td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">

                <!-- Medium Title Text // -->
                <p class="text font-primary"
                   style="font-size: 18px; font-weight: 500; font-style: normal; letter-spacing: normal; line-height: 26px; text-transform: none; text-align: center; padding: 0; margin: 0;">
                    <?php printf(__('Billing Address', 'matat')); ?>:
                </p>
            </td>
        </tr>

        <tr>
            <td align="center" valign="top" style="padding-bottom:20px;" class="description">
                <!-- Description Text// -->
                <p class="text">
                    <?php echo '<strong>' . $order->get_billing_first_name() . '&nbsp;' . $order->get_billing_last_name() . '</strong>'; ?>
                    <?php if ($order->get_billing_company()) : ?>
                        <strong>&nbsp;(&nbsp;<?php echo $order->get_billing_company(); ?>&nbsp;)</strong>
                    <?php endif; ?>
                    <?php

                    echo '<br>' . $order->get_shipping_address_1() . ',&nbsp;' . $order->get_shipping_address_2() . ',&nbsp;' . $order->get_shipping_city() . ',&nbsp;' . $order->get_billing_state() . ',&nbsp;' . $order->get_shipping_postcode() . ',&nbsp;' . $order->get_shipping_country() . '&nbsp;';
                    ?>
                    <?php if ($order->get_billing_phone()) : ?>
                        <br><strong><?php printf(__('Phone', 'matat')); ?>:</strong>&nbsp;<a
                                href="tel:<?php echo $order->get_billing_phone(); ?>"><?php echo $order->get_billing_phone(); ?></a>&nbsp;
                    <?php endif; ?>
                    <?php if ($order->get_billing_email()) : ?>
                        <strong><?php printf(__('Email', 'matat')); ?>:</strong>&nbsp;<a
                                href="mailto:<?php echo $order->get_billing_email(); ?>"><?php echo $order->get_billing_email(); ?></a>&nbsp;
                    <?php endif; ?>

                </p>
            </td>
        </tr>
    <?php endif; ?>


    <?php if (!wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ($shipping = $order->get_formatted_shipping_address())) : ?>
        <tr>
            <td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
                <!-- Medium Title Text // -->
                <p class="text font-primary"
                   style="font-size: 18px; font-weight: 500; font-style: normal; letter-spacing: normal; line-height: 26px; text-transform: none; text-align: center; padding: 0; margin: 0;">
                    <?php printf(__('Shipping Address', 'matat')); ?>:
                </p>
            </td>
        </tr>

        <tr>
            <td align="center" valign="top" style="padding-bottom:20px;" class="description">
                <!-- Description Text// -->
                <p class="text">
                    <?php echo '<strong>' . $order->get_shipping_first_name() . '&nbsp;' . $order->get_shipping_last_name() . '</strong>'; ?>
                    <?php if ($order->get_shipping_company()) : ?>
                        <strong>&nbsp;(&nbsp;<?php echo $order->get_shipping_company(); ?>&nbsp;)</strong>
                    <?php endif; ?>
                    <?php

                    echo '<br>' . $order->get_shipping_address_1() . ',&nbsp;' . $order->get_shipping_address_2() . ',&nbsp;' . $order->get_shipping_city() . ',&nbsp;' . $order->get_billing_country() . ',&nbsp;' . $order->get_shipping_postcode() . ',&nbsp;' . $order->get_shipping_country() . '&nbsp;';
                    ?>
                    <?php if ($order->get_billing_phone()) : ?>
                        <br><strong><?php printf(__('Phone', 'matat')); ?>:</strong>&nbsp;<a
                                href="tel:<?php echo $order->get_billing_phone(); ?>"><?php echo $order->get_billing_phone(); ?></a>&nbsp;
                    <?php endif; ?>
                    <?php if ($order->get_billing_email()) : ?>
                        <strong><?php printf(__('Email', 'matat')); ?>:</strong>&nbsp;<a
                                href="mailto:<?php echo $order->get_billing_email(); ?>"><?php echo $order->get_billing_email(); ?></a>&nbsp;
                    <?php endif; ?>
                </p>
            </td>
        </tr>
    <?php endif; ?>
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