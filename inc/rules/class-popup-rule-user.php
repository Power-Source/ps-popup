<?php

/*

Name:        Benutzerstatus

Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-popup/

Description: Bedingungen basierend auf dem aktuellen Benutzer.

Author:      DerN3rd (PSOURCE)

Author URI:  https://n3rds.work

Type:        Rule

Rules:       Besucher ist angemeldet, Besucher ist nicht angemeldet, Besucher hat zuvor kommentiert, Besucher hat noch nie kommentiert

Version:     1.1



NOTE: DON'T RENAME THIS FILE!!

This filename is saved as metadata with each popup that uses these rules.

Renaming the file will DISABLE the rules, which is very bad!

*/



class IncPopupRule_User extends IncPopupRule {



	/**

	 * Initialize the rule object.

	 *

	 * @since  1.6

	 */

	protected function init() {

		$this->filename = basename( __FILE__ );



		// 'login' rule.

		$this->add_rule(

			'login',

			__( 'Besucher ist angemeldet', 'popover' ),

			__( 'Zeigt das PopUp an, wenn der Benutzer bei Deiner Seite angemeldet ist.', 'popover' ),

			'no_login',

			1

		);



		// 'no_login' rule.

		$this->add_rule(

			'no_login',

			__( 'Besucher ist nicht angemeldet', 'popover' ),

			__( 'Zeigt das PopUp an, wenn der Benutzer nicht bei Deiner Seite angemeldet ist.', 'popover' ),

			'login',

			1

		);



		// 'comment' rule.

		$this->add_rule(

			'comment',

			__( 'Besucher hat zuvor kommentiert', 'popover' ),

			__(

				'Zeigt das PopUp an, wenn der Benutzer bereits einen Kommentar hinterlassen hat. ' .

				'Möglicherweise möchtest Du diese Bedingung mit "Besucher ' .

				'ist angemeldet" oder "Besucher ist nicht angemeldet" kombinieren.', 'popover'

			),

			'no_comment',

			20

		);



		// 'no_comment' rule.

		$this->add_rule(

			'no_comment',

			__( 'Besucher hat noch nie kommentiert', 'popover' ),

			__(

				'Zeigt das PopUp an, wenn der Benutzer noch nie einen Kommentar hinterlassen hat. ' .

				'Möglicherweise möchtest Du diese Bedingung mit "Besucher ' .

				'ist angemeldet" oder "Besucher ist nicht angemeldet" kombinieren.', 'popover'

			),

			'comment',

			20

		);

	}





	/*===========================*\

	===============================

	==                           ==

	==           LOGIN           ==

	==                           ==

	===============================

	\*===========================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_login( $data ) {

		return is_user_logged_in();

	}





	/*==============================*\

	==================================

	==                              ==

	==           NO_LOGIN           ==

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

	protected function apply_no_login( $data ) {

		return ! is_user_logged_in();

	}





	/*================================*\

	====================================

	==                                ==

	==           NO_COMMENT           ==

	==                                ==

	====================================

	\*================================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_no_comment( $data ) {

		return ! $this->did_user_comment();

	}





	/*=============================*\

	=================================

	==                             ==

	==           COMMENT           ==

	==                             ==

	=================================

	\*=============================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_comment( $data ) {

		return $this->did_user_comment();

	}





	/*======================================*\

	==========================================

	==                                      ==

	==           HELPER FUNCTIONS           ==

	==                                      ==

	==========================================

	\*======================================*/





	/**

	 * Checks if the user did already post any comments.

	 *

	 * @since  1.6

	 * @return bool

	 */

	protected function did_user_comment() {

		global $wpdb;

		static $Comment = null;



		if ( null === $Comment ) {

			// Guests (and maybe logged in users) are tracked via a cookie.

			$Comment = isset( $_COOKIE['comment_author_' . COOKIEHASH] ) ? 1 : 0;



			if ( ! $Comment && is_user_logged_in() ) {

				// For logged-in users we can also check the database.

				$sql = "

					SELECT COUNT(1)

					FROM {$wpdb->comments}

					WHERE user_id = %s

				";

				$sql = $wpdb->prepare( $sql, get_current_user_id() );

				$count = absint( $wpdb->get_var( $sql ) );

				$Comment = $count > 0;

			}

		}

		return $Comment;

	}



};



IncPopupRules::register( 'IncPopupRule_User' );