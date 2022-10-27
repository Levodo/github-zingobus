<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php $CurrentUserId = $_SESSION["User_Id"]; ?>
<?php AdminLogin_Confirm(); ?>
<?php AdminPSession_Confirm(); ?>
<?php
if (isset($_POST["Submit"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    $ConfirmPassword = mysqli_real_escape_string($Connection, $_POST["ConfirmPassword"]);
    $UserRole = mysqli_real_escape_string($Connection, $_POST["Role"]);
    if (empty($Username) or empty($Password)) {
        $_SESSION["ErrorMessage"] = "Tous les champs doivent être remplis";
        Redirect_to("admins.php");
    } elseif (strlen($Username) > 255) {
        $_SESSION["ErrorMessage"] = "Nom d'utilisateur trop long";
        Redirect_to("admins.php");
    } elseif (strlen($Password) < 6) {
        $_SESSION["ErrorMessage"] = "Le mot de passe doit contenir au moins 6 caractères";
        Redirect_to("admins.php");
    } elseif (strlen($Password) > 255) {
        $_SESSION["ErrorMessage"] = "Mot de passe trop long";
        Redirect_to("admins.php");
    } elseif ($Password != $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Les mots de passe ne sont pas identiques";
        Redirect_to("admins.php");
    } else {
        global $Connection;
        $Query = "INSERT INTO admin(nom,motpasse,role)
        VALUES('$Username','$Password','$UserRole')";
        $Execute = mysqli_query($Connection, $Query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Admin ajouté avec succès";
            Redirect_to("admins.php");
        } else {
            global $Connection;
            $CheckQuery = "SELECT nom FROM admin WHERE EXISTS (SELECT nom FROM admin WHERE nom='$Username')";
            $Execute = mysqli_query($Connection, $CheckQuery);
            if ($result = mysqli_fetch_assoc($Execute)) {
                $_SESSION["ErrorMessage"] = "Ce nom d'utilisateur existe déjà";
                Redirect_to("admins.php");
            } else {
                $_SESSION["ErrorMessage"] = "Echec d'ajout d'admin, réessayez";
                Redirect_to("admins.php");
            }
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <title>Gestion Admins</title>
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
                        if($Role=="adminPrincipal"){
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
                <h1>Gestion Admins</h1>
                <div><?php echo ErrorMessage(); ?></div>
                <div><?php echo SuccessMessage(); ?></div>
                <div>
                    <form action="admins.php" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label for="username"><span class="FieldInfo">Nom d'Utilisateur:</span></label>
                                <input type="text" name="Username" class="form-control" id="username" placeholder="Entrer le nom d'utilisateur">
                            </div>
                            <div class="form-group">
                                <label for="pssword"><span class="FieldInfo">Mot de Passe:</span></label>
                                <input type="password" name="Password" class="form-control" id="password" placeholder="Entrer votre Mot de Passe">
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword"><span class="FieldInfo">Confirmer Mot de Passe:</span></label>
                                <input type="password" name="ConfirmPassword" class="form-control" id="confirmpassword" placeholder="Confirmer votre Mot de Passe">
                            </div>
                            <div class="form-group">
                                <label for="userRole"><span class="FieldInfo">Sélectionner un rôle:</span></label>
                                <select id="userRole" class="form-control" name="Role">
                                    <option value="adminAgence">Administrateur d'Agence</option>
                                    <option value="adminPrincipal">Administrateur Principal</option>
                                </select>
                            </div>
                            <input type="submit" name="Submit" value="Ajouter administrateur" class="btn btn-success btn-block">
                        </fieldset>
                    </form>
                </div>
                <div class="table-responsive col-sm-12">
                    <table class="table table-striped">
                        <tr>
                            <th>No.</th>
                            <th>Nom</th>
                            <th>Rôle</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        global $Connection;
                        $ViewQuery = "SELECT * FROM admin ORDER BY id desc";
                        $Execute = mysqli_query($Connection, $ViewQuery);
                        $SrNo = 0;
                        while ($DataRows = mysqli_fetch_array($Execute)) {
                            $Id = $DataRows["id"];
                            $Username = $DataRows["nom"];
                            $UserRole = $DataRows["role"];
                            $SrNo++;
                        ?>
                            <tr>
                                <td><?php echo $SrNo ?></td>
                                <td><?php echo $Username ?></td>
                                <td><?php echo $UserRole ?></td>
                                <td><a href="supadmin.php?Delete=<?php echo $Id; ?>"><button class="btn btn-danger" name="DeleteButton">Supprimer</button></a></td>
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