<?php
header('Content-type: application/json');

require '../pgConnect.php';
require '../class/Connexion.class.php';
require '../class/Hydrate.class.php';
require '../class/Manga.class.php';

$cnx = Connexion::getInstance($dsn,$user,$pass);

$manga = new Manga($cnx);
$mangas[] = $manga->updateManga($_POST['champ'],$_POST['valeur'],$_POST['id_manga']);

print json_encode($mangas);