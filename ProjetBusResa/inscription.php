<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if (isset($_POST["Register"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $FirstName = mysqli_real_escape_string($Connection, $_POST["FirstName"]);
    $LastName = mysqli_real_escape_string($Connection, $_POST["LastName"]);
    $IdNumber = mysqli_real_escape_string($Connection, $_POST["IdNumber"]);
    $Contact = mysqli_real_escape_string($Connection, $_POST["Contact"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    $ConfirmPassword = mysqli_real_escape_string($Connection, $_POST["ConfirmPassword"]);
    $UserRole="client";

    if (empty($Username) or empty($FirstName) or empty($LastName) or empty($IdNumber) or empty($Contact) or empty($Password)) {
        $_SESSION["ErrorMessage"] = "Tous les champs doivent être remplis";
        Redirect_to("inscription.php");
    } elseif (strlen($FirstName) > 255) {
        $_SESSION["ErrorMessage"] = "Nom trop long";
        Redirect_to("inscription.php");
    } elseif (strlen($LastName) > 255) {
        $_SESSION["ErrorMessage"] = "Prénom trop long";
        Redirect_to("inscription.php");
    }
    elseif (strlen($IdNumber) > 9) {
        $_SESSION["ErrorMessage"] = "Numero d'identification trop long";
        Redirect_to("inscription.php");
    } elseif (strlen($Contact) > 9) {
        $_SESSION["ErrorMessage"] = "Numero de téléphone trop long";
        Redirect_to("inscription.php");
    }
     elseif (strlen($Username) > 255) {
        $_SESSION["ErrorMessage"] = "Nom d'utilisateur trop long";
        Redirect_to("inscription.php");
    }
    elseif (strlen($Password) < 6) {
        $_SESSION["ErrorMessage"] = "Le mot de passe doit contenir au moins 6 caractères";
        Redirect_to("inscription.php");
    } elseif (strlen($Password) > 255) {
        $_SESSION["ErrorMessage"] = "Mot de passe trop long";
        Redirect_to("inscription.php");
    } elseif ($Password != $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Les mots de passe ne sont pas identiques";
        Redirect_to("inscription.php");
    } else {
        global $Connection;
        $Query = "INSERT INTO client(nomUser,nom,prenom,numCNI,numTel,motpasse,role)
        VALUES('$Username','$FirstName','$LastName','$IdNumber','$Contact','$Password','$UserRole')";
        $Execute = mysqli_query($Connection, $Query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Compte créé avec succès, veuillez vous connecter";
            Redirect_to("connexion.php");
        } else {
            global $Connection;
            $CheckQuery = "SELECT nomUser FROM client WHERE EXISTS (SELECT nomUser FROM admin WHERE nomUser='$Username')";
            $Execute = mysqli_query($Connection, $CheckQuery);
            if ($result = mysqli_fetch_assoc($Execute)) {
                $_SESSION["ErrorMessage"] = "Ce nom d'utilisateur existe déjà";
                Redirect_to("inscription.php");
            } else {
                $_SESSION["ErrorMessage"] = "Echec d'inscription, réessayez";
                Redirect_to("inscription.php");
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Inscription</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <div><?php echo ErrorMessage(); ?></div>
                <h1 id="logh1">Inscription</h1>
                <form action="inscription.php" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <label for="firstName"><span class="FieldInfo">Nom:</span></label>
                                <input type="text" name="FirstName" class="form-control" id="firstname" placeholder="Votre nom">
                        </div>
                        <div class="form-group">
                            <label for="lastname"><span class="FieldInfo">Prénom:</span></label>
                                <input type="text" name="LastName" class="form-control" id="lastname" placeholder="Votre prénom">
                        </div>
                        <div class="form-group">
                            <label for="idNum"><span class="FieldInfo">Numero de piece d'identité:</span></label>
                                <input type="text" name="IdNumber" class="form-control" id="idNum" placeholder="Entrer le numero de votre cni, passeport, etc...">
                        </div>
                        <div class="form-group">
                            <label for="numTel"><span class="FieldInfo">Numero de téléphone:</span></label>
                                <input type="number" name="Contact" class="form-control" id="numTel" placeholder="Numéro de téléphone">
                        </div>
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Nom d'utilisateur:</span></label>
                                <input type="text" name="Username" class="form-control" id="username" placeholder="Choisissez un nom d'utilisateur">
                        </div>
                        <div class="form-group">
                            <label for="pssword"><span class="FieldInfo">Mot de Passe:</span></label>
                                <input type="password" name="Password" class="form-control" id="password" placeholder="Entrer votre Mot de Passe">
                        </div>
                        <div class="form-group">
                            <label for="confpssword"><span class="FieldInfo">Confirmer Mot de Passe:</span></label>
                                <input type="password" name="ConfirmPassword" class="form-control" id="confpassword" placeholder="Entrer à nouveau votre Mot de Passe">
                        </div>
                        <div class="bottom-form">
                            <a href="connexion.php">Vous avez déjà un compte? Connectez-vous!</a>
                            <input type="submit" name="Register" value="Inscription" class="btn btn-lg btn-primary btn-block">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
</body>

</html>