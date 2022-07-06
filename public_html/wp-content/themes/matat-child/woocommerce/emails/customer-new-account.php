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
$banner = $theme_path . '/user-account.png';

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
			<?php printf( __( 'Getting Started With %1$s', 'matat' ), esc_html( $blogname )); ?>
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
						<?php printf( __( 'Thanks for creating an account on %1$s. Your username is %2$s', 'matat' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>' ); ?>
					</p>
				</td>
			</tr>

			<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>
			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php printf( __( 'Your password has been automatically generated: %s', 'matat' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?>
					</p>
				</td>
			</tr>
			<?php endif; ?>

			<tr>
				<td align="center" valign="top" style="padding-bottom:20px;" class="description">
					<!-- Description Text// -->
					<p class="text font-secondary">
						<?php printf( __( 'You can access your account area to view your orders and change your password here: %s.', 'matat' ), make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); ?>
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
								<a class="text font-primary" href="<?php echo esc_url(get_home_url()); ?>" target="_blank">
									<?php printf(  __( 'Explore Now', 'matat' ) ); ?>
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

<?php do_action( 'woocommerce_email_footer', $email );
