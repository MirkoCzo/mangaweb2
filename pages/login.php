<?php
if(isset($_POST['submit_login'])){
    $admin = new AdminDB($cnx); //index
    $adm = $admin->isAdmin($_POST['login'],$_POST['password']);
    if($adm == 1){
        $_SESSION['admin'] = 1;
        unset($_SESSION['page']);
        print '<meta http-equiv="refresh": content="0;url=./admin/index.php">';
    }else {
        $client = new Client($cnx);
        $cli = $client->isClient($_POST['login'],$_POST['password']);

        if($cli){
            $mail_client = $_POST['login'];
            $_SESSION['client'] = $mail_client;
            $_SESSION['client_id'] = $client->getClientByMail($mail_client)['id_client'];
            unset($_SESSION['page']);
            print '<meta http-equiv="refresh": content="0;url=./index.php">';
        }else{
            print '<br><br><br>';
            print "Vous n'êtes pas enregistré, veuillez vous inscrire";
        }
        print '<br><br>';
        print "Accès réservé";
    }

}
?>

<div class="container pt-5">

    <form action="<?php print $_SERVER['PHP_SELF'];?>" method="post">
        <div class="pt-3 form-group col-md-6">
            <h1 class="pt-2">Formulaire de connexion</h1>
        <label for="login" class="form-label" >Email :</label>
        <input type="text" class="form-control" id="login" name="login" placeholder="Email...">

        <label for="password" class="form-label">Mot de passe : </label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe...">

            <div class="pt-4 d-flex justify-content-between">
                <button type="submit" name="submit_login" id="submit_login" class="btn btn-dark">Envoyer</button>
                <a  href="index.php?page=createAccount.php" class="align-self-right text-right btn btn-dark" role="button" alt="Créer un compte">Pas encore inscrit?</a>
            </div>
            <div class="pt-3 form-group col-md-6">

            </div>
        </div>


        
    </form>
</div>

