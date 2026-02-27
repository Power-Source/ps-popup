<?php

/*

Name:        PopUp Details

Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-popup/

Description: Test auf PopUp-spezifische Werte.

Author:      DerN3rd (PSOURCE)

Author URI:  https://n3rds.work

Type:        Rule

Rules:       PopUp wird weniger als angezeigt

Version:     1.1



NOTE: DON'T RENAME THIS FILE!!

This filename is saved as metadata with each popup that uses these rules.

Renaming the file will DISABLE the rules, which is very bad!

*/



class IncPopupRule_Popup extends IncPopupRule {



	/**

	 * Initialize the rule object.

	 *

	 * @since  1.6

	 */

	protected function init() {

		$this->filename = basename( __FILE__ );



		// 'count' rule.

		$this->add_rule(

			'count',

			__( 'PopUp wird weniger als angezeigt', 'popover' ),

			__( 'Zeigt das PopUp an, wenn der Benutzer es nur weniger als eine bestimmte Anzahl von Malen gesehen hat.', 'popover' ),

			'',

			5

		);

	}





	/*===========================*\

	===============================

	==                           ==

	==           COUNT           ==

	==                           ==

	===============================

	\*===========================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @param  IncPopupItem $popup The PopUp that is displayed.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_count( $data, $popup ) {

		$max_count = absint( $data );

		$count = absint( @$_COOKIE['po_c-' . $popup->id] );

		return $count < $max_count;

	}



	/**

	 * Output the Admin-Form for the active rule.

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 */

	protected function form_count( $data ) {

		$count = absint( $data );

		if ( $count < 1 ) { $count = 1; }

		?>

		<label for="po-max-count">

			<?php _e( 'Zeige PopUp so oft an:', 'popover' ); ?>

		</label>

		<input type="number"

			id="po-max-count"

			class="inp-small"

			name="po_rule_data[count]"

			min="1"

			max="999"

			maxlength="3"

			placeholder="10"

			value="<?php echo esc_attr( absint( $count ) ); ?>" />

		<?php

	}



	/**

	 * Update and return the $settings array to save the form values.

	 *

	 * @since  1.6

	 * @param  array $data The contents of $_POST['po_rule_data'].

	 * @return mixed Data collection of this rule.

	 */

	protected function save_count( $data ) {

		lib3()->array->equip( $data, 'count' );



		$count = absint( $data['count'] );

		if ( $count < 1 ) { $count = 1; }

		return $count;

	}



};



IncPopupRules::register( 'IncPopupRule_Popup' );