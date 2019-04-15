<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");
include "../../_cfg/fonctions.php";

$quotationNumber = $_POST['quotationNumber'];
$dateTab = explode("/",$_POST['date']);
$type2 = $_POST['type'];
$percent = $_POST["shattered_percent"];

$array = array();
$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$quotationGet = $quotationmanager->getByQuotationNumber($quotationNumber);

$year = $dateTab[2];
$month = $dateTab[1];
$day = $dateTab[0];

if($_POST["shattered"] == "full" || $percent == 100)
{
    $data = array(
        'idQuotation' => $quotationGet->getIdQuotation(),
        'status' => 'En cours',
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'type' => 'P'
    );

    $quotation = new Quotation($data);

    $test = $quotationmanager->changeType($quotation);
    $test2 = "ok";
    $test3 ="ok";
    $test4 = "ok";
    $test5 = "ok";
}
elseif ($_POST["shattered"] == "partial" && $percent < 100)
{
    $descriptionmanager = new DescriptionManager($bdd);
    $description = new Description($array);

    $shatteredQuotationManager = new ShatteredQuotationManager($bdd);

    $folderId = $quotationGet->getFolderId();
    $companyId = $quotationGet->getCompanyId();
    $customerId = $quotationGet->getCustomerId();
    $contactId = $quotationGet->getContactId();
    $comment = $quotationGet->getComment();
    $label = $quotationGet->getLabel();
    $type3 = $quotationGet->getType();

    $year = date("Y");
    $month = date("m");
    $day = date("d");
    $status = "En cours";
    $type = "S"; // shattered quotation

    $data = array(
        'status' => $status,
        'label' => $label,
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'type' => $type,
        'comment' => $comment,
        'folderId' => $folderId,
        'companyId' => $companyId,
        'customerId' => $customerId,
        'contactId' => $contactId
    );

    $duplicate = new Quotation($data);
    $newquotationNumber = $quotationmanager->add($duplicate);

    //si le devis est déjà partiel, je récupère les données initiales
    if($type3 == "S")
    {
        $shatteredQuotationInit = new ShatteredQuotation($array);
        $shatteredQuotationInit = $shatteredQuotationManager->getByQuotationNumberChild($quotationNumber);
        $quotationNumber = $shatteredQuotationInit->getQuotationNumberInit();
        $quotationNumberChild = $shatteredQuotationInit->getQuotationNumberChild();
        $quotationInit = $quotationNumber."_init";
        $getDescription = $descriptionmanager->getByQuotationNumber($quotationInit);
        $rest = $shatteredQuotationInit->getPercent();
        $rest = $rest - $percent;
        $idShatteredQuotation = $shatteredQuotationInit->getIdShatteredQuotation();
    }
    else
    {
        $getDescription = $descriptionmanager->getByQuotationNumber($quotationNumber);
        $quotationInit = $quotationGet->getQuotationNumber()."_init";
        $rest = 100 - $percent;
        $i = 0;
        $descriptions= array();
        foreach ($getDescription as $description)
        {
            $description->setQuotationNumber($quotationInit);
            $descriptions[$i] = $description;
            $i++;
        }
        // Duplication des descriptions pour garder l'original
        $test = $descriptionmanager->add($descriptions,$quotationInit);
    }

    $dataShattered = array(
        'quotationNumberInit' => $quotationNumber,
        'quotationNumberChild' => $newquotationNumber,
        'percent' => $rest
    );
    $shatteredQuotation = new ShatteredQuotation($dataShattered);
    $test2 = $shatteredQuotationManager->add($shatteredQuotation);

    //Copie effectuée sur la description, on a créé l'object devis partiel et on a stocké le pourcentage restant à facturer

    $j = 0;
    $descriptionsReduced= array();
    $descriptionReduced = new Description($array);

    foreach ($getDescription as $descriptionReduced)
    {
        $value = getPercentOfNumber($descriptionReduced->getPrice(),$percent);
        $descriptionReduced->setPrice(round($value));
        $descriptionsReduced[$j] = $descriptionReduced;
        $j++;
    }
    if($type3 == "S"){
        $test3 = $descriptionmanager->update($descriptionsReduced,$quotationNumberChild);
    }
    else{
        $test3 = $descriptionmanager->update($descriptionsReduced,$quotationNumber);
    }

    if($rest != 0)
    {
        $getDescriptionInit = $descriptionmanager->getByQuotationNumber($quotationInit);
        $descriptionRest = new Description($array);
        $k = 0;
        foreach ($getDescriptionInit as $descriptionRest)
        {
            $value = getPercentOfNumber($descriptionRest->getPrice(),$rest);
            $descriptionRest->setPrice(round($value));
            $descriptionRest->setQuotationNumber($newquotationNumber);
            $descriptions[$k] = $descriptionRest;
            $k++;
        }
        //insertion du reste à payer
        $test4 = $descriptionmanager->add($descriptions,$newquotationNumber);
    }
    else
    {
        $test4a = $descriptionmanager->delete($quotationInit);
        $test4b = $shatteredQuotation->delete($idShatteredQuotation);
    }


    $data = array(
        'idQuotation' => $quotationGet->getIdQuotation(),
        'status' => 'En cours',
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'type' => 'P'
    );
    $quotation = new Quotation($data);
    $test5 = $quotationmanager->changeType($quotation);
}

if(is_null($test) || is_null($test2) || is_null($test3) || is_null($test4) || is_null($test5)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorProforma');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/proforma/afficher/'.$type2.'/'.$quotationNumber.'/successProforma');
}

?>