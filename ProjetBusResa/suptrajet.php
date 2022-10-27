<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php AdminLogin_Confirm();?>

<?php 
    if(isset($_GET["Delete"])){
    $TrajetId=$_GET["Delete"];
    global $Connection;
    $Query="DELETE FROM trajet  WHERE id='$TrajetId'";
    $Execute=mysqli_query($Connection,$Query);
    if($Execute){
        $_SESSION["SuccessMessage"]="Trajet supprimé avec succès";
        Redirect_to("trajet.php");
    }else{
        $_SESSION["ErrorMessage"]="Erreur de suppression, réessayez";
        Redirect_to("trajet.php");
    }
    }
?>