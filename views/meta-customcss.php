<?php

/**

 * Metabox "Custom Styles"

 *

 * @since  1.7.0

 *

 * Used in class-popup-admin.php

 * Available variables: $popup

 */



?>

<div class="wpmui-grid-12">

	<label for="po-custom-css">

		<?php _e( 'Stelle benutzerdefinierte CSS-Regeln bereit, um dieses PopUp anzupassen', 'popover' ); ?>

	</label>

</div>

<div class="wpmui-grid-12">

	<textarea name="po_custom_css" id="po-custom-css" style="display: none"><?php

	echo esc_textarea( $popup->custom_css );

	?></textarea>

	<div class="po_css_editor"

		id="po-css-editor"

		data-input="#po-custom-css"

		style="width:100%; height: 20em;"

	><?php

	echo esc_textarea( $popup->custom_css );

	?></div>

</div>

<div class="wpmui-grid-12">

	<?php _e( 'Hinweis: Um auf dieses PopUp abzuzielen, musst Du allen Regeln ein Präfix voranstellen <code>#popup</code>, z.B: <code>#popup .wdpu-text { font-family: sans }</code>', 'popover' ); ?>

</div>