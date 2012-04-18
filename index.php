<?php
//inicio projeto no GitHub
session_start();
require_once 'sistem/control.php';
$o_control = new Control();
$o_control->run();
?>