<?php

/**
 * Metabox "Behavior"
 *
 * Used in class-popup-admin.php
 * Available variables: $popup
 */
?>

<div class="wpmui-grid-12">
	<div class="col-12">
		<strong><?php _e( 'Wann soll das PopUp angezeigt werden?', 'popover' ); ?></strong>
	</div>
</div>

<div class="wpmui-grid-12" style="overflow: visible">
	<div class="col-12 inp-row">
		<label>
			<input type="radio"
				name="po_display"
				id="po-display-delay"
				value="delay"
				data-toggle=".opt-display-delay"
				<?php checked( $popup->display, 'delay' ); ?> />
			<?php _e( 'Anzeigen nach', 'popover' ); ?>
		</label>

		<span class="opt-display-delay">
			<input type="number"
				min="0"
				max="999"
				maxlength="3"
				name="po_display_data[delay]"
				class="inp-small"
				value="<?php echo esc_attr( $popup->display_data['delay'] ); ?>"
				placeholder="10" />
			<select name="po_display_data[delay_type]">
				<option value="s" <?php selected( $popup->display_data['delay_type'], 's' ); ?>>
					<?php _e( 'Sekunden', 'popover' ); ?>
				</option>

				<option value="m" <?php selected( $popup->display_data['delay_type'], 'm' ); ?>>
					<?php _e( 'Minuten', 'popover' ); ?>
				</option>
			</select>
		</span>
	</div>

	<div class="col-12 inp-row">
		<label>
			<input type="radio"
				name="po_display"
				id="po-display-scroll"
				value="scroll"
				data-toggle=".opt-display-scroll"
				<?php checked( $popup->display, 'scroll' ); ?> />
			<?php _e( 'Anzeigen nach', 'popover' ); ?>
		</label>

		<span class="opt-display-scroll">
			<input type="number"
				min="0"
				max="9999"
				maxlength="4"
				name="po_display_data[scroll]"
				class="inp-small"
				value="<?php echo esc_attr( $popup->display_data['scroll'] ); ?>"
				placeholder="25" />
			<select name="po_display_data[scroll_type]">
				<option value="%" <?php selected( $popup->display_data['scroll_type'], '%' ); ?>>
					<?php _e( '%', 'popover' ); ?>
				</option>

				<option value="px" <?php selected( $popup->display_data['scroll_type'], 'px' ); ?>>
					<?php _e( 'px', 'popover' ); ?>
				</option>
			</select>
		</span>
		<?php _e( 'der Seite wurde gescrollt.', 'popover' ); ?>
	</div>

	<div class="col-12 inp-row">
		<label>
			<input type="radio"
				name="po_display"
				id="po-display-anchor"
				value="anchor"
				data-toggle=".opt-display-anchor"
				<?php checked( $popup->display, 'anchor' ); ?> />
			<?php _e( 'Erscheint, nachdem der Benutzer bis zur CSS-Auswahl gescrollt hat', 'popover' ); ?>
		</label>

		<span class="opt-display-anchor">
			<input type="text"
				maxlength="50"
				name="po_display_data[anchor]"
				value="<?php echo esc_attr( $popup->display_data['anchor'] ); ?>"
				placeholder="<?php _e( '.class oder #id', 'popover' ); ?>" />
		</span>
	</div>
	<?php do_action( 'popup-display-behavior', $popup ); ?>
</div>

<hr />

<div class="wpmui-grid-12">
	<div class="col-12">
		<strong><?php _e( '"Diese Meldung nicht mehr anzeigen" Einstellungen:', 'popover' ); ?></strong>
	</div>
</div>

<div class="wpmui-grid-12">
	<div class="col-12 inp-row">
		<label>
			<input type="checkbox"
				name="po_can_hide"
				id="po-can-hide"
				data-toggle=".chk-can-hide"
				data-or="#po-can-hide,#po-close-hides"
				<?php checked( $popup->can_hide ); ?>/>
			<?php _e( 'Fügt "Diese Meldung nicht mehr anzeigen" Link hinzu', 'popover' ); ?>
		</label>
	</div>

	<div class="col-12 inp-row">
		<label>
			<input type="checkbox"
				name="po_close_hides"
				id="po-close-hides"
				data-toggle=".chk-can-hide"
				data-or="#po-can-hide,#po-close-hides"
				<?php checked( $popup->close_hides ); ?>/>
			<?php _e( 'Die Schaltfläche "Schließen" fungiert als "Diese Meldung nicht mehr anzeigen" Link', 'popover' ); ?>
		</label>
	</div>

	<div class="col-12 inp-row chk-can-hide">
		<label for="po-hide-expire">
			<?php _e( 'Ablaufdatum', 'popover' ); ?>
			<input type="number"
				name="po_hide_expire"
				id="po-hide-expire"
				class="inp-small"
				value="<?php echo esc_attr( $popup->hide_expire ); ?>"
				placeholder="365" />
			<?php _e( 'Tage', 'popover' ); ?>
			<?php _e( '(Nach Ablauf sieht der Benutzer dieses PopUp wieder)', 'popover' ); ?>
		</label>
	</div>
</div>

<hr />

<div class="wpmui-grid-12">
	<div class="col-12">
		<strong><?php _e( 'Popup-Schließen Bedingungen', 'popover' ); ?></strong>
	</div>
</div>

<div class="wpmui-grid-12">
	<div class="col-12 inp-row">
		<label>
			<input type="checkbox"
				name="po_overlay_close"
				<?php checked( ! $popup->overlay_close ); ?>
				/>
			<?php _e( 'Klicken auf den Hintergrund schließt PopUp nicht.', 'popover' ); ?>
		</label>
	</div>
</div>

<hr />

<?php
/**
 * Choose what to do when the PopUp contains a form.
 *
 * @since  1.7.0
 */
?>
<div class="wpmui-grid-12">
	<div class="col-12">
		<strong><?php _e( 'Formular senden', 'popover' ); ?></strong>
	</div>
</div>

<div class="wpmui-grid-12">
	<div class="col-12 inp-row">
		<label for="po-form-submit">
			<?php _e( 'Falls Dein PopUp ein Formular enthält (z. B. ein Kontaktformular), kannst Du hier das Verhalten beim Senden von Formularen ändern.', 'popover' ); ?>
		</label>
	</div>

	<div class="col-12 inp-row">
		<select name="po_form_submit" id="po-form-submit">
			<option value="close" <?php selected( $popup->form_submit, 'close' ); ?>>
				<?php _e( 'Schließe immer nach dem Absenden des Formulars', 'popover' ); ?>
			</option>
			<option value="default" <?php selected( $popup->form_submit, 'default' ); ?>>
				<?php _e( 'PopUp aktualisieren oder schließen (Standard)', 'popover' ); ?>
			</option>

			<option value="ignore" <?php selected( $popup->form_submit, 'ignore' ); ?>>
				<?php _e( 'PopUp aktualisieren oder nichts tun (für Ajax Formulare verwenden)', 'popover' ); ?>
			</option>

			<option value="redirect" <?php selected( $popup->form_submit, 'redirect' ); ?>>
				<?php _e( 'Umleiten auf eine Ziel-URL', 'popover' ); ?>
			</option>
		</select>
	</div>
</div>
