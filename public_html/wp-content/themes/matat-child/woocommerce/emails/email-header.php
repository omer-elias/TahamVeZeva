<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$theme_path = get_stylesheet_directory_uri() . '/woocommerce/emails/images'; // Image Path

$logoWidth = "170"; // Logo Width in Pixels Dont Add px, em, % Just Add Number

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office" <?php language_attributes(); ?>>
<head>
    <!--[if (gte mso 9)|(IE)]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="date=no">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="email=no">

    <title><?php echo get_bloginfo('name', 'display'); ?></title>

    <!-- Google Fonts Link -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>

<body>
<center>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;"
           id="bodyTable">
        <tr>
            <td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="600">
                    <tr>
                        <td align="center" valign="top"><![endif]-->

                <!-- Email Header Space Open //-->
                <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"
                       class="wrapperWebview">
                    <tr>
                        <td align="center" valign="top">
                            <!-- Content Table Open // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                <tr>
                                    <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                </tr>
                                </tr>
                            </table>
                            <!-- Content Table Close // -->
                        </td>
                    </tr>
                </table>
                <!-- Email Header Space Close //-->

                <!-- Email Wrapper Body Open // -->
                <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"
                       class="wrapperBody">
                    <tr>
                        <td align="center" valign="top">

                            <!-- Table Card Open // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard">

                                <tr>
                                    <!-- Header Top Border // -->
                                    <td height="3" class="topBorder">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="center" valign="middle" style="padding-top:60px;padding-bottom:20px"
                                        class="emailLogo">
                                        <!-- Logo and Link // -->
                                        <?php
                                        if ($img = get_option('woocommerce_email_header_image')) {
                                            echo '<a href="' . get_home_url() . '" style="text-decoration:none;" ><img src="' . esc_url($img) . '" width="' . $logoWidth . '" alt="' . get_bloginfo('name', 'display') . '" border="0" style="width:100%;max-width:' . $logoWidth . 'px;height:auto; display:block;" /></p>';
                                        } else {
                                            echo '<h2 class="text font-primary"><a style="text-decoration:none;" href="' . get_home_url() . '">' . get_bloginfo('name', 'display') . '</a></h2>';
                                        }
                                        ?>
                                    </td>
                                </tr>

						

						