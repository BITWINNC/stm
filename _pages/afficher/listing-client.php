<?php

/**
 * @author Nicolas
 * @copyright 2019
 */



?>
<html>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['section']); ?>  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Nom</th>
                            <th class="min-phone-l">Afficher</th>
                            <th class="min-tablet">Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $verif = mysql_query("SELECT * FROM client WHERE id='".$id."';");
                        while($donnees = mysql_fetch_array($verif)){
                        /*$donnees_client = R::findAll("client","ORDER BY name DESC");
                        foreach($donnees_client as $client) :*/
                    ?>
                        <tr>
                            <td><?php echo $donnees['name']; ?></td>
                            <td><a href="<?php echo URLHOST.'client/afficher/'.$donnees['idcustomer']; ?>"><i class="fas fa-eye" alt="D�tail"></i></a></td>
                            <td><a href="<?php echo URLHOST.'client/modifier/'.$donnees['idcustomer']; ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
                        </tr>
                    <?php
                    }
                        //endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
</html>