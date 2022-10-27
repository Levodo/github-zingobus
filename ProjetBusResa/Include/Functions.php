<?php require_once("DB.php"); ?>
<?php require_once("Sessions.php"); ?>
<?php 
    function Redirect_to($NewLocation) {
        header("Location:".$NewLocation);
        exit;
    }

    function AdminLogin_Attempt($Username,$Password) {
        global $Connection;
        $Query="SELECT * FROM admin WHERE nom='$Username' and motpasse='$Password'";
        $Execute=mysqli_query($Connection,$Query);
        if($admin=mysqli_fetch_assoc($Execute)){
            return $admin;
        }else{
            return null;
        }
    }
    function ClientLogin_Attempt($Username,$Password) {
        global $Connection;
        $Query="SELECT * FROM client WHERE nomUser='$Username' and motpasse='$Password'";
        $Execute=mysqli_query($Connection,$Query);
        if($client=mysqli_fetch_assoc($Execute)){
            return $client;
        }else{
            return null;
        }
    }

    function AdminLogin() {
        if(isset($_SESSION["User_Id"])){
        global $Connection;
        $adminId= $_SESSION["User_Id"];
        $Query = "SELECT * FROM admin WHERE id='$adminId'";
        $Execute = mysqli_query($Connection, $Query);
        if (mysqli_fetch_assoc($Execute)) {
            return true;
        }
        }
    }
    function ClientLogin() {
        if(isset($_SESSION["User_Id"])){
        global $Connection;
        $clientId= $_SESSION["User_Id"];
        $Query = "SELECT * FROM client WHERE id='$clientId'";
        $Execute = mysqli_query($Connection, $Query);
        if (mysqli_fetch_assoc($Execute)) {
            return true;
        }
        }
    }
    function AdminPSession() {
        if(isset($_SESSION["User_Id"])){
        global $Connection;
        $AdminPId= $_SESSION["User_Id"];
        $Query = "SELECT * FROM admin WHERE id='$AdminPId'";
        $Execute = mysqli_query($Connection, $Query);
        while ($DataRows = mysqli_fetch_array($Execute)) {
            $AdminRole = $DataRows["role"];;
        if ($AdminRole = "adminPrincipal") {
            return true;
        }
        }
    }
}

    function AdminLogin_Confirm() {
        if(!AdminLogin()){
            $_SESSION["ErrorMessage"]="Connexion Requise";
            Redirect_to("connexionAdmin.php");
        }
    }
    function ClientLogin_Confirm() {
        if(!ClientLogin()){
            $_SESSION["ErrorMessage"]="Connexion";
            Redirect_to("connexion.php");
        }
    }
    function AdminPSession_Confirm() {
        if(!AdminPSession()){
            $_SESSION["ErrorMessage"]="Vous n'êtes pas autorisé à ouvrir cette page";
            Redirect_to("gestAchat.php");
        }
    }

?>