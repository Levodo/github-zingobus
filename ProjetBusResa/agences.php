<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php $CurrentUserId = $_SESSION["User_Id"]; ?>
<?php AdminLogin_Confirm(); ?>
<?php
if (isset($_POST["Submit"])) {
    $Agence = mysqli_real_escape_string($Connection, $_POST["Agence"]);
    $Localisation = mysqli_real_escape_string($Connection, $_POST["Localisation"]);
    $Contact = mysqli_real_escape_string($Connection, $_POST["Contact"]);
    $ChefAgence = mysqli_real_escape_string($Connection, $_POST["ChefAgence"]);
    if (empty($Agence) or empty($Localisation) or empty($Contact) or empty($ChefAgence)) {
        $_SESSION["ErrorMessage"] = "Tous les champs doivent être remplis";
        Redirect_to("agences.php");
    } elseif (strlen($Agence) > 255) {
        $_SESSION["ErrorMessage"] = "Nom d'agence trop long";
        Redirect_to("agences.php");
    } elseif (strlen($Localisation) > 255) {
        $_SESSION["ErrorMessage"] = "Nom Localisation trop long";
        Redirect_to("agences.php");
    } elseif (strlen($Contact) > 9) {
        $_SESSION["ErrorMessage"] = "Contact trop long";
        Redirect_to("agences.php");
    } elseif (strlen($ChefAgence) > 255) {
        $_SESSION["ErrorMessage"] = "Nom du chef d'agence trop long";
        Redirect_to("agences.php");
    } else {
        global $Connection;
        $Query = "INSERT INTO agence(nom,locAg,telAg,chefAg)
        VALUES('$Agence','$Localisation','$Contact','$ChefAgence')";
        $Execute = mysqli_query($Connection, $Query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Agence ajoutée avec succès";
            Redirect_to("agences.php");
        } else {
            $_SESSION["ErrorMessage"] = "Erreur d'ajout d'agence";
            Redirect_to("agences.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <title>Gestion Agences</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="panel_menu col-sm-2">
                <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                    <li>
                        <a href="gestAchat.php">
                            <span class="glyphicon glyphicon-credit-card"></span>
                            &nbsp;Gestion Achats
                        </a>
                    </li>
                    <li>
                        <a href="gestReserv.php">
                            <span class="glyphicon glyphicon-calendar"></span>
                            &nbsp;Gestion Réservations
                        </a>
                    </li>
                    <li class="active">
                        <a href="agences.php">
                            <span class="glyphicon glyphicon-home"></span>
                            &nbsp;Gestion Agences
                        </a>
                    </li>
                    <?php
                    global $Connection;
                    $VQuery = "SELECT * FROM admin WHERE id='$CurrentUserId'";
                    $VExecute = mysqli_query($Connection, $VQuery);
                    while ($DataRows = mysqli_fetch_array($VExecute)) {
                        $Id = $DataRows["id"];
                        $Role = $DataRows["role"];
                        if ($Role == "adminPrincipal") {
                            echo '<li>
                        <a href="admins.php">
                            <span class="glyphicon glyphicon-user"></span>
                            &nbsp;Gestion Admins
                        </a>
                    </li>
                        ';
                        }
                    }
                    ?>
                    <li>
                        <a href="client.php">
                            <span class="glyphicon glyphicon-user"></span>
                            &nbsp;Gestion Clients
                        </a>
                    </li>
                    <li>
                        <a href="trajet.php">
                            <span class="glyphicon glyphicon-road"></span>
                            &nbsp;Gestion Trajets
                        </a>
                    </li>
                    <li>
                        <a href="deconnexion.php">
                            <span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-10">
                <h1>Gestion Agences</h1>
                <div><?php echo ErrorMessage(); ?></div>
                <div><?php echo SuccessMessage(); ?></div>
                <div>
                    <form action="agences.php" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label for="nomAgence"><span class="FieldInfo">Nom de l'Agence:</span></label>
                                <input type="text" name="Agence" class="form-control" id="nomAgence" placeholder="Entrer le nom de l'agence">
                            </div>
                            <div class="form-group">
                                <label for="locAgence"><span class="FieldInfo">Localisation:</span></label>
                                <input type="text" name="Localisation" class="form-control" id="locAgence" placeholder="Localisation de l'agence">
                            </div>
                            <div class="form-group">
                                <label for="telAgence"><span class="FieldInfo">Contact:</span></label>
                                <input type="number" name="Contact" class="form-control" id="telAgence" placeholder="Contact de l'agence">
                            </div>
                            <div class="form-group">
                                <label for="chefAgence"><span class="FieldInfo">Chef d'Agence:</span></label>
                                <input type="text" name="ChefAgence" class="form-control" id="chefAgence" placeholder="Désigner un chef d'agence">
                            </div>
                            <input type="submit" name="Submit" value="Ajouter Agence" class="btn btn-success btn-block">
                        </fieldset>
                    </form>
                </div>
                <div class="table-responsive col-sm-12">
                    <table class="table table-striped">
                        <tr>
                            <th>No.</th>
                            <th>Nom Agence</th>
                            <th>Localisation</th>
                            <th>Chef Agence</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        global $Connection;
                        $ViewQuery = "SELECT * FROM agence ORDER BY id desc";
                        $Execute = mysqli_query($Connection, $ViewQuery);
                        $SrNo = 0;
                        while ($DataRows = mysqli_fetch_array($Execute)) {
                            $Id = $DataRows["id"];
                            $Agence = $DataRows["nom"];
                            $Localisation = $DataRows["locAg"];
                            $Contact = $DataRows["telAg"];
                            $ChefAgence = $DataRows["chefAg"];
                            $SrNo++;
                        ?>
                            <tr>
                                <td><?php echo $SrNo ?></td>
                                <td><?php echo $Agence ?></td>
                                <td><?php echo $Localisation ?></td>
                                <td><?php echo $ChefAgence ?></td>
                                <td><a href="supAgence.php?Delete=<?php echo $Id; ?>"><button class="btn btn-danger" name="DeleteButton">Supprimer</button></a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div id="Footer">
        <hr>
        <p>
            ZingoBus | &copy;2019-2020 --- All right reserved.
        </p>
        <a href="#">
            <p>
                Votre agence de voyage par exellence &trade;
            </p>
            <hr>
        </a>
    </div>
    <div></div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
</body>

</html>