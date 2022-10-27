<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php $CurrentUserId = $_SESSION["User_Id"]; ?>
<?php ClientLogin_Confirm(); ?>
<?php
if (isset($_POST["Submit"])) {
    $Trajet = mysqli_real_escape_string($Connection, $_POST["Trajet"]);
    $Agence = mysqli_real_escape_string($Connection, $_POST["Agence"]);
    $Depart = mysqli_real_escape_string($Connection, $_POST["Depart"]);
    date_default_timezone_set("Africa/Douala");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    global $Connection;
    $VQuery = "SELECT * FROM client WHERE id='$CurrentUserId'";
    $VExecute = mysqli_query($Connection, $VQuery);
    while ($DataRows = mysqli_fetch_array($VExecute)) {
        $Id = $DataRows["id"];
        $CName = $DataRows["nom"];
        $CSurname = $DataRows["prenom"];
        $Client = $CName . " " . $CSurname;
    }

    global $Connection;
    $Query = "INSERT INTO reservation(date,reservClient,reservTrajet,reservAgence,depart)
        VALUES('$DateTime','$Client','$Trajet','$Agence','$Depart')";
    $Execute = mysqli_query($Connection, $Query);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Réservation éffectuée avec succès";
        Redirect_to("client_reservation.php");
    } else {
        $_SESSION["ErrorMessage"] = "Echec de réservation";
        Redirect_to("client_reservation.php");
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
    <title>Réservation</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="panel_menu col-sm-2">
                <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                    <li>
                        <a href="client_achat.php">
                            <span class="glyphicon glyphicon-credit-card"></span>
                            &nbsp;Achat
                        </a>
                    </li>
                    <li class="active">
                        <a href="client_reservation.php">
                            <span class="glyphicon glyphicon-calendar"></span>
                            &nbsp;Réservations
                        </a>
                    </li>
                    <li>
                        <a href="client_modification.php?Edit=<?php echo $CurrentUserId ?>">
                            <span class="glyphicon glyphicon-wrench"></span>
                            &nbsp;Modifier infos compte
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
                <h1>Effectuer une réservation</h1>
                <div><?php echo ErrorMessage(); ?></div>
                <div><?php echo SuccessMessage(); ?></div>
                <div>
                    <form action="client_reservation.php" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label for="trajet"><span class="FieldInfo">Trajet:</span></label>
                                <select class="form-control" name="Trajet" id="trajet">
                                    <?php
                                    global $Connection;
                                    $ViewQuery = "SELECT lignetrajet,prix FROM trajet";
                                    $Execute = mysqli_query($Connection, $ViewQuery);
                                    while ($DataRows = mysqli_fetch_array($Execute)) {
                                        $Id = $DataRows["id"];
                                        $Trajet = $DataRows["lignetrajet"];
                                        $Prix = $DataRows["prix"];
                                    ?>
                                        <option><?php echo $Trajet . " (" . $Prix . " FCFA" . ") " ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="agence"><span class="FieldInfo">Agence:</span></label>
                                <select class="form-control" name="Agence" id="agence">
                                    <?php
                                    global $Connection;
                                    $ViewQuery = "SELECT nom FROM agence";
                                    $Execute = mysqli_query($Connection, $ViewQuery);
                                    while ($DataRows = mysqli_fetch_array($Execute)) {
                                        $Id = $DataRows["id"];
                                        $Agence = $DataRows["nom"];
                                    ?>
                                        <option><?php echo $Agence ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="depart"><span class="FieldInfo">Départ:</span></label>
                                <input type="date" name="Depart" id="depart" class="form-control">
                            </div>
                            <input type="submit" name="Submit" value="Enregistrer" class="btn btn-success btn-block">
                        </fieldset>
                    </form>
                </div>
                <br><br>
                <h3>Historique des réservations</h3>
                <br>
                <div class="table-responsive col-sm-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Numero</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Trajet</th>
                            <th>Agence</th>
                            <th>Depart</th>
                        </tr>
                        <?php
                        global $Connection;
                        $ViewQuery = "SELECT * FROM reservation ORDER BY id desc";
                        $Execute = mysqli_query($Connection, $ViewQuery);
                        while ($DataRows = mysqli_fetch_array($Execute)) {
                            $Id = $DataRows["id"];
                            $DateTime = $DataRows["date"];
                            $Client = $DataRows["reservClient"];
                            $Trajet = $DataRows["reservTrajet"];
                            $Agence = $DataRows["reservAgence"];
                            $Depart = $DataRows["depart"];
                        ?>
                            <tr>
                                <td><?php echo $Id ?></td>
                                <td><?php echo $DateTime ?></td>
                                <td><?php echo $Client ?></td>
                                <td><?php echo $Trajet ?></td>
                                <td><?php echo $Agence ?></td>
                                <td><?php echo $Depart ?></td>
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