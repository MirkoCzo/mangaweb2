<?php
header('Content-type: application/json');

require '../pgConnect.php';
require '../class/Connexion.class.php';
require '../class/Hydrate.class.php';
require '../class/Manga.class.php';

$cnx = Connexion::getInstance($dsn, $user, $pass);

if (isset($_POST['id_manga'])) {
    $mg = new Manga($cnx);
    $result = $mg->deleteManga($_POST['id_manga']);

    if ($result) {
        $response = array('status' => 'success');
    } else {
        $response = array('status' => 'error');
    }

    echo json_encode($response);
}
?>
