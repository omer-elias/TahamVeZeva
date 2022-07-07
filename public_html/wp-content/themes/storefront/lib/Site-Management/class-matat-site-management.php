<?php

//use Spatie\ArrayToXml\ArrayToXml;
Namespace Matat;

class Matat_Site_Management {


	public function __construct() {
		add_action('init', array($this,'matat_register_types'));
		add_action('init', array($this,'matat_register_roles'));
		add_action( 'after_setup_theme', array( $this, 'matat_after_setup_theme' ), 12 );
		add_action( 'wp_enqueue_scripts', array( $this, 'matat_load_front_assets' ), 100 );
		add_action( 'admin_enqueue_scripts', array( $this, 'matat_load_admin_assets' ) );

	}
// Get All classes
	function matat_after_setup_theme() {
		require_once __DIR__ . '/../Order-management/class-matat-order-management.php' ;
	}

	function matat_register_types(){
		$types =  $this->matat_class_get_post_types() ? $this->matat_class_get_post_types() : array();

		foreach ((array)$types as $type){
			$this->matat_class_register_post_type( $type  );
		}
		$this->matat_class_register_taxonomy();
	}

//	Get all post types in array
	function matat_class_get_post_types() {
		return array(

			// declare events
        array(
            'type'   => 'branches',
            'label'  => 'סניפים',
            'menu_icon'       => 'dashicons-hammer',
            'hierarchical'       => true,
            'rewrite'            => array( 'slug' =>'branches' ),
            'publicly_queryable' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
	            'revisions'
            )
        ),   array(
            'type'   => 'cities',
            'label'  => 'ערים',
            'menu_icon'       => 'dashicons-building',
            'hierarchical'       => true,
            'rewrite'            => array( 'slug' =>'cities' ),
            'publicly_queryable' => false,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'revisions'
            )
        ),


		);


	}


// Register post types
	function matat_class_register_post_type($args) {

		$labels = array(
			'name'               => __($args['label'], 'matat'),
			'menu_name'          => __($args['label'], 'matat')
		);

		$defaults = array(
			'public'  => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'has_archive' => true,
			'rewrite' =>array(
				'slug'         =>  '',
				'with_front'   => true
			),
			'hierarchical' => true,
			'menu_icon'    => get_template_directory_uri() . '/admin/images/workers.png',
			'supports'     =>  array('title','editor','thumbnail','author'),
			'labels'     =>  $labels
		) ;

		$args = wp_parse_args($args,$defaults);
		register_post_type( $args['type'],$args);



	}

// Register taxonomies
	function matat_class_register_taxonomy( ) {
		$args = array(
			'label' => 'קו חלוקה',
			'rewrite' => array( 'slug' => 'delivery_line' ),
			'hierarchical' => true,
		);

		register_taxonomy( 'delivery_line', array('branches','cities'), $args );


	}

// Register User Roles

	function matat_register_roles()
	{
		add_role('branch_manager', 'מנהל סניף', array(
			'read' => true, // True allows that capability
			'edit_posts' => true,
			'delete_posts' => false, // Use false to explicitly deny

		));
		add_role('collector', 'מלקט', array(
			'read' => true, // True allows that capability
			'edit_posts' => true,
			'delete_posts' => false, // Use false to explicitly deny
		));
		add_role('driver', 'נהג', array(
			'read' => true, // True allows that capability
			'edit_posts' => true,
			'delete_posts' => false, // Use false to explicitly deny
		));

	}



	function matat_load_front_assets() {

	}

	function matat_load_admin_assets() {

	}


}

new Matat_Site_Management();