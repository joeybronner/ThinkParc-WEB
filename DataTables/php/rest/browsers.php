<?php

/*
 * Example PHP implementation used for the REST example.
 * This file defines a DTEditor class instance which can then be used, as
 * required, by the CRUD actions.
 */

// DataTables PHP library
include( dirname(__FILE__)."/../lib/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;

// Build our Editor instance and process the data coming from _POST
$editor = Editor::inst( $db, 'utilisateurs' )
	->fields(
		Field::inst( 'nom' )->validator( 'Validate::required' ),
		Field::inst( 'prenom' )->validator( 'Validate::required' ),
		Field::inst( 'login' )->validator( 'Validate::required' ),
		Field::inst( 'pass' )->validator( 'Validate::required' ),
		Field::inst( 'privilege' )->validator( 'Validate::required' )
	);
