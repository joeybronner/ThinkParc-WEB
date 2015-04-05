<?php

session_start();
unset($_SESSION['fct_authentification']);
unset($_SESSION['fct_privilege']);
unset($_SESSION['fct_nom']);
unset($_SESSION['fct_prenom']);
unset($_SESSION['fct_id']);
unset($_SESSION['fct_login']);
unset($_SESSION['fct_password']);
session_destroy();
header('Location: ../../index.html');

?>