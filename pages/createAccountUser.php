<?php

extract($_POST, EXTR_OVERWRITE);

$flag = false;

if (!empty($mail) && !empty($mdp) && !empty($nom) && !empty($ville) && !empty($pays)) {
    $Ville = new Ville($cnx);
    $idville = $Ville->getVilleID($ville);

    if ($idville == null) {
        $Ville->addVille($ville, $pays);
        $idville = $Ville->getVilleID($ville);
    }

    $flag = true;
} else {
    echo "<script>alert('Veuillez remplir tous les champs !'); window.location.href='index.php?page=createAccount.php';</script>";
}

if ($flag) {
    $client = new Client($cnx);
    $toRegister = $client->addClient($nom, $mdp, $mail, $idville);

    if ($toRegister !== false) {
        echo "<script>alert('Inscription réussie !'); window.location.href='index.php?page=accueil.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'ajout du client.');</script>";
    }
}
