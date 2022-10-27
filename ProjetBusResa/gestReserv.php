<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php $CurrentUserId = $_SESSION["User_Id"]; ?>
<?php AdminLogin_Confirm(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <title>Gestion des Réservations</title>
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
                    <li class="active">
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
                <h1>Gestion des Réservations</h1>
                <div> <?php echo SuccessMessage(); ?></div>
                <div class="table-responsive col-sm-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Numero</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Trajet</th>
                            <th>Agence</th>
                            <th>Départ</th>
                            <th>Action</th>
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
                                <td><a href="supreserv.php?Delete=<?php echo $Id; ?>"><button class="btn btn-danger" name="DeleteButton">Supprimer</button></a></td>
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