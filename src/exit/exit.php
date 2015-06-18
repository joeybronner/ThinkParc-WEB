<?php

session_start();
unset($_SESSION['fct_session']);
unset($_SESSION['fct_id_user']);
unset($_SESSION['fct_id_role']);
unset($_SESSION['fct_id_company']);
unset($_SESSION['fct_firstname']);
unset($_SESSION['fct_lastname']);
unset($_SESSION['fct_login']);
unset($_SESSION['fct_pass']);
unset($_SESSION['fct_email']);
unset($_SESSION['fct_image']);
unset($_SESSION['fct_lang']);
unset($_SESSION['fct_token']);
session_destroy();
header('Location: ../../index.php');

?>