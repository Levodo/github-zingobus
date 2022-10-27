<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php AdminLogin_Confirm();?>

<?php
if (isset($_GET["Delete"])) {
    $ReservId = $_GET["Delete"];
    global $Connection;
    $Query = "DELETE FROM reservation  WHERE id='$ReservId'";
    $Execute = mysqli_query($Connection, $Query);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Réservation supprimée avec succès";
        Redirect_to("gestReserv.php");
    } else {
        $_SESSION["ErrorMessage"] = "Erreur de suppression, réessayez";
        Redirect_to("gestReserv.php");
    }
}
?>