<?php

$customerId = $_GET['soussouscat'];

//r�cup�ration de la liste des soci�t�s
$arrayCompanies = array();
$company = new Company($arrayCompanies);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

//R�cup�ration des donn�es client
$arrayClient = array();
$customer = new Customers($arrayClient);
$customermanager = new CustomersManager($bdd);
$customer = $customermanager->getByID($customerId);

//r�cup�ration des contacts du client
$arrayContact = array();
$contacts = new Contact($arrayContact);
$contactmanager = new ContactManager($bdd);
$contactmanager = $contactmanager->getList($customerId);

//r�cup�ration de la liste des taxes
$array = array();
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);
$taxmanager = $taxmanager->getList();

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light form-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Modification du client <span style="font-style: italic; font-weight: 800;"><?php echo $company->getName(); ?></span></span>
                </div>
            </div>
            <div class="portlet-body form">
                <form action="<?php echo URLHOST."_pages/_post/modifier_client.php"; ?>" method="post" id="form_sample_2" class="form-horizontal form-row-seperated">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Vous devez remplir les champs requis (<span class="required"> * </span>) </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Les modifications ont bien �t� prises en compte </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Nom du client
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="name" value="<?php echo $customer->getName(); ?>" /> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Adresse physique
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="physical_address" id="physical_address" value="<?php echo $customer->getPhysicalAddress(); ?>" /> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Adresse de facturation
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="invoice_address" id="invoice_address" value="<?php echo $customer->getInvoiceAddress(); ?>" /> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Fournisseur
                            </label>
                            <div class="col-md-8">
                                <div class="checkbox-list">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="is_supplier" name="is_supplier" id="is_supplier" /></label>
                                </div>
                                <span class="help-block"> Cocher si ce client est aussi un fournisseur </span>
                                <div id="form_2_services_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Soci�t�
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#company_error">
                                <?php
                                    $companiesList = explode(", ",$customer->getCompanyName());
    
                                    foreach ($companies as $company)
                                    {
                                ?>
                                        <label class="checkbox-inline">
                                <?php
                                        echo'<input type="checkbox" id="case[]" name="case[]" value="'.$company->getIdCompany().'" ';
                                        if(in_array($company->getName(),$companiesList)){ echo "checked=\"checked\""; }
                                        echo '/>';
                                        
                                        $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
                                        $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                ?>
                                            <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>" alt="<?php echo $company->getName(); ?>" class="logo-default" style="max-height: 20px;"/></a>
                                        </label>
                                <?php
                                    }
                                ?>
                                </div>
                                <span class="help-block"> Cocher la ou les soci�t�(s) affili�e(s) au client </span>
                                <div id="company_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Taxes
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#tax_error">
                                    <?php
    
                                    $taxList = new TaxManager($bdd);
                                    $taxList = $taxList->getListByCustomer($customer->getIdCustomer());
    
                                    foreach ($taxmanager as $tax)
                                    {
                                        ?>
                                        <label class="checkbox-inline">
                                            <?php
                                            echo'<input type="checkbox" id="taxes[]" name="taxes[]" value="'.$tax->getIdTax().'" ';
                                            if(in_array($tax,$taxList)){ echo "checked=\"checked\""; }
                                            echo '/>';
                                            echo $tax->getName();
                                            ?>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <span class="help-block">Cocher la ou les taxe(s) affili�e(s) au client </span>
                                <div id="company_error"> </div>
                            </div>
                        </div>
                        <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId; ?>">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="valider" id="valider" class="btn green">Valider</button>
                                    <button type="button" class="btn default">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>