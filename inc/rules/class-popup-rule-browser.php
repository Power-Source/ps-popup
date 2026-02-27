<?php

/*
Name:        Gerätetyp

Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-popup/

Description: Bedingungen, die Browserdetails überprüfen.

Author:      DerN3rd (PSOURCE)

Author URI:  https://n3rds.work

Type:        Rule

Rules:       Nur auf Mobilgeräten, nicht auf Mobilgeräten

Version:     1.0



NOTE: DON'T RENAME THIS FILE!!

This filename is saved as metadata with each popup that uses these rules.

Renaming the file will DISABLE the rules, which is very bad!

*/



class IncPopupRule_Browser extends IncPopupRule {



	/**

	 * Initialize the rule object.

	 *

	 * @since  1.6

	 */

	protected function init() {

		$this->filename = basename( __FILE__ );



		// 'mobile' rule.

		$this->add_rule(

			'mobile',

			__( 'Nur auf mobilen Geräten', 'popover' ),

			__( 'Zeigt das PopUp Besuchern an, die ein mobiles Gerät (Telefon oder Tablet) verwenden..', 'popover' ),

			'no_mobile',

			6

		);



		// 'no_mobile' rule.

		$this->add_rule(

			'no_mobile',

			__( 'Nicht auf mobilen Geräten', 'popover' ),

			__( 'Zeigt das PopUp Besuchern an, die einen normalen Computer oder Laptop verwenden (d. H. Kein Telefon oder Tablet).', 'popover' ),

			'mobile',

			6

		);

	}





	/*============================*\

	================================

	==                            ==

	==           MOBILE           ==

	==                            ==

	================================

	\*============================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_mobile( $data ) {

		return wp_is_mobile();

	}





	/*===============================*\

	===================================

	==                               ==

	==           NO_MOBILE           ==

	==                               ==

	===================================

	\*===============================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_no_mobile( $data ) {

		return ! wp_is_mobile();

	}





};



IncPopupRules::register( 'IncPopupRule_Browser' );