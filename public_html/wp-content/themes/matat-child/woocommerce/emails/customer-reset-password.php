<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
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

$theme_path	=	get_stylesheet_directory_uri().'/woocommerce/emails/images'; // Image Path
$banner = $theme_path . '/user-reset-password.png';

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

<tr>
	<td align="center" valign="top" style="padding-bottom:30px;padding-left:20px;padding-right:20px;" class="subTitle">
		<!-- Sub Title Text // -->
		<h4 class="text font-primary">
			<?php printf(  __( 'We\'ve received your request to<br>change your password.', 'matat' ) ); ?>
		</h4>
	</td>
</tr>

<tr>
	<td align="center" valign="top" style="padding-left:20px;padding-right:20px;" class="containtTable">

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php printf(  __( 'Click on the button below to reset your password, you have 24 hours to pick your password. After that, you\'ll have to ask for a new one.', 'matat' ) ); ?>
					</p>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php printf(  __( 'Or using this Link:', 'matat' ) ); ?>
						<a class="link" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'login' => rawurlencode( $user_login ) ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>">

							<?php printf(  __( 'Click here to reset your password', 'matat' ) ); ?>
						</a>
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
								<a class="text font-primary" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'login' => rawurlencode( $user_login ) ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>" target="_blank">
									<?php printf(  __( 'Reset Password', 'matat' ) ); ?>
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

<?php do_action( 'woocommerce_email_footer', $email );
