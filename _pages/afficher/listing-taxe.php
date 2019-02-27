<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$array = array();
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);
$taxmanager = $taxmanager->getList();

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des taxes  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Nom de la Taxe</th>
                            <th class="min-phone-l">Valeur</th>
                            <th class="none">Actif</th>
                            <th class="none">Taxe par défaut</th>
                            <th class="min-tablet">Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($taxmanager as $tax) {
                        if($tax->getIsActive() == 1)
                        {
                            $tax->setIsActive("Oui");
                        }
                        else {
                            $tax->setIsActive("Non");
                        }
                        if($tax->getIsDefault() == 1)
                        {
                            $tax->setIsDefault("Oui");
                        }
                        else {
                            $tax->setIsDefault("Non");
                        }
                        ?>
                        <tr>
                            <td><?php echo $tax->getName(); ?></td>
                            <td><?php echo $tax->getPercent(); ?>%</td>
                            <td><?php echo $tax->getIsActive();?></td>
                            <td><?php echo $tax->getIsDefault();?></td>
                            <td><a href="<?php echo URLHOST.$_COOKIE['company'].'/taxe/modifier/'.$tax->getIdTax(); ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>