﻿<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/02/2019
 * Time: 09:12
 */

include("../../_cfg/cfg.php");

if(isset($_POST['valider'])) {
    $name=$_POST['name'];
    $address=$_POST['address'];
    $isActive = 1;
    $_FILES['nameData'] = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $name));

    if (isset($_FILES['nameData'])) {
        $uploadDir = URLHOST.'images/societe/'; //path you wish to store you uploaded files
        $uploadedFile = $uploadDir . basename($_FILES['nameData']["name"]);
        echo $uploadDir."<br/>";
        echo $uploadedFile;
        /*if (move_uploaded_file($_FILES['nameData']['tmp_name'], $uploadedFile)) {
            echo 'File was uploaded successfully.';
        } else {
            echo 'There was a problem saving the uploaded file';
        }*/
    }

    $array = array(
        'name' => $name,
        'address' => $address,
        'isActive' => $isActive
    );

    /*$company = new Company($array);
    $companiesmanager = new CompaniesManager($bdd);
    $companiesmanager->add($company);*/

}

?>

<a href="saisie_company.php"> revenir à la création de Société </a>