<?php



/**

 * Defines the custom posttype details for popups.

 */

class IncPopupPosttype {



	/**

	 * Capability required to use admin interface of the plugin.

	 * Defined in constructor.

	 * @var string

	 */

	static public $perms = '';



	/**

	 * The position of the PopUp main menu.

	 * We use a trick to avoid collissions with other menu-items

	 * @var int

	 */

	static public $menu_pos = 101;



	/**

	 * Returns the singleton instance of the popup database class.

	 *

	 * @since  1.6

	 */

	static public function instance() {

		static $Inst = null;



		if ( null === $Inst ) {

			$Inst = new IncPopupPosttype();

		}



		return $Inst;

	}



	/**

	 * Singleton constructor

	 */

	private function __construct() {

		/**Neues PopUp
Neues PopUp
		 * Allows users to change the required permission for the popup plugin.

		 * Default requirement: manage_options

		 *

		 * @var string

		 */

		self::$perms = apply_filters( 'popover-admin-access-capability', 'manage_options' );



		// Legacy filter (with underscore)

		self::$perms = apply_filters( 'popover-admin-access_capability', self::$perms );



		/**

		 * Allows users to avoid conflicts with other menu items by assigning a

		 * different menu position.

		 *

		 * @var int

		 */

		self::$menu_pos = apply_filters( 'popover-admin-menu-position', self::$menu_pos );



		// Register the posttype

		self::setup_posttype();

	}



	/**

	 * Register the custom post-type details.

	 *

	 * @since  1.6

	 */

	static private function setup_posttype() {

		// Code generated at http://generatewp.com/post-type/

		$manage_popups = ( true == IncPopup::correct_level() );



		// Register Custom Post Type

		$labels = array(

			'name'                => _x( 'PopUps', 'Post Type General Name', 'popover' ),

			'singular_name'       => _x( 'PopUp', 'Post Type Singular Name', 'popover' ),

			'menu_name'           => __( 'PopUp', 'popover' ),

			'parent_item_colon'   => __( 'Eltern Artikel:', 'popover' ),

			'all_items'           => __( 'PopUps', 'popover' ),

			'view_item'           => __( 'Element anzeigen', 'popover' ),

			'add_new_item'        => __( 'Neues PopUp hinzufügen', 'popover' ),

			'add_new'             => __( 'Neues PopUp', 'popover' ),

			'edit_item'           => __( 'PopUp bearbeiten', 'popover' ),

			'update_item'         => __( 'Aktualisiere PopUp', 'popover' ),

			'search_items'        => __( 'Suche PopUp', 'popover' ),

			'not_found'           => __( 'Nicht gefunden', 'popover' ),

			'not_found_in_trash'  => __( 'Kein PopUp im Papierkorb gefunden', 'popover' ),

		);



		if ( IncPopup::use_global() ) {

			$labels['name']          = _x( 'Globale PopUps', 'Post Type General Name', 'popover' );

			$labels['singular_name'] = _x( 'Globales PopUp', 'Post Type Singular Name', 'popover' );

			$labels['all_items']     = __( 'Globale PopUps', 'popover' );

		}



		$args = array(

			'label'               => __( 'PopUp', 'popover' ),

			'description'         => __( 'Zeige PopUp-Nachrichten auf Deiner Webseite an!', 'popover' ),

			'labels'              => $labels,

			'supports'            => array( '' ),

			'hierarchical'        => false,

			'public'              => false,

			'show_ui'             => $manage_popups,

			'show_in_menu'        => $manage_popups,

			'show_in_nav_menus'   => false,

			'show_in_admin_bar'   => $manage_popups,

			'menu_position'       => self::$menu_pos,

			'menu_icon'           => PO_IMG_URL . 'icon.png',

			'can_export'          => true,

			'has_archive'         => false,

			'exclude_from_search' => true,

			'publicly_queryable'  => false,

			'rewrite'             => false,

		);

		register_post_type( IncPopupItem::POST_TYPE, $args );

	}

};