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

echo $_POST["folder"];

$array = array();
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$folder = $foldermanager->get($_POST["folder"]);


$year = date("Y");
$month = date("m");
$day = date("d");
$status = "D";

$data = array(
    'status' => $status,
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'folderId' => $folder->getFolderId(),
    'companyId' => $folder->getCompanyId(),
    'customerId' => $folder->getCustomerId(),
    'contactId' => $folder->getContactId()
);
$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);
print_r($data);
echo $quotation->getContactId();
echo $quotation->getCustomerId();
echo $quotation->getCompanyId();
echo $quotation->getFolderId();
echo $quotation->getStatus();

//$quotationNumber = $quotationmanager->add($quotation);
/*if($quotationNumber != NULL){
    echo "j'ai réussi à insérer mon devis";
}*/

?>