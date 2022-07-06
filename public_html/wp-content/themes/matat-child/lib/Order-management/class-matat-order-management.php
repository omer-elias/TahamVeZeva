<?php

use Matat\Matat_Site_Management;


class Matat_Order_Management extends Matat_Site_Management {

// Actions and filters
	public function __construct() {
		add_action( 'init', array( $this, 'matat_register_custom_order_status' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_front_assets' ), 100 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
		add_filter( 'wc_order_statuses', array( $this, 'custom_order_status' ) );
		add_action( 'woocommerce_checkout_create_order', array( $this, 'matat_add_delivery_date_meta' ), 20, 2 );
		add_filter( 'woocommerce_billing_fields', array( $this, 'matat_display_custom_billing_field' ), 20, 1 );
		add_filter( 'pre_get_posts', array( $this, 'matat_custom_post_sort' ) );
		add_filter( 'bulk_actions-edit-shop_order', array( $this, 'matat_order_status_bulk_actions' ) );
		add_filter( 'handle_bulk_actions-edit-shop_order', array( $this, 'matat_bulk_status_action_handler' ), 10, 3 );
		add_filter( 'manage_edit-shop_order_columns', array($this,'matat_custom_shop_order_column'), 10, 1 );
		add_action( 'manage_shop_order_posts_custom_column' , array($this,'matat_custom_shop_order_list_column_content'), 10, 2 );


	}

//	Create post status
	function matat_register_custom_order_status() {
		register_post_status( 'wc-prepare', array(
			'label'                     => 'בהכנה',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'בהכנה <span class="count">(%s)</span>', 'בהכנה <span class="count">(%s)</span>' )
		) );
		register_post_status( 'wc-waiting-likut', array(
			'label'                     => 'ממתין לליקוט',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'ממתין לליקוט <span class="count">(%s)</span>', 'ממתין לליקוט <span class="count">(%s)</span>' )
		) );
		register_post_status( 'wc-likut', array(
			'label'                     => 'בליקוט',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'בליקוט <span class="count">(%s)</span>', 'בליקוט <span class="count">(%s)</span>' )
		) );
	}

//	Register order status
	function custom_order_status( $order_statuses ) {
		$order_statuses['wc-prepare']       = _x( 'בהכנה', 'Order status', 'woocommerce' );
		$order_statuses['wc-waiting-likut'] = _x( 'ממתין לליקוט', 'Order status', 'woocommerce' );
		$order_statuses['wc-likut']         = _x( 'בליקוט', 'Order status', 'woocommerce' );

		return $order_statuses;
	}

//	Create button to change status on bulk
	function matat_order_status_bulk_actions( $bulk_array ) {
		$bulk_array['prepare']       = 'שינוי המצב ל"בהכנה"';
		$bulk_array['waiting-likut'] = 'שינוי המצב ל"ממתין לליקוט"';
		$bulk_array['likut']         = 'שינוי המצב ל"בליקוט"';

		return $bulk_array;

	}

//	Actual change status on bulk
	function matat_bulk_status_action_handler( $redirect, $doaction, $object_ids ) {

		// let's remove query args first
		$redirect = remove_query_arg( array( 'prepare', 'waiting-likut', 'likut' ), $redirect );

		foreach ( $object_ids as $post_id ) {
			$order = wc_get_order( $post_id );
			$order->update_status( 'wc-' . $doaction );
		}

		$redirect = add_query_arg(
			'matat_status_done', // just a parameter for URL (we will use $_GET['misha_make_draft_done'] )
			count( $object_ids ), // parameter value - how much posts have been affected
			$redirect );


		return $redirect;

	}

//	Frontend js and css
	function load_front_assets() {

	}

// Backend js and css
	function load_admin_assets() {

	}

//	Add meta for order supply date
	function matat_add_delivery_date_meta( $order, $data ) {
		$date           = date_create( $data['supply_date'] );
		$formatted_date = date_format( $date, 'd/m/Y' );
		$order->update_meta_data( 'supply_date', $formatted_date );
		$order->update_meta_data( 'branch_id', $data['branch'] );

	}

//	Sort admin order by Supply date

	function matat_custom_post_sort( $query ) {

		global $current_user; //get the current user
		$user_role = $current_user->roles[0]; //display the current user's role
		global $pagenow;
		$qv               = &$query->query_vars;
		$user_id          = 'user_' . get_current_user_id();
		$condition        = $pagenow == 'edit.php' && isset( $qv['post_type'] ) && $qv['post_type'] == 'shop_order';
		$branch_id        = get_field( 'user_branches', $user_id );

		if ( $condition ) {
			$query->set( 'meta_key', 'supply_date' );
			$query->set( 'orderby', 'meta_value' );
			$query->set( 'order', 'ASC' );

		}
		if ( $condition && $user_role != 'administrator' )
		{
			$query->set( 'meta_query', array(
				array(
					'key'   => 'branch_id',
					'value' => $branch_id,
					'compare' => 'IN'
				)
			) );
		}



		return $query;
	}

//  Diplay Checkout fields
	function matat_display_custom_billing_field( $billing_fields ) {

		$billing_fields['supply_date'] = array(
			'type'     => 'date',
			'label'    => 'תאריך למשלוח',
			'class'    => array( 'form-row-wide' ),
			'priority' => 25,
			'required' => false,
			'clear'    => true,
		);
		$billing_fields['branch']      = array(
			'type'     => 'select',
			'label'    => 'בחר סניף למשלוח',
			'options'  => $this->matat_create_branches_array(),
			'class'    => array( 'form-row-wide' ),
			'priority' => 25,
			'required' => false,
			'clear'    => true,
		);

		return $billing_fields;
	}

	// Create array and to send him into billing field
	function matat_create_branches_array() {
		$args      = array( 'post_type' => 'branches' );
		$the_query = new WP_Query( $args );
		$branches  = array(
			'blank' => 'בחר סניף',
		);

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$branches[ get_the_ID() ] = get_the_title();
			}
		}

		return $branches;
	}

	// Add a Header
	function matat_custom_shop_order_column( $columns ) {
		// Add new columns
		$columns['supply_date'] = __( 'תאריך אספקה', 'matat' );
		$columns['branch'] = __( 'סניף', 'matat' );

		return $columns;
	}

	//  Populate the Column
	function matat_custom_shop_order_list_column_content( $column, $post_id ) {
		// Get order object
		$order = wc_get_order( $post_id );

		// Is a WC_Order
		if ( is_a( $order, 'WC_Order' ) ) {
			// Compare column name
			if ( $column == 'supply_date' ) {
				// Get meta, use the correct meta key!
				$supply_date = $order->get_meta( 'supply_date' );

				// NOT empty
				if ( ! empty( $supply_date ) ) {
					// Output
					echo $supply_date;
				} else {
					// Output
					echo __( 'לא נמצא תאריך אספקה', 'matat' );
				}
			}
			if ( $column == 'branch' ) {
				// Get meta, use the correct meta key!
				$branch = $order->get_meta( 'branch_id' );

				// NOT empty
				if ( ! empty( $branch ) ) {
					// Output
					echo get_post($branch)->post_title;
				} else {
					// Output
					echo __( 'לא נבחר סניף', 'matat' );
				}
			}


		}
	}
}

new Matat_Order_Management();