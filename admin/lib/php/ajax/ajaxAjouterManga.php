<?php
header ('Content-Type: application/json');

require '../pgConnect.php';
require '../class/Connexion.class.php';
require '../class/Hydrate.class.php';
require '../class/Manga.class.php';
$cnx = Connexion::getInstance($dsn,$user,$pass);

$manga = new Manga($cnx);
$mangas = $manga->addManga($_POST['nom_manga'],$_POST['description'],$_POST['prix'],$_POST['id_categorie'],$_POST['image']);
print json_encode($mangas);
