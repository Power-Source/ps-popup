<?php

/*

Name:        JavaScript Events

Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-popup/

Description: Neue Verhaltensoptionen: PopUp anzeigen, wenn die Maus das Browserfenster verlässt oder wenn der Benutzer irgendwo klickt.

Author:      DerN3rd (PSOURCE)

Author URI:  https://n3rds.work

Type:        Rule

Rules:

Limit:       pro

Version:     1.1



NOTE: DON'T RENAME THIS FILE!!

This filename is saved as metadata with each popup that uses these rules.

Renaming the file will DISABLE the rules, which is very bad!

*/





class IncPopupRule_Events extends IncPopupRule {



	/**

	 * Initialize the rule object.

	 *

	 * @since  1.6

	 */

	protected function init() {

		$this->filename = basename( __FILE__ );



		IncPopupItem::$display_opts[] = 'leave';

		IncPopupItem::$display_opts[] = 'click';



		add_action(

			'popup-display-behavior',

			array( $this, 'display_options' ),

			10, 1

		);



		add_filter(

			'popup-output-data',

			array( $this, 'append_data_on_exit' ),

			10, 2

		);



		add_filter(

			'popup-output-data',

			array( $this, 'append_data_on_click' ),

			10, 2

		);

	}



	/**

	 * Renders the new display options on the meta_behavior.php view

	 *

	 * @since  1.6

	 * @param  IncPopupItem $popup The PopUp that is displayed

	 */

	public function display_options( $popup ) {

		$this->form_mouseleave( $popup );

		$this->form_click( $popup );

	}





	/*=============================*\

	=================================

	==                             ==

	==           ON_EXIT           ==

	==                             ==

	=================================

	\*=============================*/





	protected function form_mouseleave( $popup ) {

		?>

		<div class="col-12 inp-row">

			<label class="inp-height">

				<input type="radio"

					name="po_display"

					id="po-display-leave"

					value="leave"

					data-toggle=".opt-display-leave"

					<?php checked( $popup->display, 'leave' ); ?> />

				<?php _e( 'Erscheint, wenn die Maus das Browserfenster verlässt', 'popover' ); ?>

			</label>

		</div>

		<?php

	}





	/**

	 * Append data to the popup javascript-variable.

	 *

	 * @since  1.6

	 * @param  array $data Data collection that is printed to javascript.

	 * @param  IncPopupItem $popup The original popup object.

	 * @return array Modified data collection.

	 */

	public function append_data_on_exit( $script_data, $popup ) {

		$script_data = lib3()->array->get( $script_data );



		if ( 'leave' == $popup->display ) {

			if ( ! isset( $script_data['script'] ) ) {

				$script_data['script'] = '';

			}



			$script_data['script'] .= 'me.custom_handler = ' . $this->script_on_exit();

		}



		return $script_data;

	}



	/**

	 * Returns the javascript code that triggers the exit event.

	 *

	 * @since  1.6

	 */

	public function script_on_exit() {

		ob_start();

		?>

		function( me ) {

			var tmr = null;



			function set( ev ) {

				if ( ! me ) return;

				tmr = setTimeout( function trigger() {

					me.show_popup();

					me = false;



					jQuery( 'html' ).off( 'mousemove', reset );

					jQuery( document ).off( 'mouseleave', set );

				}, 10 );

			}



			function reset( ev ) {

				clearTimeout( tmr );

			}



			jQuery( 'html' ).on( 'mousemove', reset );

			jQuery( document ).on( 'mouseleave', set );

		}

		<?php

		$code = ob_get_clean();

		return $code;

	}





	/*==============================*\

	==================================

	==                              ==

	==           ON_CLICK           ==

	==                              ==

	==================================

	\*==============================*/





	protected function form_click( $popup ) {

		?>

		<div class="col-12 inp-row">

			<label>

				<input type="radio"

					name="po_display"

					id="po-display-click"

					value="click"

					data-toggle=".opt-display-click"

					<?php checked( $popup->display, 'click' ); ?> />

				<?php _e( 'Erscheint, wenn der Benutzer auf eine CSS-Auswahl klickt', 'popover' ); ?>

			</label>

			<span class="opt-display-click">

				<input type="text"

					maxlength="50"

					name="po_display_data[click]"

					value="<?php echo esc_attr( @$popup->display_data['click'] ); ?>"

					placeholder="<?php _e( '.class oder #id', 'popover' ); ?>" />

			</span>

			<span class="opt-display-click">

				<label data-tooltip="Wiederholt: Das PopUp wird bei jedem Klick angezeigt. Andernfalls wird es nur einmal geöffnet (beim ersten Klick)" data-pos="top" data-width="200">

					<input type="checkbox"

						name="po_display_data[click_multi]"

						<?php checked( ! empty( $popup->display_data['click_multi'] ) ); ?>/>

					<?php _e( 'Wiederholt', 'popover' ); ?>

				</label>

			</span>

		</div>

		<?php

	}



	/**

	 * Append data to the popup javascript-variable.

	 *

	 * @since  1.6

	 * @param  array $data Data collection that is printed to javascript.

	 * @param  IncPopupItem $popup The original popup object.

	 * @return array Modified data collection.

	 */

	public function append_data_on_click( $script_data, $popup ) {

		$script_data = lib3()->array->get( $script_data );



		if ( 'click' == $popup->display ) {

			if ( ! isset( $script_data['script'] ) ) {

				$script_data['script'] = '';

			}



			$script_data['script'] .= 'me.custom_handler = ' . $this->script_on_click();

		}



		return $script_data;

	}



	/**

	 * Returns the javascript code that triggers the click event.

	 *

	 * @since  1.6

	 */

	public function script_on_click() {

		ob_start();

		?>

		function( me ) {

			if ( me.data.display_data['click_multi'] ) {

				jQuery(document).on( 'click', me.data.display_data['click'], me.show_popup );

			} else {

				jQuery(document).one( 'click', me.data.display_data['click'], me.show_popup );

			}

		}

		<?php

		$code = ob_get_clean();

		return $code;

	}

};



IncPopupRules::register( 'IncPopupRule_Events' );

