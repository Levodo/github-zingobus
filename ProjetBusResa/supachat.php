<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php AdminLogin_Confirm();?>

<?php
if (isset($_GET["Delete"])) {
    $AchatId = $_GET["Delete"];
    global $Connection;
    $Query = "DELETE FROM achat  WHERE id='$AchatId'";
    $Execute = mysqli_query($Connection, $Query);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Achat supprimé avec succès";
        Redirect_to("gestAchat.php");
    } else {
        $_SESSION["ErrorMessage"] = "Erreur de suppression, réessayez";
        Redirect_to("gestAchat.php");
    }
}
?>