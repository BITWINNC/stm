﻿<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 20/02/2019
 * Time: 13:38
 */

include("../../_cfg/cfg.php");


if(isset($_POST['valider'])){
    $name=$_POST['name'];
    $percent = $_POST['percent'];
    $value = ($percent /100);
    $is_active =1;
    $idTax = $_POST["idTax"];

    if(isset($_POST["default"]))
    {
        $isdefault = 1;
    }
    else{
        $isdefault = 0;
    }

    $array = array(
        'name' => $name,
        'percent' => $percent,
        'value' => $value,
        'isActive' => $is_active,
        'isDefault' => $isdefault
    );

    print_r($array);
    $tax = new Tax($array);
    $taxmanager = new TaxManager($bdd);
    $taxmanager->update($tax);

    //header('Location: '.URLHOST.$_COOKIE['company']."/taxe/afficher");

}