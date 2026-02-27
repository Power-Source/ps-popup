<?php

/**

 * Metabox "Appearance"

 *

 * Used in class-popup-admin.php

 * Available variables: $popup

 */



$styles = apply_filters( 'popup-styles', array() );

$animations = IncPopup::get_animations();



?>

<div class="wpmui-grid-12">

	<div class="col-12">

		<label for="po-style">

			<strong>

				<?php _e( 'Wähle den Stil aus, den Du verwenden möchtest:', 'popover' ); ?>

			</strong>

		</label>

	</div>

</div>

<div class="wpmui-grid-12">

	<div class="col-7">

		<input type="hidden"

			class="po-orig-style"

			name="po_orig_style"

			value="<?php echo esc_attr( $popup->style ); ?>" />

		<input type="hidden"

			class="po-orig-style-old"

			name="po_orig_style_old"

			value="<?php echo esc_attr( $popup->deprecated_style ); ?>" />

		<select class="block" id="po-style" name="po_style">

			<?php
			foreach ( $styles as $key => $data ) :
				if ( ! isset( $data->deprecated ) ) { $data->deprecated = false; }
				if ( $data->deprecated && $popup->style != $key ) { continue; }
				?>
				<option value="<?php echo esc_attr( $key ); ?>"
					data-old="<?php echo esc_attr( $data->deprecated ); ?>"
					<?php selected( $key, $popup->style ); ?>>
					<?php echo esc_attr( $data->name ); ?>
					<?php if ( $data->deprecated ) : ?>*)<?php endif; ?>
				</option>
			<?php endforeach; ?>
		</select>

	</div>

</div>

<?php if ( $popup->deprecated_style ) :

	?>

	<div class="wpmui-grid-12">

		<div class="col-12">

			<p style="margin-top:0"><em><?php

			_e(

				'*) Dieser Stil ist veraltet und unterstützt nicht alle Optionen '.

				'auf dieser Seite. ' .

				'Sobald Du Dein PopUp mit einem neuen Stil gespeichert hast, kannst Du es nicht mehr ' .

				'zu diesem Stil zurückkehren!<br />' .

				'Tipp: Verwende die Vorschaufunktion, um dieses PopUp mit einem ' .

				'der neuen Stile zu testen vor dem Speichern.', 'popover'

			);

			?></em></p>

		</div>

	</div>

	<?php

endif; ?>



<div class="wpmui-grid-12">

	<div class="col-12 inp-row">

		<label>

			<input type="checkbox"

				name="po_custom_colors"

				id="po-custom-colors"

				data-toggle=".chk-custom-colors"

				<?php checked( $popup->custom_colors ); ?> />

			<?php _e( 'Verwende benutzerdefinierte Farben', 'popover' ); ?>

		</label>

	</div>

</div>

<div class="wpmui-grid-12 chk-custom-colors">

	<div class="col-colorpicker inp-row">

		<input type="text"

			class="colorpicker inp-small"

			name="po_color[col1]"

			value="<?php echo esc_attr( $popup->color['col1'] ); ?>" />

		<br />

		<?php _e( 'Links, Schaltflächenhintergrund, Überschrift und Unterüberschrift', 'popover' ); ?>

	</div>

	<div class="col-colorpicker inp-row">

		<input type="text"

			class="colorpicker inp-small"

			name="po_color[col2]"

			value="<?php echo esc_attr( $popup->color['col2'] ); ?>" />

		<br />

		<?php _e( 'Schaltflächentext', 'popover' ); ?>

	</div>

</div>



<div class="wpmui-grid-12">

	<div class="col-12 inp-row">

		<label>

			<input type="checkbox"

				name="po_custom_size"

				id="po-custom-size"

				data-toggle=".chk-custom-size"

				<?php checked( $popup->custom_size ); ?> />

			<?php _e( 'Benutzerdefinierte Größe verwenden (wenn ausgewählt, reagiert PopUp nicht responsiv)', 'popover' ); ?>

		</label>

	</div>

</div>

<div class="wpmui-grid-12 chk-custom-size">

	<div class="col-5 inp-row">

		<label for="po-size-width"><?php _e( 'Breite:', 'popover' ); ?></label>

		<input type="text"

			id="po-size-width"

			name="po_size_width"

			class="inp-small"

			value="<?php echo esc_attr( $popup->size['width'] ); ?>"

			placeholder="600px" />

	</div>

	<div class="col-5 inp-row">

		<label for="po-size-height"><?php _e( 'Höhe:', 'popover' ); ?></label>

		<input type="text"

			id="po-size-height"

			name="po_size_height"

			class="inp-small"

			value="<?php echo esc_attr( $popup->size['height'] ); ?>"

			placeholder="300px" />

	</div>

</div>



<div class="wpmui-grid-12">

	<div class="col-12 inp-row">

		<label>

			<input type="checkbox"

				name="po_scroll_body"

				id="po-scroll-body"

				data-toggle=".chk-scroll-body"

				<?php checked( $popup->scroll_body ); ?> />

			<?php _e( 'Ermögliche das Scrollen der Seite, während PopUp sichtbar ist', 'popover' ); ?>

		</label>

	</div>

</div>



<hr />



<div class="wpmui-grid-12">

	<div class="col-6 inp-row">

		<label for="po-animation-in">

			<?php _e( 'PopUp-Display-Animation', 'popover' ); ?>

		</label>

	</div>

	<div class="col-6 inp-row">

		<label for="po-animation-out">

			<?php _e( 'PopUp-Abschlussanimation', 'popover' ); ?>

		</label>

	</div>

	<div class="col-6 inp-row">

		<select id="po-animation-in" name="po_animation_in">

			<?php foreach ( $animations->in as $group => $items ) : ?>

				<?php if ( ! empty( $group ) ) : ?>

				<optgroup label="<?php echo esc_attr( $group ); ?>">

				<?php endif; ?>



				<?php inc_popup_show_options( $items, $popup->animation_in ); ?>



				<?php if ( ! empty( $group ) ) : ?>

				</optgroup>

				<?php endif; ?>

			<?php endforeach; ?>

		</select>

	</div>



	<div class="col-6 inp-row">

		<select id="po-animation-out" name="po_animation_out">

			<?php foreach ( $animations->out as $group => $items ) : ?>

				<?php if ( ! empty( $group ) ) : ?>

				<optgroup label="<?php echo esc_attr( $group ); ?>">

				<?php endif; ?>



				<?php inc_popup_show_options( $items, $popup->animation_out ); ?>



				<?php if ( ! empty( $group ) ) : ?>

				</optgroup>

				<?php endif; ?>

			<?php endforeach; ?>

		</select>

	</div>

</div>



<?php

function inc_popup_show_options( $items, $selected = false ) {

	$pro_only = ' - ' . __( 'PRO Version', 'popover' );



	foreach ( $items as $key => $label ) {

		$label = str_replace( $pro_only, '', $label );

		printf(

			'<option value="%2$s" %3$s>%1$s</option>',

			esc_attr( $label ),

			esc_attr( $key ),

			selected( $key, $selected, false )

		);

	}

}