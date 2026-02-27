<?php

global $shortcode_tags;





// Theme compatibility.

$theme_compat = IncPopupAddon_HeaderFooter::check();

$settings = IncPopupDatabase::get_settings();

$cur_method = $settings['loadingmethod'];





// Shortcodes with restrictions.

$limited = array(

	'app_.*',

	'.*-form.*',

	'.*_form.*',

	'embed',

);



$shortcodes = array();

// Add Admin-Shortcodes to the list.

foreach ( $shortcode_tags as $code => $handler ) {

	if ( ! isset( $shortcodes[ $code ] ) ) {

		$shortcodes[ $code ] = '';

	}



	$shortcodes[ $code ] .= 'sc-admin ';

}



// Add Front-End Shortcodes to the list.

foreach ( $theme_compat->shortcodes as $code ) {

	if ( ! isset( $shortcodes[ $code ] ) ) {

		$shortcodes[ $code ] = '';

	}



	$shortcodes[ $code ] .= 'sc-front ';

}



foreach ( $shortcodes as $code => $compat ) {

	foreach ( $limited as $pattern ) {

		if ( preg_match( '/^' . $pattern . '$/i', $code ) ) {

			$shortcodes[ $code ] = $compat . 'sc-limited ';

		}

	}

}





echo '<p>';

_e(

	'Du kannst alle Deine Shortcodes in den PopUp-Inhalten verwenden. ' .

	'Einige Plugins oder Themes bieten jedoch möglicherweise Shortcodes dafür ' .

	'Funktioniert nur mit der Lademethode "Footer".<br /> ' .

	'In dieser Liste wird erläutert, welche Shortcodes jeweils verwendet werden können ' .

	'Lademethode:', 'popover'

);

echo '</p>';



if ( IncPopup::use_global() ) :

	?>

	<p><em><?php

	_e(

		'Wichtiger Hinweis für Shortcodes in <strong> Globale ' .

		'PopUps</strong>:<br />' .

		'Shortcodes können von einem Plugin oder Theme bereitgestellt werden, sodass ' .

		'jedes Blog eine andere Liste von Shortcodes haben kann. Die ' .

		'folgende Liste gilt nur für den aktuellen Blog!', 'popover'

	);

	?></em></p>

	<?php



endif;



?>

<div class="tbl-shortcodes">

<table class="widefat load-<?php echo esc_attr( $cur_method ); ?>">

	<thead>

		<tr>

			<th width="40%">

				<div>

				<?php _e( 'Shortcode', 'popover' ); ?>

				</div>

			</th>

			<th class="flag load-footer">

				<div data-tooltip="<?php _e( 'Lademethode \'Seiten Footer\'', 'popover' ); ?>">

				<?php _e( 'Page Footer', 'popover' ); ?>

				</div>

			</th>

			<th class="flag load-ajax">

				<div data-tooltip="<?php _e( 'Lademethode \'WordPress AJAX\'', 'popover' ); ?>">

				<?php _e( 'WP AJAX', 'popover' ); ?>

				</div>

			</th>

			<th class="flag load-front">

				<div data-tooltip="<?php _e( 'Lademethode \'Benutzerdefiniertes AJAX\'', 'popover' ); ?>">

				<?php _e( 'Cust AJAX', 'popover' ); ?>

				</div>

			</th>

			<th class="flag load-anonymous">

				<div data-tooltip="<?php _e( 'Lademethode \'Anonymes Skript\'', 'popover' ); ?>">

				<?php _e( 'Skript', 'popover' ); ?>

				</div>

			</th>

			<th class="flag">

				<div data-tooltip="<?php _e( 'Beim Öffnen einer PopUp-Vorschau im Editor', 'popover' ); ?>">

				<?php _e( 'Vorschau', 'popover' ); ?>

				</div>

			</th>

		</tr>

	</thead>

	<tbody>

		<?php foreach ( $shortcodes as $code => $classes ) : ?>

			<tr class="shortcode <?php echo esc_attr( $classes ); ?>">

				<td><code>[<?php echo esc_html( $code ); ?>]</code></td>

				<td class="flag sc-front load-footer"><i class="icon dashicons"></i></td>

				<td class="flag sc-admin load-ajax"><i class="icon dashicons"></i></td>

				<td class="flag sc-front load-front"><i class="icon dashicons"></i></td>

				<td class="flag sc-admin load-anonymous"><i class="icon dashicons"></i></td>

				<td class="flag sc-admin"><i class="icon dashicons"></i></td>

			</tr>

		<?php endforeach; ?>

	</tbody>

</table>

<div class="legend shortcode sc-admin">

	<span class="sc-admin load-ajax"><i class="icon dashicons"></i></span>

	<?php _e( 'Shortcode unterstützt', 'popover' ); ?>

</div>

<div class="legend shortcode sc-admin sc-limited">

	<span class="sc-admin load-ajax"><i class="icon dashicons"></i></span>

	<?php _e( 'Könnte Probleme haben', 'popover' ); ?>

</div>

<div class="legend shortcode sc-admin">

	<span class="sc-front load-footer"><i class="icon dashicons"></i></span>

	<?php _e( 'Shortcode funktioniert nicht', 'popover' ); ?>

</div>

</div>