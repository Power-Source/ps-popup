<?php

/*
Name:        Benutzerdefinierte Taxonomien
Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-popup/
Description: Ermöglicht das Anzeigen von PopUps basierend auf anderen Taxonomien als Beitragskategorien.
Author:      DerN3rd (PSOURCE)
Author URI:  https://n3rds.work
Type:        Rule
Rules:       Auf Beitragstaxonomie, Nicht auf Beitragstaxonomie
Limit:       no global, pro
Version:     1.1

HINWEIS: DIESE DATEI NICHT UMBENENNEN!!
Dieser Dateiname wird als Metadaten bei jedem Popup gespeichert, das diese Regeln verwendet.
Durch das Umbenennen der Datei werden die Regeln deaktiviert, was sehr schlecht ist!
*/

class IncPopupRule_Taxonomy extends IncPopupRule {

	/**
	 * Initialize the rule object.
	 *
	 * @since  1.6
	 */
	protected function init() {
		$this->filename = basename( __FILE__ );

		if ( IncPopup::use_global() ) { return; }

		if ( ! defined( 'POP_UP_TAXONOMY' ) ) {
			lib3()->ui->admin_message(
				__( 'Bitte definiere die PopUp-Taxonomie durch hinzufügen von <code>define("POP_UP_TAXONOMY", "<em>&lt;taxonomy_name&gt;</em>");</code> in Deine wpconfig.php Datei.<br>Hinweis: Anstelle von "&lt;taxonomy_name&gt;" musst Du den genauen Taxonomienamen definieren, den Du verwenden möchtest.', 'popover' ),
				'err'
			);
		}

		// 'taxonomy' rule.
		$this->add_rule(
			'taxonomy',
			__( 'Auf benutzerdefinierter Taxonomie', 'popover' ),
			sprintf(
				__( 'Zeigt das PopUp auf Seiten an, die einer der angegebenen <strong>%s</strong>-Taxonomien entsprechen.', 'popover' ),
				esc_html( POP_UP_TAXONOMY )
			),
			'no_taxonomy',
			30
		);
		// 'no_taxonomy' rule.
		$this->add_rule(
			'no_taxonomy',
			__( 'Nicht auf benutzerdefinierte Taxonomie', 'popover' ),
			sprintf(
				__( 'Blendet das PopUp auf Seiten aus, die einer der angegebenen strong>%s</strong>-Taxonomien entsprechen.', 'popover' ),
				esc_html( POP_UP_TAXONOMY )
			),
			'taxonomy',
			30
		);
		// -- Initialize rule.
		add_filter(
			'popup-ajax-data',
			array( $this, 'inject_ajax_taxonomy' )
		);

		$this->taxonomies = get_terms(
			POP_UP_TAXONOMY,
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
	 * Injects taxonomy details into the ajax-data collection.
	 * (Required for any ajax loading method)
	 *
	 * @since  1.6
	 */

	public function inject_ajax_taxonomy( $data ) {
		global $post;
		$taxonomies = '';
		$tax_terms = get_the_terms( $post->ID, POP_UP_TAXONOMY );
		if ( $tax_terms && ! is_wp_error( $tax_terms ) ) {
			$taxonomies = json_encode( wp_list_pluck( $tax_terms, 'term_id' ) );
		}

		$is_singular = is_singular() ? 1 : 0;

		if ( ! is_array( @$data['ajax_data'] ) ) {
			$data['ajax_data'] = array();
		}

		$data['ajax_data']['taxonomies'] = $taxonomies;
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

	protected function apply_taxonomy( $data ) {
		if ( ! is_array( $data ) ) { $data = array(); }

		return $this->check_taxonomy( @$data['taxonomies'], @$data['urls'] );
	}

	/**
	 * Output the Admin-Form for the active rule.
	 *
	 * @since  1.6
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 */

	protected function form_taxonomy( $data ) {
		$this->render_form(
			'taxonomy',
			__( 'Zeige auf diesen Beitrags-Taxonomien:', 'popover' ),
			__( 'Zeige auf diesen Taxonomietyp-URLs an:', 'popover' ),
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

	protected function save_taxonomy( $data ) {
		lib3()->array->equip( $data, 'taxonomy' );
		return $data['taxonomy'];
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

	protected function apply_no_taxonomy( $data ) {
		if ( ! is_array( $data ) ) { $data = array(); }

		return ! $this->check_taxonomy( @$data['taxonomies'], @$data['urls'] );
	}

	/**
	 * Output the Admin-Form for the active rule.
	 *
	 * @since  1.6
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 */

	protected function form_no_taxonomy( $data ) {
		$this->render_form(
			'no_taxonomy',
			__( 'Verstecke auf diesen Beitrags-Taxonomien:', 'popover' ),
			__( 'Verstecke auf diesen Taxonomietyp URLs:', 'popover' ),
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

	protected function save_no_taxonomy( $data ) {
		lib3()->array->equip( $data, 'no_taxonomy' );
		return $data['no_taxonomy'];
	}

	/*======================================*\
	==========================================
	==                                      ==
	==           HELPER FUNCTIONS           ==
	==                                      ==
	==========================================
	\*======================================*/

	/**
	 * Renders the taxonomy options-form
	 *
	 * @since  1.0.0
	 * @param  string $name
	 * @param  string $label_taxonomy
	 * @param  string $label_urls
	 * @param  array $data
	 */

	protected function render_form( $name, $label_taxonomy, $label_urls, $data ) {
		if ( ! is_array( $data ) ) { $data = array(); }
		if ( ! is_array( @$data['taxonomies'] ) ) { $data['taxonomies'] = array(); }
		if ( ! is_array( @$data['urls'] ) ) { $data['urls'] = array(); }
		?>
		<fieldset>
			<legend><?php echo esc_html( $label_taxonomy ); ?></legend>
			<select name="po_rule_data[<?php echo esc_attr( $name ); ?>][taxonomies][]" multiple="multiple">
			<?php
			if ( ! empty( $this->taxonomies ) ) {
				foreach ( $this->taxonomies as $term ) {
					?>
					<option value="<?php echo esc_attr( $term->term_id ); ?>"
						<?php selected( in_array( $term->term_id, $data['taxonomies'] ) ); ?>>
						<?php echo esc_html( $term->name ); ?>
					</option>
				<?php
				}
			}
			?>
			</select>
		</fieldset>

		<fieldset>
			<legend><?php echo esc_html( $label_urls ); ?></legend>
			<?php
			if ( ! empty( $this->url_types ) ) {
				foreach ( $this->url_types as $key => $label ) {
					?>
					<label>
						<input type="checkbox"
							name="po_rule_data[<?php echo esc_attr( $name ); ?>][urls][]"
							value="<?php echo esc_attr( $key ); ?>"
							<?php checked( in_array( $key, $data['urls'] ) ); ?> />
						<?php echo esc_html( $label ); ?>
					</label><br />
					<?php
				}
			}?>
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

	protected function check_taxonomy( $taxonomies, $url_types ) {
		global $post;

		$response = false;

		if ( ! is_array( $taxonomies ) ) { $taxonomies = array(); }
		if ( ! is_array( $url_types ) ) { $url_types = array(); }

		if ( isset( $_REQUEST['taxonomies'] ) ) {
			// Via URL/AJAX
			$cur_cats = json_decode( $_REQUEST['taxonomies'] );
			$cur_single = ( 0 != absint( @$_REQUEST['is_single'] ) );
		} else {
			// Via wp_footer
			$cur_cats = '';
			$tax_terms = get_the_terms( $post->ID, POP_UP_TAXONOMY );

			if ( $tax_terms ) {
				$cur_cats = wp_list_pluck( $tax_terms, 'term_id' );
			}
			$cur_single = is_singular();
		}

		if ( $cur_single && in_array( 'singular', $url_types ) ) {
			if ( empty( $taxonomies ) ) {
				$response = true; // Any cat, singular.
			} else {
				if ( ! empty( $cur_cats ) ) {
					foreach ( $cur_cats as $term_id ) {
						if ( in_array( $term_id, $taxonomies ) ) {
							$response = true; // We have a cat.
							break;
						}
					}
				}
			}

		} else if ( ! $cur_single && in_array( 'plural', $url_types ) ) {
			if ( empty( $taxonomies ) ) {
				$response = true; // Any cat, archive
			} else {
				if ( ! empty( $cur_cats ) ) {
					foreach ( $cur_cats as $term_id ) {
						if ( in_array( $term_id, $taxonomies ) ) {
							$response = true; // We have a cat.
							break;
						}
					}
				}
			}
		}
		return $response;
	}
};

IncPopupRules::register( 'IncPopupRule_Taxonomy' );

