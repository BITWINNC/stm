﻿<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idTax = $_GET["idTax"];

$array = array();
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);
$taxmanager->delete($idTax);
header('Location: '.URLHOST.$_COOKIE['company']."/taxe/afficher");

?>
