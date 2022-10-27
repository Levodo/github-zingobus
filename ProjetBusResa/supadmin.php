<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php AdminLogin_Confirm(); ?>
<?php AdminPSession_Confirm(); ?>

<?php
if (isset($_GET["Delete"])) {
    $AdminId = $_GET["Delete"];
    global $Connection;
    $Query = "DELETE FROM admin  WHERE id='$AdminId'";
    $Execute = mysqli_query($Connection, $Query);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Admin supprimé avec succès";
        Redirect_to("admins.php");
    } else {
        $_SESSION["ErrorMessage"] = "Erreur de suppression, réessayez";
        Redirect_to("admins.php");
    }
}
?>