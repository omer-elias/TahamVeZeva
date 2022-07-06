<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$bg              			= get_option( 'woocommerce_email_background_color' );
$body            			= get_option( 'woocommerce_email_body_background_color' );
$base            			= get_option( 'woocommerce_email_base_color' );
$base_text      			= wc_light_or_dark( $base, '#202020', '#ffffff' );
$text            			= get_option( 'woocommerce_email_text_color' );

$text_darker				= wc_hex_darker( $text, 40 );
$text_lighter				= wc_hex_lighter( $text, 40 );
$text_lighters				= wc_hex_lighter( $text, 60 );
// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
?>

	.font-primary {
		font-family:'Poppins', Helvetica, Arial, sans-serif !important;
	}

	.font-secondary {
		font-family:'Open Sans', Helvetica, Arial, sans-serif !important;
	}

	.wc-item-meta {
		margin-top: 30px;
		padding-bottom: 20px;
		padding-left: 0;
		padding-top: 30px;
		margin-bottom: 30px;
		list-style: none;
		border-top: 1px solid #E5E5E5;
		border-bottom: 1px solid #E5E5E5;
	}

	.wc-item-meta li {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-family:'Poppins', Helvetica, Arial, sans-serif !important;
		font-size:18px;
		font-weight:600;
		font-style:normal;
		letter-spacing:normal;
		line-height:26px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.wc-item-meta li strong{
		font-weight:600;
	}

	.wc-item-meta li p {
		color: <?php echo esc_attr( $text_lighter ); ?> !important;
		font-family:'Poppins', Helvetica, Arial, sans-serif;
		font-size:16px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:22px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
		padding-top:10px;
		padding-bottom:20px;
	}

	.wc-booking-summary-number {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size: 14px;
		font-weight: 600;
		font-style: normal;
		letter-spacing: normal;
		line-height: 22px;
		text-transform: none;
		text-align: center;
		padding: 0;
		margin: 0;
		padding-bottom: 10px;
	}

	.wc-booking-summary-number span.status-confirmed{
		color: <?php echo esc_attr( $body ); ?> !important;
		background-color: <?php echo esc_attr( $base ); ?> !important;
		padding: 5px;
		border-radius: 4px;
	}

	.wc-booking-summary-list {
		margin-top: 10px;
		padding-left: 0;
		margin-bottom: 0px;
		list-style: none;
	}

	.wc-booking-summary-list li{
		color: <?php echo esc_attr( $text_lighter ); ?> !important;
		font-size: 14px;
		font-weight: 600;
		font-style: normal;
		letter-spacing: normal;
		line-height: 22px;
		text-transform: none;
		text-align: center;
		padding: 0;
		margin: 0;
	}

	.wc-booking-summary-actions{
		display:none !important;
	}
	
	#bodyTable, .body {
		background-color: <?php echo esc_attr( $bg ); ?> !important;
	}

	.tableCard,
	.offerCard {
		border-color:#EEEEEE;
		border-style:solid;
		border-width:0 1px 1px 1px;
		background-color: <?php echo esc_attr( $body ); ?> !important;
	}

	.offerTable{
		border:10px solid <?php echo esc_attr( $body ); ?> !important;
		background-color:#EEEEEE;
	}

	.topBorder {
		font-size:1px;
		line-height:3px;
		background-color: <?php echo esc_attr( $base ); ?> !important;
	}

	.mainTitle .text {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:28px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:36px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0 !important;
	}
	
	.emailLogo .text,
	.emailLogo .text a{
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:28px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:36px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0 !important;
	}

	.subTitle .text {
		color: <?php echo esc_attr( $text_lighter ); ?> !important;
		font-size:16px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:24px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0 !important;
	}

	.subTitle .text a{
		color: <?php echo esc_attr( $text_lighters ); ?> !important;
		text-decoration:none !important;
	}

	.mediumTitle .text,
	.smllTitle .text {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:18px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:26px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.smllSubTitle .text {
		color: <?php echo esc_attr( $text_lighter ); ?> !important;
		font-size:16px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:22px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.bigTitle .text {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:28px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:44px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.bigSubTitle .text {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:20px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:28px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.description .text{
		color: <?php echo esc_attr( $text_lighter ); ?> !important;
		font-family:'Open Sans', Helvetica, Arial, sans-serif !important;
		font-size:14px;
		font-weight:400;
		font-style:normal;
		letter-spacing:normal;
		line-height:22px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.description .text a{
		color: <?php echo esc_attr( $text_lighter ); ?> !important;
		text-decoration:none;
	}

	.infoDate .text {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:11px;
		font-weight:700;
		font-style:normal;
		letter-spacing:normal;
		line-height:20px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.ctaButton {
		background-color: <?php echo esc_attr( $base ); ?> !important;
		padding-top:12px;
		padding-bottom:12px;
		padding-left:35px;
		padding-right:35px;
		border-radius:50px;
	}

	.ctaButton a {
		color:#FFFFFF;
		font-family:'Poppins', Helvetica, Arial, sans-serif;
		font-size:13px;
		font-weight:600;
		font-style:normal;
		letter-spacing:1px;
		line-height:20px;
		text-transform:uppercase;
		text-decoration:none;
		display:block;
	}

	.divider {
		background-color:#E5E5E5;
		font-size:1px;
		line-height:1px;
	}

	.productName .text,
	.productQty .text {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:18px;
		font-weight:600;
		font-style:normal;
		letter-spacing:normal;
		line-height:26px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.productPrice .text {
		color: <?php echo esc_attr( $base ); ?> !important;
		font-size:18px;
		font-weight:600;
		font-style:normal;
		letter-spacing:normal;
		line-height:26px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}
	
	.smlTotalTitle .text,
	.smlTotalTitle {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:14px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:22px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.totalTitle .text,
	.totalTitle {
		color: <?php echo esc_attr( $text ); ?> !important;
		font-size:20px;
		font-weight:500;
		font-style:normal;
		letter-spacing:normal;
		line-height:28px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.brandInfo .text,
	.footerLinks .text,
	.footerEmailInfo .text {
		color: <?php echo esc_attr( $text_lighter ); ?> !important;
		font-size:12px;
		font-weight:400;
		font-style:normal;
		letter-spacing:normal;
		line-height:20px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

	.footerLinks .text a,
	.footerEmailInfo .text a {
		color: <?php echo esc_attr( $text_lighter ); ?> !important;
		font-size:12px;
		font-weight:400;
		font-style:normal;
		letter-spacing:normal;
		line-height:20px;
		text-transform:none;
		text-align:center;
		padding:0;
		margin:0;
	}

<?php
