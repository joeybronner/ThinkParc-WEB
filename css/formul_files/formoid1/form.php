<?php

define('EMAIL_FOR_REPORTS', '');
define('RECAPTCHA_PRIVATE_KEY', '@privatekey@');
define('FINISH_URI', 'EnregistrementVehicule.php');
define('FINISH_ACTION', 'redirect');
define('FINISH_MESSAGE', 'Thanks for filling out my form!');
define('UPLOAD_ALLOWED_FILE_TYPES', 'doc, docx, xls, csv, txt, rtf, html, zip, jpg, jpeg, png, gif');

define('_DIR_', str_replace('\\', '/', dirname(__FILE__)) . '/');
require_once _DIR_ . '/handler.php';

?>

<?php if (frmd_message()): ?>
<link rel="stylesheet" href="<?php echo dirname($form_path); ?>/formoid-flat-green.css" type="text/css" />
<span class="alert alert-success"><?php echo FINISH_MESSAGE; ?></span>
<?php else: ?>
<!-- Start Formoid form-->
<link rel="stylesheet" href="<?php echo dirname($form_path); ?>/formoid-flat-green.css" type="text/css" />
<script type="text/javascript" src="<?php echo dirname($form_path); ?>/jquery.min.js"></script>
<form enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#dcd5d6;font-size:16px;font-family:'Lato', sans-serif;color:#313131;max-width:480px;min-width:150px" method="post"><div class="title"><h2>Ajout véhicule</h2></div>
	<div class="element-select<?php frmd_add_class("select"); ?>" title="Marque du véhicule"><label class="title">Marque</label><div class="medium"><span><select name="select" >

		<option value="Renault">Renault</option>
		<option value="Citroën">Citroën</option>
		<option value="Peugeot">Peugeot</option>
		<option value="Audi">Audi</option>
		<option value="Mercedes">Mercedes</option>
		<option value="Toyota">Toyota</option></select><i></i></span></div></div>
	<div class="element-input<?php frmd_add_class("input"); ?>" title="Modèle du véhicule"><label class="title">Modèle</label><input class="medium" type="text" name="input" /></div>
	<div class="element-date<?php frmd_add_class("date"); ?>"><label class="title">Mise en circulation</label><input class="medium" data-format="yyyy-mm-dd" type="date" name="date" placeholder="yyyy-mm-dd"/></div>
	<div class="element-checkbox<?php frmd_add_class("checkbox"); ?>"><label class="title">Chevaux</label>		<div class="column column4"><label><input type="checkbox" name="checkbox[]" value="4"/ ><span>4</span></label></div><span class="clearfix"></span>
		<div class="column column4"><label><input type="checkbox" name="checkbox[]" value="5"/ ><span>5</span></label></div><span class="clearfix"></span>
		<div class="column column4"><label><input type="checkbox" name="checkbox[]" value="6"/ ><span>6</span></label></div><span class="clearfix"></span>
		<div class="column column4"><label><input type="checkbox" name="checkbox[]" value="7"/ ><span>7</span></label></div><span class="clearfix"></span>
</div>
	<div class="element-radio<?php frmd_add_class("radio"); ?>"><label class="title">Energie</label>		<div class="column column3"><label><input type="radio" name="radio" value="Diesel		" /><span>Diesel		</span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="radio" name="radio" value="Essence" /><span>Essence</span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="radio" name="radio" value="GPL" /><span>GPL</span></label></div><span class="clearfix"></span>
</div>
	<div class="element-input<?php frmd_add_class("input1"); ?>"><label class="title">Kilométrage</label><input class="medium" type="text" name="input1" /></div>
	<div class="element-name<?php frmd_add_class("name"); ?>"><label class="title">Propriétaire</label><span class="nameFirst"><input  type="text" size="8" name="name[first]" /><label class="subtitle">Prenom</label></span><span class="nameLast"><input  type="text" size="14" name="name[last]" /><label class="subtitle">Nom</label></span></div>
	<div class="element-file<?php frmd_add_class("file"); ?>"><label class="title">Carte grise</label><label class="large" ><div class="button">Choisir un fichier</div><input type="file" class="file_input" name="file" /><div class="file_text">Aucun fichier selectionné</div></label></div>
<div class="submit"><input type="submit" value="Envoyer"/></div></form><script type="text/javascript" src="<?php echo dirname($form_path); ?>/formoid-flat-green.js"></script>

<!-- Stop Formoid form-->
<?php endif; ?>

<?php frmd_end_form(); ?>