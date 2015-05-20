<?php
session_start();
$lang = $_GET['fct_lang'];
$_SESSION['fct_lang'] = $lang;
header('Location: '. $_SERVER['HTTP_REFERER'] . '');
?>