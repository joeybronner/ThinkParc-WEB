<?php
$target = $_GET['target']."/";
$path = $_POST['path'];
unlink($target.$path);
?>