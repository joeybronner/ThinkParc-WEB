<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "./lib/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'utilisateurs' )
	->fields(
		Field::inst( 'nom' )->validator( 'Validate::required' ),
		Field::inst( 'prenom' )->validator( 'Validate::required' ),
		Field::inst( 'login' )->validator( 'Validate::required' ),
		Field::inst( 'pass' )->validator( 'Validate::required' ),
		Field::inst( 'privilege' )->validator( 'Validate::required' )
	)
	->process( $_POST )
	->json();
