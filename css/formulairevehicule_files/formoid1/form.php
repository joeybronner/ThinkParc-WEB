<?php

define('EMAIL_FOR_REPORTS', '');
define('RECAPTCHA_PRIVATE_KEY', '@privatekey@');
define('FINISH_URI', 'EnregistrementVehicule');
define('FINISH_ACTION', 'redirect');
define('FINISH_MESSAGE', 'Thanks for filling out my form!');
define('UPLOAD_ALLOWED_FILE_TYPES', 'doc, docx, xls, csv, txt, rtf, html, zip, jpg, jpeg, png, gif');

define('_DIR_', str_replace('\\', '/', dirname(__FILE__)) . '/');
require_once _DIR_ . '/handler.php';

?>

<?php if (frmd_message()): ?>
<link rel="stylesheet" href="<?php echo dirname($form_path); ?>/formoid-solid-dark.css" type="text/css" />
<span class="alert alert-success"><?php echo FINISH_MESSAGE; ?></span>
<?php else: ?>
<!-- Start Formoid form-->
<link rel="stylesheet" href="<?php echo dirname($form_path); ?>/formoid-solid-dark.css" type="text/css" />
<script type="text/javascript" src="<?php echo dirname($form_path); ?>/jquery.min.js"></script>
<form class="formoid-solid-dark" style="background-color:#7d7d7d;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#005500;max-width:480px;min-width:150px" method="post"><div class="title"><h2>Enregistrer un vehicule</h2></div>
	<div class="element-select<?php frmd_add_class("select"); ?>"><label class="title"><span class="required">*</span></label><div class="item-cont"><div class="large"><span><select name="select" required="required">

		<option value="Véhicule Particulier">Véhicule Particulier</option>
		<option value="Camionnette de PTAC < ou = 3,5 tonnes">Camionnette de PTAC < ou = 3,5 tonnes</option>
		<option value="Tricycle ">Tricycle </option>
		<option value="Quadricycle ">Quadricycle </option>
		<option value="Véhicule utilitaire">Véhicule utilitaire</option>
		<option value="Moto ">Moto </option>
		<option value="Tracteur routier">Tracteur routier</option>
		<option value="Transport en commun de personne">Transport en commun de personne</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-select<?php frmd_add_class("select1"); ?>"><label class="title"><span class="required">*</span></label><div class="item-cont"><div class="large"><span><select name="select1" required="required">

		<option value="Véhicules légers">Véhicules légers</option>
		<option value="Véhicules intermédiaires">Véhicules intermédiaires</option>
		<option value="Poids lourds et autocars à 2 essieux">Poids lourds et autocars à 2 essieux</option>
		<option value="Poids lourds et autocars à 3 essieux et plus">Poids lourds et autocars à 3 essieux et plus</option>
		<option value="Moto">Moto</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-select<?php frmd_add_class("select2"); ?>"><label class="title"><span class="required">*</span></label><div class="item-cont"><div class="large"><span><select name="select2" required="required">

		<option value="Essence">Essence</option>
		<option value="Diesel">Diesel</option>
		<option value="GPL">GPL</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-input<?php frmd_add_class("input"); ?>" title="Numerodeserie"><label class="title"><span class="required">*</span></label><div class="item-cont"><input class="large" type="text" name="input" required="required" placeholder="Numéro de série"/><span class="icon-place"></span></div></div>
	<div class="element-date<?php frmd_add_class("date"); ?>" title="date"><label class="title"><span class="required">*</span></label><div class="item-cont"><input class="large" data-format="yyyy-mm-dd" type="date" name="date" required="required" placeholder=" Date de Mise en Circulation"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("input1"); ?>" title="Matricule"><label class="title"><span class="required">*</span></label><div class="item-cont"><input class="large" type="text" name="input1" required="required" placeholder="Matricule"/><span class="icon-place"></span></div></div>
	<div class="element-date<?php frmd_add_class("date1"); ?>" title="dateachat"><label class="title"><span class="required">*</span></label><div class="item-cont"><input class="large" data-format="yyyy-mm-dd" type="date" name="date1" required="required" placeholder="Date d’Achat
"/><span class="icon-place"></span></div></div>
	<div class="element-date<?php frmd_add_class("date2"); ?>" title="datemiseenroute"><label class="title"></label><div class="item-cont"><input class="large" data-format="yyyy-mm-dd" type="date" name="date2" placeholder="Date de Mis en Route
"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("input3"); ?>"><label class="title"><span class="required">*</span></label><div class="item-cont"><input class="large" type="text" name="input3" required="required" placeholder="Compteur "/><span class="icon-place"></span></div></div>
	<div class="element-select<?php frmd_add_class("select3"); ?>"><label class="title"></label><div class="item-cont"><div class="large"><span><select name="select3" >

		<option value="Kit Hydraulique">Kit Hydraulique</option>
		<option value="Godet">Godet</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea"); ?>"><label class="title"></label><div class="item-cont"><textarea class="small" name="textarea" cols="20" rows="5" placeholder="Commentaires "></textarea><span class="icon-place"></span></div></div>
	<div class="element-select<?php frmd_add_class("select4"); ?>"><label class="title"><span class="required">*</span></label><div class="item-cont"><div class="large"><span><select name="select4" required="required">

		<option value="site 1">site 1</option>
		<option value="site 2">site 2</option>
		<option value="site 3">site 3</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-checkbox<?php frmd_add_class("checkbox"); ?>"><label class="title">Etat</label>		<div class="column column3"><label><input type="checkbox" name="checkbox[]" value="Hors Parc "/ ><span>Hors Parc </span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="checkbox" name="checkbox[]" value="Réformé "/ ><span>Réformé </span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="checkbox" name="checkbox[]" value="Vendu"/ ><span>Vendu</span></label></div><span class="clearfix"></span>
</div>
<div class="submit"><input type="submit" value="Enregistrer"/></div></form><script type="text/javascript" src="<?php echo dirname($form_path); ?>/formoid-solid-dark.js"></script>

<!-- Stop Formoid form-->
<?php endif; ?>

<?php frmd_end_form(); ?>