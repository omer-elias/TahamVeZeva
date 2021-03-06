<?php

use Matat\Matat_Site_Management;


class Matat_Order_Management extends Matat_Site_Management {

// Actions and filters
	public function __construct() {
		add_action( 'init', array( $this, 'matat_register_custom_order_status' ) );
		add_filter( 'wc_order_statuses', array( $this, 'custom_order_status' ) );
		add_action( 'woocommerce_checkout_create_order', array( $this, 'matat_add_delivery_date_meta' ), 20, 2 );
		add_filter( 'woocommerce_billing_fields', array( $this, 'matat_display_custom_billing_field' ), 20, 1 );
		add_filter( 'pre_get_posts', array( $this, 'matat_custom_post_sort' ) );
		add_filter( 'bulk_actions-edit-shop_order', array( $this, 'matat_order_status_bulk_actions' ) );
		add_filter( 'handle_bulk_actions-edit-shop_order', array( $this, 'matat_bulk_status_action_handler' ), 10, 3 );
		add_filter( 'manage_edit-shop_order_columns', array( $this, 'matat_custom_shop_order_column' ), 10, 1 );
		add_action( 'manage_shop_order_posts_custom_column', array($this,'matat_custom_shop_order_list_column_content'), 10, 2 );
		add_action( 'woocommerce_checkout_update_order_meta', array($this,'matat_check_if_has_production_products'), 10, 2 );
		add_filter( 'woocommerce_order_item_display_meta_key', array($this,'matat_order_item_display_meta_key'), 10, 3 );
		add_filter( 'woocommerce_order_item_display_meta_value', array($this,'matat_order_item_display_meta_value'), 10, 3 );
		add_filter( 'woocommerce_order_item_name', array($this,'update_order_item_name_custom'), 20, 3 );
		add_filter( 'woocommerce_shop_order_search_fields', array($this,'woocommerce_shop_order_search_order_total') );

	}

	function woocommerce_shop_order_search_order_total( $search_fields ) {
		$search_fields[] = 'production_order';
		return $search_fields;
	}

	function order_splitter($order_id){
		$completed_order = new WC_Order($order_id);
		$item_splitted = false;

		$address = array(
			'first_name' => $completed_order->get_billing_first_name(),
			'last_name'  => $completed_order->get_billing_last_name(),
			'company'    => '',
			'email'      => $completed_order->get_billing_email(),
			'phone'      => $completed_order->get_billing_phone(),
			'address_1'  => $completed_order->get_billing_address_1(),
			'address_2'  => $completed_order->get_billing_address_2(),
			'city'       => $completed_order->get_billing_city(),
			'state'      => $completed_order->get_billing_state(),
			'postcode'   => $completed_order->get_billing_postcode(),
			'country'    => $completed_order->get_billing_country()
		);

		$new_order_args = array(
			'customer_id' => $completed_order->get_customer_id(),
			'status' => 'wc-pending',
		);
		$production_branch_id = get_field( 'production_branch', 'options' )->ID;

		//create new order
		$new_order = wc_create_order($new_order_args);

		foreach($completed_order->get_items() as $item){
			$is_prod = $item->get_meta('need_production');
			if ($is_prod) {
				$item_product = $item->get_product();
				$product_id   = $item_product->get_id();

				$product_to_add = wc_get_product($product_id);
				$new_order->add_product($product_to_add, 1, array());
				$new_order->set_address($address, 'billing');
				$new_order->set_address($address, 'shipping');
				$new_order->update_status('wc-processing');
				$new_order->add_order_note(sprintf('?????????? ???????? - ???????????? ???????????? %s', $completed_order->get_id(), ) );
				$new_order->set_total(0);
				$new_order->save();
				$new_order->add_meta_data( 'branch_id', $production_branch_id, false );
				$new_order->add_meta_data( 'production_order', $completed_order->get_id(), false );
				$new_order->add_meta_data( 'supply_date', $completed_order->get_meta( 'supply_date' ), false );
				$completed_order->remove_item($item->get_id());
				$item_splitted = true;
			}
		}
		return $new_order;
	}



	function matat_order_item_display_meta_value( $meta_value, $meta_object, $order_item ) {

		if ( is_admin()  ) {
			if($meta_value==1)
			{
				$meta_value='????';
			}
		}
		return $meta_value;
	}

	function matat_order_item_display_meta_key( $display_key, $meta, $item  ) {

		if( $meta->key === 'need_production' && is_admin() )
		{
			$display_key = __( '???????? ???????? ????????????', 'woocommerce' );

		}
		return $display_key;
	}


//	Create post status
	function matat_register_custom_order_status() {
		$order=wc_get_order(241);
			register_post_status( 'wc-prepare', array(
			'label'                     => '??????????',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( '?????????? <span class="count">(%s)</span>', '?????????? <span class="count">(%s)</span>' )
		) );
		register_post_status( 'wc-waiting-likut', array(
			'label'                     => '?????????? ????????????',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( '?????????? ???????????? <span class="count">(%s)</span>', '?????????? ???????????? <span class="count">(%s)</span>' )
		) );
		register_post_status( 'wc-likut', array(
			'label'                     => '????????????',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( '???????????? <span class="count">(%s)</span>', '???????????? <span class="count">(%s)</span>' )
		) );
	}

//	Register order status
	function custom_order_status( $order_statuses ) {
		$order_statuses['wc-prepare']       = _x( '??????????', 'Order status', 'woocommerce' );
		$order_statuses['wc-waiting-likut'] = _x( '?????????? ????????????', 'Order status', 'woocommerce' );
		$order_statuses['wc-likut']         = _x( '????????????', 'Order status', 'woocommerce' );

		return $order_statuses;
	}

//	Create button to change status on bulk
	function matat_order_status_bulk_actions( $bulk_array ) {
		$bulk_array['prepare']       = '?????????? ???????? ??"??????????"';
		$bulk_array['waiting-likut'] = '?????????? ???????? ??"?????????? ????????????"';
		$bulk_array['likut']         = '?????????? ???????? ??"????????????"';

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


//	Add meta for order supply date
	function matat_add_delivery_date_meta( $order, $data ) {
		var_dump(strtotime($data['supply_date']));
		$unix= strtotime($data['supply_date']);
		if ( $unix ) {
			$order->update_meta_data( 'supply_date', $unix );
		}
		else{
			$order->update_meta_data( 'supply_date', '???? ???????? ??????????' );

		}
		if ( $data['branch'] ) {
			$order->add_meta_data( 'branch_id', intval($data['branch']), false );
		}else{
			$order->add_meta_data( 'branch_id', '???? ???????? ????????', false );

		}

	}

	function matat_check_if_has_production_products( $order_id ) {
		$order                = wc_get_order( $order_id );
		$cats_production_arr  = [];
		$is_production        = false;
		$production_branches  = get_field( 'production_branch_cats', 'options' );
		$production_branch_id = get_field( 'production_branch', 'options' )->ID;

		if ( $production_branches ) {
			foreach ( $production_branches as $cat ) {
				$cats_production_arr[] = $cat;
			}
		}

		foreach ( $order->get_items() as $item_key => $item_values ) {
			$term_ids     = array();
			$item_product = $item_values->get_product();
			$product_id   = $item_product->get_id();
			$item_product->get_type();
			if ( $item_product->get_type() == 'variation' ) {
				$product_id = $item_product->get_parent_id();
			}
			$terms = get_the_terms( $product_id, 'product_cat' );
			if ( ! is_wp_error( $terms ) ) {

				foreach ( $terms as $term ) {
					$term_ids[] = $term->term_id;
				}
			}

			$has_production_item = array_intersect( $cats_production_arr, $term_ids );
			if ( $has_production_item ) {
				$is_production = true;
				$meta_key      = 'need_production';
				$meta_value    = true;
				wc_add_order_item_meta( $item_key, $meta_key, $meta_value );
			}
		}


		if ( $is_production ) {
			var_dump($this->order_splitter( $order_id)->get_id());

			add_post_meta( $order->get_id(), 'supply_date', '37' );
			$order = wc_get_order($order->get_id());
			var_dump(get_post_meta( $order->get_id(), 'branch_id', true ));
		}

	}


//	Sort admin order by Supply date

	function matat_custom_post_sort( $query ) {

		global $current_user; //get the current user
		$user_role = $current_user->roles[0]; //display the current user's role
		global $pagenow;
		$qv        = &$query->query_vars;
		$user_id   = 'user_' . get_current_user_id();
		$condition = $pagenow == 'edit.php' && isset( $qv['post_type'] ) && $qv['post_type'] == 'shop_order';
		$branch_id = get_field( 'user_branches', $user_id );

		if ( $condition ) {
			$query->set( 'meta_key', 'supply_date' );
			$query->set( 'orderby', 'meta_value' );
			$query->set( 'order', 'ASC' );

		}
		if ( $condition && $user_role != 'administrator' ) {
			$query->set( 'meta_query', array(
				array(
					'key'     => 'branch_id',
					'value'   => $branch_id,
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
			'label'    => '?????????? ????????????',
			'class'    => array( 'form-row-wide' ),
			'priority' => 25,
			'required' => false,
			'clear'    => true,
		);
		$billing_fields['branch']      = array(
			'type'     => 'select',
			'label'    => '?????? ???????? ????????????',
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
			'blank' => '?????? ????????',
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
		$columns['supply_date'] = __( '?????????? ??????????', 'matat' );
		$columns['branch']      = __( '????????', 'matat' );

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
					$date           = date_create( $supply_date );
					$formatted_date = date_format( $date, 'd/m/Y' );
					echo gmdate('d-m-Y',$supply_date);
				} else {
					// Output
					echo __( '???? ???????? ?????????? ??????????', 'matat' );
				}
			}
			if ( $column == 'branch' ) {
				// Get meta, use the correct meta key!
				$branch = $order->get_meta( 'branch_id' );

				// NOT empty
				if ( ! empty( $branch ) ) {
					// Output
					echo get_post( $branch )->post_title;
				} else {
					// Output
					echo __( '???? ???????? ????????', 'matat' );
				}
			}
			if ( $column == 'order_number' ) {
				// Get meta, use the correct meta key!
				$is_prod = $order->get_meta( 'production_order' );

				// NOT empty
				if ( $is_prod  ) {
					// Output
					echo '  ?????????? ????????  -  ' . $is_prod . ' ';
				} else {
					// Output
				}
			}



		}
	}
}

new Matat_Order_Management();