<?php

require_once dirname( __DIR__, 4 ) . '/wp-includes/pomo/po.php';
require_once dirname( __DIR__, 4 ) . '/wp-includes/pomo/mo.php';

function check_translation( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

$directory = dirname( __DIR__ ) . '/lang/';
$template = new PO();
$english = new PO();
$compiled = new MO();

check_translation( $template->import_from_file( $directory . 'popover.pot' ), 'Cannot read POT template' );
check_translation( $english->import_from_file( $directory . 'popover-en_US.po' ), 'Cannot read English PO catalog' );
check_translation( $compiled->import_from_file( $directory . 'popover-en_US.mo' ), 'Cannot read English MO catalog' );
check_translation( 'en_US' === $english->headers['Language'], 'Wrong translation locale' );
check_translation( count( $template->entries ) > 600, 'Template is unexpectedly incomplete' );
check_translation( count( $template->entries ) === count( $english->entries ), 'PO catalog is incomplete' );
check_translation( count( $template->entries ) === count( $compiled->entries ), 'MO catalog is incomplete' );

foreach ( $template->entries as $key => $entry ) {
	check_translation( isset( $english->entries[ $key ] ), 'Missing translation: ' . $entry->singular );
	$translation = $english->entries[ $key ];
	check_translation( ! in_array( 'fuzzy', $translation->flags, true ), 'Fuzzy translation: ' . $key );
	check_translation( ! empty( $translation->translations[0] ), 'Empty translation: ' . $key );
	check_translation(
		$compiled->translate( $entry->singular, $entry->context ) === $translation->translations[0],
		'Compiled translation differs: ' . $key
	);
	preg_match_all( '/%(?:\d+\$)?[bcdeEfFgGosuxX]/', $entry->singular, $source_placeholders );
	preg_match_all( '/%(?:\d+\$)?[bcdeEfFgGosuxX]/', $translation->translations[0], $translated_placeholders );
	check_translation( $source_placeholders[0] === $translated_placeholders[0], 'Changed placeholders: ' . $key );
}

check_translation( 'Settings' === $compiled->translate( 'Einstellungen' ), 'Admin translation failed' );
check_translation( 'Close this box' === $compiled->translate( 'Dieses Box schließen' ), 'Frontend translation failed' );
check_translation( 'Germany' === $compiled->translate( 'Deutschland' ), 'Country translation failed' );
check_translation(
	'Global PopUps' === $compiled->translate( 'Globale PopUps', 'Beitragstyp Allgemeiner Name' ),
	'German translation context failed'
);
check_translation(
	'Global PopUp' === $compiled->translate( 'Globales PopUp', 'Post Type Singular Name' ),
	'English translation context failed'
);
check_translation(
	'PopUp "<strong>Example</strong>" activated.' === sprintf(
		$compiled->translate( 'PopUp "<strong>%1$s</strong>" aktiviert.' ),
		'Example'
	),
	'Formatted translation failed'
);
check_translation(
	'Untranslated source text' === $compiled->translate( 'Untranslated source text' ),
	'Source fallback changed'
);

echo count( $template->entries ) . " English translations: PO/MO parity, contexts and placeholders passed\n";
