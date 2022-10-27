<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if (isset($_POST["Login"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);

    $FoundAccount = AdminLogin_Attempt($Username, $Password);
    if ($FoundAccount) {
        $_SESSION["User_Id"] = $FoundAccount["id"];
        $_SESSION["User"] = $FoundAccount["nom"];
        $_SESSION["SuccessMessage"] = "Bienvenue {$_SESSION["User"]} !";
        Redirect_to("gestAchat.php");
    } else {
        $_SESSION["ErrorMessage"] = "Login ou mot de passe incorrect";
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
    <link rel="stylesheet" href="css/login.css">
    <title>Connexion</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <div><?php echo ErrorMessage(); ?></div>
                <h1 id="logh1">Compte Administrateur</h1>
               <center><img src="logo.png" class="rounded" alt="ZingoBus logo"></center>
                <form action="connexionAdmin.php" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Nom d'Utilisateur:</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user text-primary"></i></span>
                                <input type="text" name="Username" class="form-control" id="username" placeholder="Nom d'utilisateur">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pssword"><span class="FieldInfo">Mot de Passe:</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock text-primary"></i></span>
                                <input type="password" name="Password" class="form-control" id="password" placeholder="Entrer Mot de Passe">
                            </div>
                        </div>
                        <div class="bottom-form">
                            <a href="connexion.php">Vous n'êtes pas Admin?</a>
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