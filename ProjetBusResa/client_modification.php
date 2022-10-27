<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php $CurrentUserId = $_SESSION["User_Id"]; ?>
<?php ClientLogin_Confirm(); ?>
<?php
if (isset($_POST["Register"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $FirstName = mysqli_real_escape_string($Connection, $_POST["FirstName"]);
    $LastName = mysqli_real_escape_string($Connection, $_POST["LastName"]);
    $IdNumber = mysqli_real_escape_string($Connection, $_POST["IdNumber"]);
    $Contact = mysqli_real_escape_string($Connection, $_POST["Contact"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    $ConfirmPassword = mysqli_real_escape_string($Connection, $_POST["ConfirmPassword"]);

    if (empty($Username) or empty($FirstName) or empty($LastName) or empty($IdNumber) or empty($Contact) or empty($Password)) {
        $_SESSION["ErrorMessage"] = "Tous les champs doivent être remplis";
        Redirect_to("client_modification.php");
    } elseif (strlen($FirstName) > 255) {
        $_SESSION["ErrorMessage"] = "Nom trop long";
        Redirect_to("client_modification.php");
    } elseif (strlen($LastName) > 255) {
        $_SESSION["ErrorMessage"] = "Prénom trop long";
        Redirect_to("client_modification.php");
    } elseif (strlen($IdNumber) > 9) {
        $_SESSION["ErrorMessage"] = "Numero d'identification trop long";
        Redirect_to("client_modification.php");
    } elseif (strlen($Contact) > 9) {
        $_SESSION["ErrorMessage"] = "Numero de téléphone trop long";
        Redirect_to("client_modification.php");
    } elseif (strlen($Username) > 255) {
        $_SESSION["ErrorMessage"] = "Nom d'utilisateur trop long";
        Redirect_to("client_modification.php");
    } elseif (strlen($Password) < 6) {
        $_SESSION["ErrorMessage"] = "Le mot de passe doit contenir au moins 6 caractères";
        Redirect_to("client_modification.php");
    } elseif (strlen($Password) > 255) {
        $_SESSION["ErrorMessage"] = "Mot de passe trop long";
        Redirect_to("client_modification.php");
    } elseif ($Password != $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Les mots de passe ne sont pas identiques";
        Redirect_to("client_modification.php");
    } else {
        global $Connection;
        $EditFromUrl = $_GET["Edit"];

        $Query = "UPDATE client SET nomUser='$Username',motpasse='$Password',nom='$FirstName',prenom='$LastName',numCNI='$IdNumber',numTel='$Contact' WHERE id='$EditFromUrl'";

        $Execute = mysqli_query($Connection, $Query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Compte modifié avec succès";
            Redirect_to("client_achat.php");
        } else {
            $_SESSION["ErrorMessage"] = "Echec de modification, réessayez!";
            Redirect_to("client_modification.php");
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
    <title>Modifier compte</title>
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
                    <li>
                        <a href="client_reservation.php">
                            <span class="glyphicon glyphicon-calendar"></span>
                            &nbsp;Réservations
                        </a>
                    </li>
                    <li class="active">
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
                <h1>Modifier infos de compte</h1>
                <div> <?php echo ErrorMessage();
                        echo SuccessMessage();
                        ?></div>
                <div>
                    <?php
                    $PostIDFromUrl = $_GET["Edit"];
                    global $Connection;
                    $ViewQuery = "SELECT * FROM client WHERE id='$PostIDFromUrl'";
                    $Execute = mysqli_query($Connection, $ViewQuery);
                    while ($DataRows = mysqli_fetch_array($Execute)) {
                        $MId = $DataRows["id"];
                        $MUsername = $DataRows["nomUser"];
                        $MPassword = $DataRows["motpasse"];
                        $MFirstName = $DataRows["nom"];
                        $MLastName = $DataRows["prenom"];
                        $MIdNumber = $DataRows["numCNI"];
                        $MContact = $DataRows["numTel"];
                    } ?>
                    <form action="client_modification.php?Edit=<?php echo $PostIDFromUrl; ?>" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="firstName"><span class="FieldInfo">Nom:</span></label>
                                <input type="text" name="FirstName" class="form-control" id="firstname" value="<?php echo $MFirstName ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname"><span class="FieldInfo">Prénom:</span></label>
                                <input type="text" name="LastName" class="form-control" id="lastname" value="<?php echo $MLastName ?>">
                            </div>
                            <div class=" form-group">
                                <label for="idNum"><span class="FieldInfo">Numero de piece d'identité:</span></label>
                                <input type="text" name="IdNumber" class="form-control" id="idNum" value="<?php echo $MIdNumber ?>">
                            </div>
                            <div class="form-group">
                                <label for="numTel"><span class="FieldInfo">Numero de téléphone:</span></label>
                                <input type="number" name="Contact" class="form-control" id="numTel" value="<?php echo $MContact ?>">
                            </div>
                            <div class="form-group">
                                <label for="username"><span class="FieldInfo">Nom d'utilisateur:</span></label>
                                <input type="text" name="Username" class="form-control" id="username" value="<?php echo $MUsername ?>">
                            </div>
                            <div class="form-group">
                                <label for="pssword"><span class="FieldInfo">Mot de Passe:</span></label>
                                <input type="password" name="Password" class="form-control" id="password" value="<?php echo $MPassword ?>">
                            </div>
                            <div class="form-group">
                                <label for="confpssword"><span class="FieldInfo">Confirmer Mot de Passe:</span></label>
                                <input type="password" name="ConfirmPassword" class="form-control" id="confpassword" value="<?php echo $MPassword ?>">
                            </div>
                            <div class="bottom-form">
                                <input type="submit" name="Register" value="Modifier" class="btn btn-lg btn-primary btn-block">
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">


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