<?php

/*
Name:        Beitragskategorien
Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-popup/
Description: Fügt Regeln für Beitragskategorien hinzu.
Author:      DerN3rd (PSOURCE)
Author URI:  https://n3rds.work
Type:        Rule
Rules:       In der Post-Kategorie, nicht in der Post-Kategorie
Limit:       no global, pro
Version:     1.1

HINWEIS: DIESE DATEI NICHT UMBENENNEN!!
Dieser Dateiname wird als Metadaten bei jedem Popup gespeichert, das diese Regeln verwendet.
Durch das Umbenennen der Datei werden die Regeln deaktiviert, was sehr schlecht ist!
*/

class IncPopupRule_Category extends IncPopupRule {

	public $categories;
	public $url_types;

	/**
	 * Initialisiert das Regelobjekt.
	 *
	 * @since  1.6
	 */
	protected function init() {
		$this->filename = basename( __FILE__ );

		if ( IncPopup::use_global() ) { return; }

		// 'category'-Regel.
		$this->add_rule(
			'category',
			__( 'Auf Beitragskategorie', 'popover' ),
			__( 'Zeigt das PopUp auf Seiten an, die einer der angegebenen Kategorien entsprechen.', 'popover' ),
			'no_category',
			30
		);

		// 'no_category'-Regel.
		$this->add_rule(
			'no_category',
			__( 'Nicht in Beitragskategorie', 'popover' ),
			__( 'Zeigt das PopUp auf Seiten an, die keiner der angegebenen Kategorien entsprechen.', 'popover' ),
			'category',
			30
		);

		// -- Initialize -Regel.
		add_filter(
			'popup-ajax-data',
			array( $this, 'inject_ajax_category' )
		);

		$this->categories = get_terms(
			'category',
			array(
				'hide_empty' => false,
			),
			'objects'
		);

		$this->url_types = array(
			'singular' => __( 'Singular', 'popover' ),
			'plural'   => __( 'Archiv', 'popover' ),
		);
	}

	/**
	 * Fügt Kategoriedetails in die Ajax-Datensammlung ein.
	 * (Erforderlich für jede Ajax-Lademethode)
	 *
	 * @since  1.6
	 */
	public function inject_ajax_category( $data ) {
		$categories = json_encode( wp_list_pluck( get_the_category(), 'term_id' ) );
		$is_singular = is_singular() ? 1 : 0;

		if ( ! is_array( @$data['ajax_data'] ) ) {
			$data['ajax_data'] = array();
		}

		$data['ajax_data']['categories'] = $categories;
		$data['ajax_data']['is_single'] = $is_singular;

		return $data;
	}

	/*==============================*\
	==================================
	==                              ==
	==           CATEGORY           ==
	==                              ==
	==================================
	\*==============================*/

	/**
	 * Apply the rule-logic to the specified popup
	 *
	 * @since  1.6
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 * @return bool Decission to display popup or not.
	 */
	protected function apply_category( $data ) {
		if ( ! is_array( $data ) ) { $data = array(); }

		return $this->check_category( @$data['categories'], @$data['urls'] );
	}

	/**
	 * Output the Admin-Form for the active rule.
	 *
	 * @since  1.6
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 */

	protected function form_category( $data ) {
		$this->render_form(
			'category',
			__( 'In diesen Beitragskategorien anzeigen:', 'popover' ),
			__( 'Auf diesen Kategorietypen URLs anzeigen:', 'popover' ),
			$data
		);
	}

	/**
	 * Update and return the $settings array to save the form values.
	 *
	 * @since  1.6
	 * @param  array $data The contents of $_POST['po_rule_data'].
	 * @return mixed Data collection of this rule.
	 */
	protected function save_category( $data ) {
		lib3()->array->equip( $data, 'category' );
		return $data['category'];
	}

	/*=================================*\
	=====================================
	==                                 ==
	==           NO_CATEGORY           ==
	==                                 ==
	=====================================
	\*=================================*/

	/**
	 * Apply the rule-logic to the specified popup
	 *
	 * @since  1.6
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 * @return bool Decission to display popup or not.
	 */

	protected function apply_no_category( $data ) {
		if ( ! is_array( $data ) ) { $data = array(); }

		return ! $this->check_category( @$data['categories'], @$data['urls'] );
	}

	/**
	 * Output the Admin-Form for the active rule.
	 *
	 * @since  1.6
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 */

	protected function form_no_category( $data ) {
		$this->render_form(
			'no_category',
			__( 'Verstecke in diesen Beitragskategorien:', 'popover' ),
			__( 'Verstecke in diesen Kategorietyp URLs:', 'popover' ),
			$data
		);
	}

	/**
	 * Update and return the $settings array to save the form values.
	 *
	 * @since  1.6
	 * @param  array $data The contents of $_POST['po_rule_data'].
	 * @return mixed Data collection of this rule.
	 */
	protected function save_no_category( $data ) {
		lib3()->array->equip( $data, 'no_category' );
		return $data['no_category'];
	}

	/*======================================*\
	==========================================
	==                                      ==
	==           HELPER FUNCTIONS           ==
	==                                      ==
	==========================================
	\*======================================*/

	/**
	 * Renders the category options-form
	 *
	 * @since  1.0.0
	 * @param  string $name
	 * @param  string $label_category
	 * @param  string $label_urls
	 * @param  array $data
	 */

	protected function render_form( $name, $label_category, $label_urls, $data ) {

		if ( ! is_array( $data ) ) { $data = array(); }
		if ( ! is_array( @$data['categories'] ) ) { $data['categories'] = array(); }
		if ( ! is_array( @$data['urls'] ) ) { $data['urls'] = array(); }

		?>
		<fieldset>
			<legend><?php echo esc_html( $label_category ) ?></legend>
			<select name="po_rule_data[<?php echo esc_attr( $name ); ?>][categories][]" multiple="multiple">
			<?php foreach ( $this->categories as $term ) : ?>
			<option value="<?php echo esc_attr( $term->term_id ); ?>"
				<?php selected( in_array( $term->term_id, $data['categories'] ) ); ?>>
				<?php echo esc_html( $term->name ); ?>
			</option>
			<?php endforeach; ?>
			</select>
		</fieldset>

		<fieldset>
			<legend><?php echo esc_html( $label_urls ); ?></legend>
			<?php foreach ( $this->url_types as $key => $label ) : ?>
			<label>
				<input type="checkbox"
					name="po_rule_data[<?php echo esc_attr( $name ); ?>][urls][]"
					value="<?php echo esc_attr( $key ); ?>"
					<?php checked( in_array( $key, $data['urls'] ) ); ?> />
				<?php echo esc_html( $label ); ?>
			</label><br />
			<?php endforeach; ?>
		</fieldset>
		<?php
	}

	/**
	 * Tests if the $test_url matches any pattern defined in the $list.
	 *
	 * @since  1.6
	 * @param  string $posttype
	 * @param  array $url_types
	 * @return bool
	 */

	protected function check_category( $categories, $url_types ) {

		global $post;
		$response = false;

		if ( ! is_array( $categories ) ) { $categories = array(); }
		if ( ! is_array( $url_types ) ) { $url_types = array(); }

		if ( isset( $_REQUEST['categories'] ) ) {
			// Via URL/AJAX
			$cur_cats = json_decode( $_REQUEST['categories'] );
			$cur_single = ( 0 != absint( @$_REQUEST['is_single'] ) );
		} else {
			// Via wp_footer
			$cur_cats = wp_list_pluck( get_the_category( $post->ID ), 'term_id' );
			$cur_single = is_singular();
		}

		if ( $cur_single && in_array( 'singular', $url_types ) ) {
			if ( empty( $categories ) ) {
				$response = true; // Any cat, singular.
			} else {
				foreach ( $cur_cats as $term_id ) {
					if ( in_array( $term_id, $categories ) ) {
						$response = true; // We have a cat.
						break;
					}
				}
			}
		} elseif ( ! $cur_single && in_array( 'plural', $url_types ) ) {
			if ( empty( $categories ) ) {
				$response = true; // Any cat, archive
			} else {
				foreach ( $cur_cats as $term_id ) {
					if ( in_array( $term_id, $categories ) ) {
						$response = true; // We have a cat.
						break;
					}
				}
			}
		}
		return $response;
	}
};

IncPopupRules::register( 'IncPopupRule_Category' );

