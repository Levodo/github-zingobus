<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if (isset($_POST["Login"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);

    $FoundAccount = ClientLogin_Attempt($Username, $Password);
    if ($FoundAccount) {
        $_SESSION["User_Id"] = $FoundAccount["id"];
        $_SESSION["User"] = $FoundAccount["nomUser"];
        $_SESSION["SuccessMessage"] = "Bienvenue {$_SESSION["User"]} !";
        Redirect_to("client_achat.php");
    } else {
        $_SESSION["ErrorMessage"] = "Login ou mot de passe icorrect";
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
    <title>Connexion</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <div><?php echo ErrorMessage(); ?></div>
                <div><?php echo SuccessMessage(); ?></div>
                <h1 id="logh1">Connexion</h1>
                <form action="connexion.php" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Nom d'utilisateur:</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user text-primary"></i></span>
                                <input type="text" name="Username" class="form-control" id="username" placeholder="Nom d'utilisateur">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pssword"><span class="FieldInfo">Mot de Passe:</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock text-primary"></i></span>
                                <input type="password" name="Password" class="form-control" id="password" placeholder="Entrer votre Mot de Passe">
                            </div>
                        </div>
                        <div class="bottom-form">
                            <a href="inscription.php">Vous n'avez pas de compte? Inscrivez-vous!</a>
                            <br>
                            <br>
                            <a href="connexionAdmin.php">Connexion Admin</a>
                            <input type="submit" name="Login" value="Connexion" class="btn btn-lg btn-primary btn-block">
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