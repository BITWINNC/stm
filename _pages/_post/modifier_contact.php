<?php
include("../../_cfg/cfg.php");



if(isset($_POST['valider'])){
    $name=$_POST['name'];
    $firstname=$_POST['firstname'];

    if(!empty($_POST['emailAddress']))
    {
        $emailAddress = $_POST['emailAddress'];
    }
    else
    {
        $emailAddress = "";
    }
    if(!empty($_POST['phoneNumber']))
    {
        $phoneNumber = $_POST['phoneNumber'];
    }
    else
    {
        $phoneNumber = "";
    }

    $array = array(
        'idContact' => $contactId,
        'name' => $name,
        'firstname' => $firstname,
        'emailAddress' => $emailAddress,
        'phoneNumber' => $phoneNumber,
        'isActive' => 1
    );

    $contact = new Contact($array);
    $contactmanager = new ContactManager($bdd);

    if(isset($_POST["customerId"]))
    {
        $customerId = $_POST["customerId"];
        $contactmanager->update($contact);
        header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/supprime");
    }
    elseif (isset($_POST["supplierId"]))
    {
        $supplierId = $_POST["supplierId"];
        $contactmanager->update($contact);
        header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$supplierId."/supprime");
    }
}


?>
