<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "lib/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;

// Build our Editor instance and process the data coming from _POST
$out = Editor::inst( $db, 'browsers' )
	->fields(
		Field::inst( 'id' )->set(false), // ID is automatically set as the primary key
		Field::inst( 'engine' )->validator( 'Validate::required' ),
		Field::inst( 'browser' )->validator( 'Validate::required' ),
		Field::inst( 'platform' ),
		Field::inst( 'version' ),
		Field::inst( 'grade' )->validator( 'Validate::required' )
	)
	->process( $_POST )
	->data();

// On 'Get' remove the DT_RowId property so we can see fully how the `idSrc`
// option works on the client-side.
if ( !isset($_POST['action']) ) {
	for ( $i=0, $ien=count($out['aaData']) ; $i<$ien ; $i++ ) {
		unset( $out['aaData'][$i]['DT_RowId'] );
	}
}

// Send it back to the client
echo json_encode( $out );
