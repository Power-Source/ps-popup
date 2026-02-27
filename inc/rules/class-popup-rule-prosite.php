<?php

/*
Name:        PS Bloghosting
Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-bloghosting/
Description: Bedingungen basierend auf den Details der PS Bloghosting Seiten (nur für Global PopUps verfügbar). <a href="https://n3rds.work/piestingtal-source-project/ps-bloghosting/" target="_blank">Mehr über PS Bloghosting &raquo;</a>
Author:      DerN3rd (PSOURCE)
Author URI:  https://n3rds.work
Type:        Rule
Rules:       Seite ist keine Bloghosting Pro Seite
Limit:       global, pro
Version:     1.1

HINWEIS: DIESE DATEI NICHT UMBENENNEN!!
Dieser Dateiname wird als Metadaten bei jedem Popup gespeichert, das diese Regeln verwendet.
Durch das Umbenennen der Datei werden die Regeln deaktiviert, was sehr schlecht ist!
*/

class IncPopupRule_Prosite extends IncPopupRule {

	public $is_active;
	/**
	 * Initialisiert das Regelobjekt.
	 *
	 * @since  1.6
	 */
	protected function init() {

		$this->filename = basename( __FILE__ );
		// 'no_prosite' rule.
		$this->add_rule(
			'no_prosite',
			__( 'Seite ist keine Bloghosting Pro Seite', 'popover' ),
			__( 'Zeigt das PopUp an, wenn die Seite keine Bloghosting Pro-Seite ist.', 'popover' ),
			'',
			20
		);
		// -- Initialize rule.
		$this->is_active = function_exists( 'is_pro_site' );
	}

	/*================================*\
	====================================
	==                                ==
	==           NO_PROSITE           ==
	==                                ==
	====================================
	\*================================*/

	/**
	 * Wende die Regellogik auf das angegebene Popup an
	 *
	 * @since  1.6
	 * @param  mixed $data Regeldaten, die über den save_()-Handler gespeichert wurden.
	 * @return bool Entscheidung, ob ein Popup angezeigt werden soll oder nicht.
	 */
	protected function apply_no_prosite( $data ) {
		$prosite = function_exists( 'is_pro_site' ) && is_pro_site();
		return ! $prosite;
	}

	/**
	 * Gibt das Admin-Formular für die aktive Regel aus.
	 *
	 * @since  1.6
	 * @param  mixed $data Regeldaten, die über den save_()-Handler gespeichert wurden.
	 */
	protected function form_no_prosite( $data ) {

		if ( ! $this->is_active ) {
			$this->render_plugin_inactive();
		}
	}

	/*======================================*\
	==========================================
	==                                      ==
	==           HELPER FUNCTIONS           ==
	==                                      ==
	==========================================
	\*======================================*/

	/**
	 * Zeigt eine Warnmeldung an, falls das Mitgliedschafts-Plugin nicht aktiv ist.
	 *
	 * @since  1.0.0
	 */
	protected function render_plugin_inactive() {
		?>
		<div class="error below-h2"><p>
			<?php printf(
				__(
					'Diese Bedingung erfordert, dass das <a href="%s" target="_blank">' .
					'PS Bloghosting Plugin </a> installiert und aktiviert ist.', 'popover'
				),
				'https://n3rds.work/piestingtal-source-project/ps-bloghosting/'
			);?>
		</p></div>
		<?php
	}
};

IncPopupRules::register( 'IncPopupRule_Prosite' );

