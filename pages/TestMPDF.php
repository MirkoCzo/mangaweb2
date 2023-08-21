<?php

require_once  './vendor/autoload.php';
require './admin/lib/php/class/Manga.class.php';

$cnx = Connexion::getInstance($dsn,$user,$pass);

$manga = new Manga($cnx);

$mangas = $manga->getAllManga();

$shonen = $manga->getNumberMangaById(2);
$shojo = $manga->getNumberMangaById(3);
$seinen = $manga->getNumberMangaById(4);

$nbr = count($mangas);

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('<h1>Nos Mangas</h1>');
if ($shonen>0)
{
    $mpdf->WriteHTML('<h2>Shonen :</h2>');
    for ($i = 0; $i < $nbr; $i++)
    {
        if ($mangas[$i]->id_categorie ==2)
        {
            $description = trim($mangas[$i]->description);
            $mpdf->WriteHTML('Manga : '.$mangas[$i]->nom_manga);
            $mpdf->WriteHTML('<br>');
            if (strlen($description)>0)
            {
                $mpdf->WriteHTML('Resumé : '.$mangas[$i]->description);
            }
            else
            {
                $mpdf->WriteHTML('Resumé : Pas de résumé disponible.');
            }
            $mpdf->WriteHTML('<br>');
            $mpdf->WriteHTML('Prix : '.$mangas[$i]->prix. ' €');
            $imagePath = "./images/" . $mangas[$i]->image;
            if (!file_exists($imagePath) || empty(trim($mangas[$i]->image))) {
                $mpdf->WriteHTML('<img src="./images/image-non-disponible.jpg" width="100px">');
            } else {
                $mpdf->WriteHTML('<img src="' . $imagePath . ' "width="100px">');
            }
            $mpdf->WriteHTML('--------------------------------------------------------------------------------------------------------------------------------------------------------');

        }

    }
}
else
{
    $mpdf->WriteHTML('<h2>Plus de shonen disponible :</h2>');
}
if ($shojo>0)
{
    $mpdf->WriteHTML('<h2>Shojo :</h2>');
    for ($i = 0; $i < $nbr; $i++)
    {
        if ($mangas[$i]->id_categorie ==3)
        {
            $description = trim($mangas[$i]->description);
            $mpdf->WriteHTML('Manga : '.$mangas[$i]->nom_manga);
            $mpdf->WriteHTML('<br>');
            if (strlen($description)>0)
            {
                $mpdf->WriteHTML('Resumé : '.$mangas[$i]->description);
            }
            else
            {
                $mpdf->WriteHTML('Resumé : Pas de résumé disponible.');
            }
            $mpdf->WriteHTML('<br>');
            $mpdf->WriteHTML('Prix : '.$mangas[$i]->prix. ' €');
            $imagePath = "./images/" . $mangas[$i]->image;
            if (!file_exists($imagePath) || empty(trim($mangas[$i]->image))) {
                $mpdf->WriteHTML('<img src="./images/image-non-disponible.jpg" width="100px">');
            } else {
                $mpdf->WriteHTML('<img src="' . $imagePath . ' "width="100px">');
            }
            $mpdf->WriteHTML('--------------------------------------------------------------------------------------------------------------------------------------------------------');

        }

    }
}
else
{
    $mpdf->WriteHTML('<h2>Plus de shojo disponible :</h2>');
}
if ($seinen>0)
{
    $mpdf->WriteHTML('<h2>Seinen :</h2>');
    for ($i = 0; $i < $nbr; $i++)
    {
        if ($mangas[$i]->id_categorie ==4)
        {
            $description = trim($mangas[$i]->description);
            $mpdf->WriteHTML('Manga : '.$mangas[$i]->nom_manga);
            $mpdf->WriteHTML('<br>');
            if (strlen($description)>0)
            {
                $mpdf->WriteHTML('Resumé : '.$mangas[$i]->description);
            }
            else
            {
                $mpdf->WriteHTML('Resumé : Pas de résumé disponible.');
            }
            $mpdf->WriteHTML('<br>');
            $mpdf->WriteHTML('Prix : '.$mangas[$i]->prix. ' €');
            $imagePath = "./images/" . $mangas[$i]->image;
            if (!file_exists($imagePath) || empty(trim($mangas[$i]->image))) {
                $mpdf->WriteHTML('<img src="./images/image-non-disponible.jpg" width="100px">');
            } else {
                $mpdf->WriteHTML('<img src="' . $imagePath . ' "width="100px">');
            }
            $mpdf->WriteHTML('--------------------------------------------------------------------------------------------------------------------------------------------------------');

        }

    }
}
else
{
    $mpdf->WriteHTML('<h2>Plus de seinen disponible :</h2>');
}

$mpdf->SetXY(20,30);

$mpdf->Output();
