<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php $CurrentUserId = $_SESSION["User_Id"]; ?>
<?php AdminLogin_Confirm(); ?>
<?php
if (isset($_POST["Submit"])) {
    $Trajet = mysqli_real_escape_string($Connection, $_POST["Trajet"]);
    $Prix = mysqli_real_escape_string($Connection, $_POST["Prix"]);
    if (empty($Trajet) or empty($Prix)) {
        $_SESSION["ErrorMessage"] = "Tous les champs doivent être remplis";
        Redirect_to("trajet.php");
    } elseif (strlen($Trajet) > 255) {
        $_SESSION["ErrorMessage"] = "Description trajet trop longue";
        Redirect_to("trajet.php");
    } elseif ($Prix < 0) {
        $_SESSION["ErrorMessage"] = "Prix invalide";
        Redirect_to("trajet.php");
    } else {
        global $Connection;
        $Query = "INSERT INTO trajet(lignetrajet,prix)
        VALUES('$Trajet','$Prix')";
        $Execute = mysqli_query($Connection, $Query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Trajet ajouté avec succès";
            Redirect_to("trajet.php");
        } else {
            $_SESSION["ErrorMessage"] = "Echec d'ajout de trajet";
            Redirect_to("trajet.php");
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
    <title>Gestion Trajets</title>
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
                    <li>
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
                    <li class="active">
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
                <h1>Gestion Trajets</h1>
                <div><?php echo ErrorMessage(); ?></div>
                <div><?php echo SuccessMessage(); ?></div>
                <div>
                    <form action="trajet.php" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label for="ligneTrajet"><span class="FieldInfo">Trajet:</span></label>
                                <input type="text" name="Trajet" class="form-control" id="ligneTrajet" placeholder="Description du trajet">
                            </div>
                            <div class="form-group">
                                <label for="prixTrajet"><span class="FieldInfo">Prix:</span></label>
                                <input type="number" name="Prix" class="form-control" id="prixTrajet" placeholder="Definir un prix">
                            </div>
                            <input type="submit" name="Submit" value="Ajouter Trajet" class="btn btn-success btn-block">
                        </fieldset>
                    </form>
                </div>
                <div class="table-responsive col-sm-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Sr No.</th>
                            <th>Trajet</th>
                            <th>Prix</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        global $Connection;
                        $ViewQuery = "SELECT * FROM trajet ORDER BY id desc";
                        $Execute = mysqli_query($Connection, $ViewQuery);
                        $SrNo = 0;
                        while ($DataRows = mysqli_fetch_array($Execute)) {
                            $Id = $DataRows["id"];
                            $Trajet = $DataRows["lignetrajet"];
                            $Prix = $DataRows["prix"];
                            $SrNo++;
                        ?>
                            <tr>
                                <td><?php echo $SrNo ?></td>
                                <td><?php echo $Trajet ?></td>
                                <td><?php echo $Prix ?></td>
                                <td><a href="suptrajet.php?Delete=<?php echo $Id; ?>"><button class="btn btn-danger" name="DeleteButton">Supprimer</button></a></td>
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