<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
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
    exit; // Exit if accessed directly
}

$theme_path = get_stylesheet_directory_uri() . '/woocommerce/emails/images'; // Image Path

$email_offer_banner_url = get_option('email_banner_url'); // Offer Banner URL
$email_offer_banner_img = get_option('email_banner_image');
$email_facebook_url = get_option('email_facebook_url'); // Facebook URL
$email_twitter_url = get_option('email_twitter_url'); // Twitter URL
$email_instagram_url = get_option('email_instagram_url'); // Instagram URL
$email_pinterest_url = get_option('email_pinterest_url');
$email_appstore_url = get_option('email_appstore_url'); // Appstore URL
$email_playstore_url = get_option('email_playstore_url'); // Playstore URL

?>


</td>
</tr>

<tr>
    <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
</tr>

<tr>
    <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
</tr>
</table>
<!-- Table Card Close// -->

<?php if ($email_offer_banner_url != "") : ?>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
        <tr>
            <td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="offerCard">
        <tr>
            <td align="center" valign="middle">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="offerTable">
                    <tr>
                        <td align="center" valign="middle" class="offerImg">
                            <!-- Offer Banner // -->
                            <?php

                            if ($email_offer_banner_url != "") {
                                echo '<a href="' . $email_offer_banner_url . '" style="text-decoration:none;" ><img src="' . $email_offer_banner_img . '" width="580" alt="Offer" border="0" style="width:100%; max-width:580px;height:auto; display:block;" /></a>';
                            }

                            ?>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

<?php endif; ?>

</td>
</tr>
</table>

<!-- Email Wrapper Footer Open // -->
<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
    <tr>
        <td align="center" valign="top">
            <!-- Content Table Open// -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
                <tr>
                    <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="top"
                        style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;"
                        class="socialLinks">

                        <?php if ($email_facebook_url != "" || $email_twitter_url != "" || $email_instagram_url != "" || $email_pinterest_url != "" ) : ?>

                            <?php

                            if ($email_facebook_url != "") {
                                echo '<a href="' . $email_facebook_url . '" style="display:inline-block;" ><img src="' . $theme_path . '/facebook.png" width="40" height="40" alt="Facebook" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" /></a>';
                            }

                            if ($email_twitter_url != "") {
                                echo '<a href="' . $email_twitter_url . '" style="display:inline-block;" ><img src="' . $theme_path . '/twitter.png" width="40" height="40" alt="Twitter" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" /></a>';
                            }

                            if ($email_instagram_url != "") {
                                echo '<a href="' . $email_instagram_url . '" style="display:inline-block;" ><img src="' . $theme_path . '/instagram.png" width="40" height="40" alt="Instagram" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" /></a>';
                            }

                            if ($email_pinterest_url != "") {
                                echo '<a href="' . $email_pinterest_url . '" style="display:inline-block;" ><img src="' . $theme_path . '/pinterest.png" width="40" height="40" alt="Pinterest" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" /></a>';
                            }


                            ?>

                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td align="center" valign="top"
                        style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;"
                        class="appLinks">
                        <!-- App Links (Anroid)// -->
                        <?php if ($email_appstore_url != "" || $email_playstore_url != "") : ?>

                            <?php

                            if ($email_appstore_url != "") {
                                echo '<a href="' . $email_appstore_url . '" style="display:inline-block;" ><img src="' . $theme_path . '/app-store.png" width="120" alt="App Store" border="0" style="height:auto; margin:5px; width:100%; max-width:120px;" /></a>';
                            }

                            if ($email_playstore_url != "") {
                                echo '<a href="' . $email_playstore_url . '" style="display:inline-block;" ><img src="' . $theme_path . '/play-store.png" width="120" alt="Play Store" border="0" style="height:auto; margin:5px; width:100%; max-width:120px;" /></a>';
                            }
                            ?>

                        <?php endif; ?>
                    </td>
                </tr>


                <!-- Space -->
                <tr>
                    <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                </tr>
            </table>
            <!-- Content Table Close// -->
        </td>
    </tr>

    <!-- Space -->
    <tr>
        <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
    </tr>
</table>
<!-- Email Wrapper Footer Close // -->

<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</table>
</body>
</html>
