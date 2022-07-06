<?php
/**
 * WooCommerce Memberships
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Memberships to newer
 * versions in the future. If you wish to customize WooCommerce Memberships for your
 * needs please refer to http://docs.woothemes.com/document/woocommerce-memberships/ for more information.
 *
 * @package   WC-Memberships/Templates
 * @author    SkyVerge
 * @copyright Copyright (c) 2014-2016, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_path	=	get_stylesheet_directory_uri().'/woocommerce/emails/images'; // Image Path


/**
 * Membership renewal reminder email
 *
 * @type string $email_heading Email heading
 * @type string $email_body Email body
 * @type \WC_Memberships_User_Membership $user_membership User Membership
 *
 * @version 1.7.0
 * @since 1.7.0
 */

	do_action( 'woocommerce_email_header', $email_heading );
 ?>

  <tr>
	<td align="center" valign="top" style="padding-bottom:20px" class="imgHero">
		<!-- Hero Image // -->
		<a href="#" target="_blank" style="text-decoration:none;">
			<img src="<?php echo $theme_path . '/membership-reminder.png' ; ?>" width="600" alt="" border="0" style="width:100%; max-width:600px; height:auto; display:block;" />
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
			<?php printf( __( 'Reminder for Membership Renewal', 'woocommerce-memberships' )); ?>
		</h4>
	</td>
</tr>


<tr>
	<td align="center" valign="top" style="padding-left:20px;padding-right:20px;" class="containtTable">


	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTitleDescription">
		<tr>
			<td align="center" valign="top" style="padding-bottom:10px;" class="mediumTitle">
				<!-- Medium Title Text // -->
				<p class="text font-primary">
					<?php printf( __( 'Your Membership Details', 'woocommerce-memberships' ))?>
				</p>
			</td>
		</tr>
		<tr>
			<td align="center" valign="top" style="padding-bottom:20px;" class="description">
				<!-- Description Text// -->
				<p class="text font-secondary">
					<blockquote><?php echo $email_body; ?></blockquote>
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
							<a class="text font-secondary" href="<?php echo esc_url(get_home_url()); ?>" target="_blank">
								<?php printf(  __( 'Renewal Order', 'woocommerce-memberships' ) ); ?>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

<?php do_action( 'woocommerce_email_footer' );