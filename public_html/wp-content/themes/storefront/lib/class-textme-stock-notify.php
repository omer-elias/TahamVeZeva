<?php

use Spatie\ArrayToXml\ArrayToXml;

class Textme_Stock_Notify {

	const NONCE = 'matat-notify';

	const META = 'matat_stock_phone_alerts';

	public function __construct() 
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'load_front_assets' ), 100 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
		add_filter( 'woocommerce_get_stock_html', array( $this, 'insert_stock_form' ), 20, 2 );
		add_action( 'wp_ajax_matat_stock_notify', array( $this, 'stock_notify_submit' ) );
		add_action( 'wp_ajax_nopriv_matat_stock_notify', array( $this, 'stock_notify_submit' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_notify_meta' ) );
		add_action( 'wp_ajax_send_bulk_sms', array( $this, 'send_bulk_sms' ) );
		add_action( 'wp_ajax_matat_stock_notify_reset', array( $this, 'matat_stock_notify_reset' ) );
	}

	function load_front_assets() {
		if ( ! is_product() ) {
			return;
		}

		wp_register_script( 'matat-stock-notify', get_stylesheet_directory_uri() . '/assets/js/stock-notify-front.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'matat-stock-notify' );
	}

	function load_admin_assets() {
		wp_register_script( 'matat-stock-notify', get_stylesheet_directory_uri() . '/assets/js/stock-notify-admin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-dialog' ), false, true );
		//wp_localize_script( 'matat-stock-notify', 'matat', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( 'matat-stock-notify' );
	}

	function insert_stock_form( $html, $product) {
		$availability = $product->get_availability();

		if ( $availability['class'] == 'out-of-stock' ) {
			ob_start();
			?>
			<div class="stock-alert-row">
				<strong class="stock-alert-title">המוצר חסר במלאי! רוצה לקבל עדכון כשהוא חוזר?</strong>
				<div class="matat-stock-notify-form">

					<div class="input-wrap">
						<input type="text" class="form-control" id="stock-phone" name="phone" placeholder="מס׳ טלפון" required>
					</div>
					<div class="btn-wrap">
						<button
						data-product_id="<?php echo get_the_ID(); ?>" 
						data-action="<?php echo 'matat_stock_notify'; ?>"
						data-security="<?php echo wp_create_nonce( Textme_Stock_Notify::NONCE ); ?>"
						data-id="<?php echo get_the_ID(); ?>" class="btn btn-primary matat-stock-notify-submit submit"
						type="submit">
						<span class="spinner-border spinner-border-sm hidden" role="status" aria-hidden="true"></span>
						סמסו לי כשיגיע
					</button>
				</div>
			</div>
			<div class="alert"></div>
		</div>
		<?php
		$html = ob_get_clean();
	}

	return $html;
}

function stock_notify_submit() {

	$this->verify_nonce();

	$product_id = absint( $_POST['product_id'] );
	$phone = str_replace( array( '-', ' '), '', sanitize_text_field( $_POST['phone'] ) );
	$variationSelect = $_POST['variationSelect'];
	$alerts = (array)get_post_meta( $product_id, self::META, true );

	$phone_numbers = array();
	foreach ($alerts as $als) {
		if('array' == gettype($als)){
			$phone_numbers[] = $als[0];
		}else{
			$phone_numbers[] = $als;
		}
	}

	if ( empty( $phone ) ) {
		wp_send_json_error( 'טלפון הוא שדה חובה.');
	}

	if ( in_array( $phone, $alerts ) ) {
		wp_send_json_error( sprintf( 'ישנו כבר עידכון למספר הטלפון: %s', $phone) );
	}

	$phone_data = array($phone,$variationSelect);
	$alerts[] = $phone_data;
	update_post_meta( $product_id, self::META, $alerts );

	wp_send_json_success( 'אנו נודיע לך ברגע שהמוצר יחזור למלאי, תודה.');
}

function matat_stock_notify_reset() {

	$this->verify_nonce();

	$product_id = $_POST['data']['post_id'];
	if ( isset( $_POST['data']['dIndex'] ) && ! empty( $_POST['data']['dIndex'] ) ) {
		$data = $_POST['data']['dIndex'];

		$alerts = (array)get_post_meta( $product_id, self::META, true );
		foreach ( $data as $dIndex ) {
			unset($alerts[$dIndex]);
		}
		update_post_meta( $product_id, self::META, array_filter( $alerts ) );

	} else {
	        //delete_post_meta( absint( $_POST['data']['post_id'] ), self::META );
	}

	echo 'נתונים נמחקו בהצלחה.';
	die();
}


function send_bulk_sms() {

	$this->verify_nonce();

	require_once 'ArrayToXml.php';

	$post_id = absint( $_POST['data']['post_id'] );
	$dIndex_data = array();
	if ( isset( $_POST['data']['dIndex'] ) && ! empty( $_POST['data']['dIndex'] ) ) {
		$dIndex_data = $_POST['data']['dIndex'];
	}

	if ( isset( $_POST['data']['sms'] ) && ! empty( $_POST['data']['sms'] ) ) {
		$data = $_POST['data']['sms'];
	} else {
		$data = get_post_meta( $post_id, self::META, true );
	}

	$phones = array();
	foreach ( $data as $phone ) {
		if ( in_array( $phone, $phones ) || empty( $phone ) ) {
			continue;
		}
		$phones[] = str_replace( array('972','-', ' '), '', $phone );
	}

	$message = sanitize_textarea_field( $_POST['data']['message'] );
	$message = str_replace( '{{PRODUCT_NAME}}', get_the_title( $post_id ), $message );
	$message = str_replace( '{{PRODUCT_URL}}', urlencode( get_permalink( $post_id ) ), $message );

	$account = get_option('textme_sms_account');

	$base = array(
		'user' => array(
			'username' => $account['sms_user_name'],
			'password' => $account['sms_pass'],
		),
		'messages' => array(
			'sms' => array(
				'source' => $account['sms_from'],
				'destinations' => array(
					'phone' => $phones
				),
				'message' => $message
			)
		),
	);

	$result = ArrayToXml::convert($base, 'bulk', true, 'UTF-8');

	$args = array(
		'body' => $result,
		'headers' => array(
			"Cache-Control: no-cache",
			"Content-Type: application/xml"

		),
	);
	$response = wp_remote_post( 'https://my.textme.co.il/api', $args );

	$message = 'sms נשלח בהצלחה';

	if ( is_wp_error( $response ) ) {
		$message = 'sms אירעה שגיאה בשליחת￿￿￿ ' . $response->get_error_message();
	}

	$http_code = wp_remote_retrieve_response_code( $response );
	if ( $http_code !== 200 ) {
		$message = 'אירעה שגיאת שרת קוד: ' . $http_code;
	}

	if( (!is_wp_error($response)) && ($http_code==200) ){
		$alerts = (array)get_post_meta( $post_id, self::META, true );
		foreach ( $dIndex_data as $dIndex ) {
			unset($alerts[$dIndex]);
		}
		update_post_meta( $post_id, self::META, array_filter( $alerts ) );
	}

	echo $message;
	die();

}

function add_notify_meta() {
	add_meta_box( 'matat_out_of_stock_notify', 'רשימת ניידים לקבלת עידכון על מלאי למוצר', array( $this, 'render_metabox' ), 'product' );
}

function render_metabox($post) {
	$alerts = get_post_meta( $post->ID, self::META, true );

	if ( ! $alerts ) {
		return;
	}

	wp_nonce_field(Textme_Stock_Notify::NONCE, 'security' );
	?>
	<table class="matat-stock-notify-list widefat">
		<thead>
			<tr>
				<th><input type="checkbox" class="select_all_num" /></th>
				<th>מספר טלפון נייד</th>
				<th> צבע  </th>
                <th>  מידה  </th>
				<th>
					<button class="button matat-stock-notify-sms" data-post_id="<?php echo $post->ID; ?>">
						שליחת sms
						<span class="spinner" style="display: none;"></span>
					</button>
					<button class="button matat-stock-notify-reset" data-post_id="<?php echo $post->ID; ?>">
						מחיקת מספרי הטלפון
						<span class="spinner" style="display: none;"></span>
					</button>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$alerts = array_filter($alerts);
			foreach ( $alerts as $key=>$alert ) : ?>
				<tr>
					<td><input type="checkbox" data-index="<?php echo esc_attr($key);?>" class="individual_num" name="select_all_num[]" value="<?php echo ('array'==gettype($alert))?$alert[0]:$alert; ?>" /></td>
					<td><?php echo ('array'==gettype($alert))?$alert[0]:$alert; ?></td>
					<?php
					if('array'==gettype($alert)){
						foreach ($alert[1] as $variations) {
							if( (gettype($variations)=='array') && ($variations!=null) ){
								foreach ($variations as $value) {
									echo '<td>'.$value[1].'</td>';
								}                                
							}
						}
					}else{
						echo '<td></td>';
					}
					?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div id="sms-dialog" class="matat-dialog" style="display: none;">
		<p>
			משתנים לשימוש:
			<ul>
				<li>{{PRODUCT_NAME}} - שם המוצר</li>
				<li>{{PRODUCT_URL}} - קישור למוצר</li>
			</ul>
		</p>
		<?php
		$message = "שלום,\r\n";
		$message .= "ביקשת שנודיע לך שהמוצר {{PRODUCT_NAME}} חזר למלאי.\r\n";
		$message .= "אפשר לבצע רכישה בקישור הבא: {{PRODUCT_URL}}\r\n";
		?>
		<textarea name="sms-message" id="sms-body" placeholder="גוף ההודעה" maxlength="512" style="width: 100%; height: 100px;"><?php echo $message; ?></textarea>
	</div>
	<?php
}

function verify_nonce() {
	if ( ! wp_verify_nonce( $_POST['security'],self::NONCE ) ) {
		wp_send_json_error( 'שגיאת אבטחה' );
	}
}
}

new Textme_Stock_Notify();