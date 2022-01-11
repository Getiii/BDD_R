<?php

require "config/config.php";
require PATH_CONTROLEUR."/routeur.php";

$routeur=new Routeur();
session_start();
$routeur->routerRequete();
?>
