<?php

/*
Name:        Benutzerrollen
Plugin URI: https://n3rds.work/piestingtal-source-project/ps-popup/
Description: Bedingungen basierend auf der Benutzerrolle des aktuellen Benutzers.
Author:      DerN3rd (PSOURCE)
Author URI:  https://n3rds.work
Type:        Rule
Rules:       Besucher hat Rolle, Besucher hat keine Rolle
Limit:       pro
Version:     1.1

NOTE: DON'T RENAME THIS FILE!!
This filename is saved as metadata with each popup that uses these rules.
Renaming the file will DISABLE the rules, which is very bad!
*/

class IncPopupRule_UserRole extends IncPopupRule {

	public $roles;

	/**
	 * Initialize the rule object.
	 *
	 * @since  1.6
	 */
	protected function init() {
		$this->filename = basename( __FILE__ );

		// 'role' rule.
		$this->add_rule(
			'role',
			__( 'Besucher hat Rolle', 'popover' ),
			__( 'Zeigt das PopUp an, wenn der Benutzer angemeldet und einer bestimmten Rolle zugewiesen ist.', 'popover' ),
			'no_role',
			15
		);

		// 'no_role' rule.
		$this->add_rule(
			'no_role',
			__( 'Besucher hat keine Rolle', 'popover' ),
			__( 'Zeigt das PopUp an, wenn der Benutzer angemeldet und keiner bestimmten Rolle zugeordnet ist.', 'popover' ),
			'role',
			15
		);

		// -- Initialize rule.
		global $wp_roles;
		$this->roles = $wp_roles->get_names();
	}

	/*==========================*\
	==============================
	==                          ==
	==           ROLE           ==
	==                          ==
	==============================
	\*==========================*/

	/**
	 * Apply the rule-logic to the specified popup
	 *
	 * @since  1.6
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 * @return bool Decission to display popup or not.
	 */
	protected function apply_role( $data ) {
		return is_user_logged_in() && $this->user_has_role( $data );
	}

	/**
	 * Output the Admin-Form for the active rule.
	 *
	 * @since  1.6
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 */
	protected function form_role( $data ) {
		$this->render_role_form(
			'role',
			__( 'Zeige Benutzern, die eine dieser Rollen haben:', 'popover' ),
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
	protected function save_role( $data ) {
		lib3()->array->equip( $data, 'role' );
		return $data['role'];
	}

	/*=============================*\

	=================================

	==                             ==

	==           NO_ROLE           ==

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

	protected function apply_no_role( $data ) {

		return is_user_logged_in() && ! $this->user_has_role( $data );

	}



	/**

	 * Output the Admin-Form for the active rule.

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 */

	protected function form_no_role( $data ) {

		$this->render_role_form(

			'no_role',

			__( 'Zeige  Benutzern, die keine dieser Rollen haben:', 'popover' ),

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

	protected function save_no_role( $data ) {

		lib3()->array->equip( $data, 'no_role' );

		return $data['no_role'];

	}





	/*======================================*\

	==========================================

	==                                      ==

	==           HELPER FUNCTIONS           ==

	==                                      ==

	==========================================

	\*======================================*/





	/**

	 * Renders the roles options-form

	 *

	 * @since  1.0.0

	 * @param  string $name

	 * @param  string $label

	 * @param  array $data

	 */

	protected function render_role_form( $name, $label, $data ) {

		if ( ! is_array( $data ) ) { $data = array(); }

		if ( ! is_array( @$data['roles'] ) ) { $data['roles'] = array(); }



		?>

		<fieldset>

			<legend><?php echo esc_html( $label ) ?></legend>

			<select name="po_rule_data[<?php echo esc_attr( $name ); ?>][roles][]" multiple="multiple">

			<?php foreach ( $this->roles as $role_key => $role_label ) : ?>

			<option value="<?php echo esc_attr( $role_key ); ?>"

				<?php selected( in_array( $role_key, $data['roles'] ) ); ?>>

				<?php echo esc_html( $role_label ); ?>

			</option>

			<?php endforeach; ?>

			</select>

		</fieldset>

		<?php

	}



	/**

	 * Tests if the current user belongs to one of the specified roles.

	 *

	 * @since  1.0.0

	 * @param  array $data Contains the element ['roles']

	 * @return boolean

	 */

	protected function user_has_role( $data ) {

		$result = false;

		if ( ! is_array( $data ) ) { $data = array(); }

		if ( ! is_array( @$data['roles'] ) ) { $data['roles'] = array(); }

		$role_list = $data['roles'];



		$user = wp_get_current_user();

		$user_roles = $user->roles;



		// Can a user have more than one Role? Better be sure and use a loop...

		foreach ( $user_roles as $key ) {

			if ( in_array( $key, $role_list ) ) {

				$result = true;

				break;

			}

		}

		return $result;

	}

};



IncPopupRules::register( 'IncPopupRule_UserRole' );

