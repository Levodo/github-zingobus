<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php AdminLogin_Confirm();?>

<?php 
    if(isset($_GET["Delete"])){
    $AgenceId=$_GET["Delete"];
    global $Connection;
    $Query="DELETE FROM agence  WHERE id='$AgenceId'";
    $Execute=mysqli_query($Connection,$Query);
    if($Execute){
        $_SESSION["SuccessMessage"]="Agence supprimée avec succès";
        Redirect_to("agences.php");
    }else{
        $_SESSION["ErrorMessage"]="Ereur de suppression, réessayez";
        Redirect_to("agences.php");
    }
    }
?>