<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

echo "Résultats : ";
/*print_r($_POST['description']);
print_r($_POST['quantite']);
print_r($_POST["remise"]);
print_r($_POST["prix"]);*/

//print_r($_POST);
//echo $_POST['description'][0];

$array = array();
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$folder = $foldermanager->get($_POST["folder"]);
$folderId = $folder->getIdFolder();
$companyId = $folder->getCompanyId();
$customerId = $folder->getCustomerId();
$contactId = $folder->getContactId();

if(empty($_POST["label"]))
{
    $label = $folder->getLabel();
}
else{
    $label = $_POST["label"];
}


$year = date("Y");
$month = date("m");
$day = date("d");
$status = "En cours";
$type = "D";

$data = array(
    'status' => $status,
    'label' => $label,
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'type' => $type,
    'folderId' => $folderId,
    'companyId' => $companyId,
    'customerId' => $customerId,
    'contactId' => $contactId
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$quotationNumber = $quotationmanager->add($quotation);

if($quotationNumber != NULL){
    echo "j'ai réussi à insérer mon devis ".$quotationNumber;
}
else{
    echo "erreur j'ai rien créé";
}

?>