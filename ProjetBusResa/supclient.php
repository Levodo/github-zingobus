<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php AdminLogin_Confirm();?>

<?php
if (isset($_GET["Delete"])) {
    $ClientId = $_GET["Delete"];
    global $Connection;
    $Query = "DELETE FROM client  WHERE id='$ClientId'";
    $Execute = mysqli_query($Connection, $Query);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Client supprimé avec succès";
        Redirect_to("client.php");
    } else {
        $_SESSION["ErrorMessage"] = "Erreur de suppression, réessayez";
        Redirect_to("client.php");
    }
}
?>