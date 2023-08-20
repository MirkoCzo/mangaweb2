<?php

if(isset($_POST['submit_user'])){
    extract($_POST, EXTR_OVERWRITE);
    if(!empty($mail) || !empty($mdp) || !empty($nom) || !empty($ville) || !empty($pays)){
        $client = new Client($cnx);
        $Ville = new Ville($cnx);
        $idville = $Ville->getVilleID($ville);
    }
}
?>
<div class="container pt-5">
    <form action="?page=createAccountUser.php" method="POST" class="pt-5 row g-3 justify-content-center form-group" id="FormInscription">
        <div class="col-md-6">
            <label for="nom" class="form-label">Pseudonyme :</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Pseudo...">
        </div>
        <div class="col-md-6">
            <label for="mdp" class="form-label">Mot de passe :</label>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe...">
        </div>
        <div class="col-md-6">
            <label for="mail" class="form-label">Email :</label>
            <input type="email" class="form-control" id="mail" name="mail" placeholder="Name@example.com">
        </div>
        <div class="col-md-6">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="ville" class="form-label">Ville :</label>
                    <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville...">
                </div>
                <div class="col-md-6">
                    <label for="pays" class="form-label">Pays :</label>
                    <input type="text" class="form-control" id="pays" name="pays" placeholder="Pays...">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-dark">Effacer les saisies</button>
            <button type="submit" class="btn btn-dark ml-auto" name="submit_user" id="submit_user" >Inscription</button>
        </div>
    </form>
</div>
<style>
    .btn {
        transition: transform 0.3s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.5);
    }
</style>
