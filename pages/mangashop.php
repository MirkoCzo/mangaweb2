<?php
$manga = new Manga($cnx);
$mangas = $manga->getAllManga();
$cnt = count($mangas);
$shonen = $manga->getNumberMangaById(2);
$shojo = $manga->getNumberMangaById(3);
$seinen = $manga->getNumberMangaById(4);

$cat = new Categorie($cnx);
$categories = $cat->getAllCategorie();

//Aide du projet de kevin pour le panier et de chat GPT+ ajouts personnels
if (isset($_POST['ajout_panier'])) {
    $manga_id = $_POST['manga_code'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION["panier_achat"])) {
        $_SESSION["panier_achat"] = [];
        $_SESSION["quantity_cart"] = [];
    }

    // Si l'article est déjà dans le panier, augmentez la quantité
    if (in_array($manga_id, $_SESSION["panier_achat"])) {
        $index = array_search($manga_id, $_SESSION["panier_achat"]);
        $_SESSION["quantity_cart"][$index] += $quantity;
    } else {
        // Sinon, ajoutez-le au panier
        $_SESSION["panier_achat"][] = $manga_id;
        $_SESSION["quantity_cart"][] = $quantity;
    }
}

if (isset($_POST['supprimer_du_panier'])) {
    $product_id = $_POST['manga_id'];


    if (isset($_SESSION['panier_achat'])) {
        $index = array_search($product_id, $_SESSION['panier_achat']);


        if ($index !== false) {
            unset($_SESSION['panier_achat'][$index]);
        }
    }

    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



    if (isset($_POST['confirmer_commande']))
    {
        if(!empty($_SESSION['client_id']))
        {
            $cli = new Client($cnx);
            $nom_client = $cli->getNameClientById($_SESSION['client_id']);
            $commande = new Commande($cnx);
            $id_commande = $commande->getIDforDetailCommande();
            $detail = new Detail($cnx);
            $countManga = count($_SESSION['panier_achat']);
            for ($i = 0;$i<$countManga;$i++)
            {
                $detail->addDetail($_SESSION['quantity_cart'][$i],$id_commande,$_SESSION['panier_achat'][$i]);
            }
            $total = $commande->getTotalCommande($id_commande);
            $date = date('m/d/Y', time());
            $commande->addTotalDate($id_commande,$total,$date);
            $check = $commande->addIdClientToOrder($id_commande,$_SESSION['client_id']);
            if(isset($_SESSION['panier_achat'])){
                unset($_SESSION['panier_achat']);
                unset($_SESSION['quantity_cart']);
                unset($_SESSION['id_commande']);
                unset($_SESSION["prix_total"]);
            }
            ?><script>
            var nomClient = <?php echo json_encode($nom_client['nom_client']); ?>;
            alert("Merci pour votre commande " + nomClient + "!");
        </script>
            <?php
        }
        else
        {?>
            <script>alert("Veuilez vous connecter pour effectuer une commande.");</script>
<?php
        }


    }




?>

<div class="container pt-5">
    <h1 class="pt-3 text-center">Manga-Shop</h1>
    <div class="row">
        <div class="col-md-10">
            <?php if ($shonen > 0) : ?>
                <h2 class="text-center">Shōnen</h2>
                <div class="row justify-content-center">
                    <?php for ($i = 0; $i < $cnt; $i++) : ?>
                        <?php if ($mangas[$i]->id_categorie == 2) : ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card h-100">
                                    <?php
                                    $imagePath = "./images/" . $mangas[$i]->image;
                                    $imageExists = file_exists($imagePath);
                                    $imageNameNotEmpty = !empty(trim($mangas[$i]->image));

                                    if (!$imageNameNotEmpty || !$imageExists) :
                                        ?>
                                        <img src='./images/image-non-disponible.jpg' class='card-img-top' alt='Image non disponible'>
                                    <?php else: ?>
                                        <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="...">
                                    <?php endif; ?>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title" style="color: black;"><strong><?php echo $mangas[$i]->nom_manga; ?></strong></h5>
                                        <p class="card-text" style="color: black;">Prix: <?php echo $mangas[$i]->prix; ?>€</p>
                                        <?php
                                        $description = trim($mangas[$i]->description);
                                        if (!empty($description)) {
                                            if (strlen($description) > 60) {
                                                $shortDescription = substr($description, 0, 60) . '...';
                                                echo '<p class="description-short">' . $shortDescription . '</p>';
                                                echo '<p class="description-full" style="display: none;">' . $description . '</p>';
                                            } else {
                                                echo '<p class="description-short">' . $description . '</p>';
                                            }
                                        } else {
                                            echo '<p class="no-description">Pas de description disponible.</p>';
                                        }
                                        ?>
                                        <?php if (!empty($description) && strlen($description) > 60) : ?>
                                            <div class="text-center mt-auto">
                                                <button class="btn btn-info btn-sm description-toggle" data-toggle="tooltip" data-placement="top" title="Lire la suite">Lire la suite</button>
                                            </div>
                                        <?php endif; ?>
                                        <div class="mt-auto-flex">
                                            <form class="manga_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                    <input name="manga_code" type="hidden" value="<?php echo $mangas[$i]->id_manga; ?>">
                                                    <input type="number" name="quantity"  value="1" min="1" step="1">
                                                    <button type="submit" name="ajout_panier" class="btn btn-primary">Ajouter au panier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

            <?php if ($shojo > 0) : ?>
                <h2 class="text-center">Shōjo</h2>
                <div class="row justify-content-center">
                    <?php for ($i = 0; $i < $cnt; $i++) : ?>
                        <?php if ($mangas[$i]->id_categorie == 3) : ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card h-100">
                                    <?php
                                    $imagePath = "./images/" . $mangas[$i]->image;
                                    $imageExists = file_exists($imagePath);
                                    $imageNameNotEmpty = !empty(trim($mangas[$i]->image));

                                    if (!$imageNameNotEmpty || !$imageExists) :
                                        ?>
                                        <img src='./images/image-non-disponible.jpg' class='card-img-top' alt='Image non disponible'>
                                    <?php else: ?>
                                        <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="...">
                                    <?php endif; ?>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title" style="color: black;"><strong><?php echo $mangas[$i]->nom_manga; ?></strong></h5>
                                        <p class="card-text" style="color: black;">Prix: <?php echo $mangas[$i]->prix; ?>€</p>
                                        <?php
                                        $description = trim($mangas[$i]->description);
                                        if (!empty($description)) {
                                            if (strlen($description) > 60) {
                                                $shortDescription = substr($description, 0, 60) . '...';
                                                echo '<p class="description-short">' . $shortDescription . '</p>';
                                                echo '<p class="description-full" style="display: none;">' . $description . '</p>';
                                            } else {
                                                echo '<p class="description-short">' . $description . '</p>';
                                            }
                                        } else {
                                            echo '<p class="no-description">Pas de description disponible.</p>';
                                        }
                                        ?>
                                        <?php if (!empty($description) && strlen($description) > 60) : ?>
                                            <div class="text-center mt-auto">
                                                <button class="btn btn-info btn-sm description-toggle" data-toggle="tooltip" data-placement="top" title="Lire la suite">Lire la suite</button>
                                            </div>
                                        <?php endif; ?>
                                        <div class="mt-auto-flex">
                                            <form class="manga_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                <input name="manga_code" type="hidden" value="<?php echo $mangas[$i]->id_manga; ?>">
                                                <input type="number" name="quantity"  value="1" min="1" step="1">
                                                <button type="submit" name="ajout_panier" class="btn btn-primary">Ajouter au panier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

            <?php if ($seinen > 0) : ?>
                <h2 class="text-center">Seinen</h2>
                <div class="row justify-content-center">
                    <?php for ($i = 0; $i < $cnt; $i++) : ?>
                        <?php if ($mangas[$i]->id_categorie == 4) : ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card h-100">
                                    <?php
                                    $imagePath = "./images/" . $mangas[$i]->image;
                                    $imageExists = file_exists($imagePath);
                                    $imageNameNotEmpty = !empty(trim($mangas[$i]->image));

                                    if (!$imageNameNotEmpty || !$imageExists) :
                                        ?>
                                        <img src='./images/image-non-disponible.jpg' class='card-img-top' alt='Image non disponible'>
                                    <?php else: ?>
                                        <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="...">
                                    <?php endif; ?>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title" style="color: black;"><strong><?php echo $mangas[$i]->nom_manga; ?></strong></h5>
                                        <p class="card-text" style="color: black;">Prix: <?php echo $mangas[$i]->prix; ?>€</p>
                                        <?php
                                        $description = trim($mangas[$i]->description);
                                        if (!empty($description)) {
                                            if (strlen($description) > 60) {
                                                $shortDescription = substr($description, 0, 60) . '...';
                                                echo '<p class="description-short">' . $shortDescription . '</p>';
                                                echo '<p class="description-full" style="display: none;">' . $description . '</p>';
                                            } else {
                                                echo '<p class="description-short">' . $description . '</p>';
                                            }
                                        } else {
                                            echo '<p class="no-description">Pas de description disponible.</p>';
                                        }
                                        ?>
                                        <?php if (!empty($description) && strlen($description) > 60) : ?>
                                            <div class="text-center mt-auto">
                                                <button class="btn btn-info btn-sm description-toggle" data-toggle="tooltip" data-placement="top" title="Lire la suite">Lire la suite</button>
                                            </div>
                                        <?php endif; ?>
                                        <div class="mt-auto-flex">
                                            <form class="manga_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                    <input name="manga_code" type="hidden" value="<?php echo $mangas[$i]->id_manga; ?>">
                                                    <input type="number" name="quantity"  value="1" min="1" step="1">
                                                    <button type="submit" name="ajout_panier" class="btn btn-primary">Ajouter au panier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-2">
            <div class="panier">
                <h3>Panier d'achat</h3>
                <?php if(!empty($_SESSION["panier_achat"]))
                    {
                        $_SESSION['prix_total'] = 0;
                        $total_panier = count($_SESSION["panier_achat"]);
                        echo '<p id=totalPanier>' . $total_panier . 'Produit(s)</p>';
                        $mang = new Manga($cnx);
                        $cpt=0;
                        foreach ($_SESSION["panier_achat"] as $manga_id)
                            {
                                $man = $mang->getMangaByID($manga_id);
                                $quantite = $_SESSION["quantity_cart"][$cpt];
                                $cpt++;
                                $total_manga = $man['prix'] * $quantite;
                                $_SESSION['prix_total'] += $total_manga;?>
                                <div class="card mb-1 text-center">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $man['nom_manga'];?></h5>
                                        <p class="card-text">Prix: <?php echo $man['prix'];?>€</p>
                                        <p>Quantité : <?php print $quantite;?></p>
                                        <p>Sous-total: <?php print $total_manga;?></p>
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                            <input type="hidden" name="manga_id" value="<?php echo $man['id_manga'];?>">
                                            <button type="submit" class="btn btn-primary btn-sm" name="supprimer_du_panier">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                                <?php

                                ?>
                                <?php
                            }
                        if(isset($_SESSION['prix_total']))
                        {
                            print 'Prix total : '.$_SESSION['prix_total'].' €';
                        }
                    } else
                        {
                            echo '<p>Votre panier est vide.</p>';
                        }
                        ?>
            </div>
            <div class="text-center">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <?php
                    if (!empty($_SESSION["panier_achat"]))
                    {
                        print'<p>Confirmer la commande : </p>
                        <button type="submit" class="btn btn-primary btn-sm m-2" name="confirmer_commande">confirmer</button>
                        ';
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>



<style>

    .description-full {
        display: none;
    }

    .description-toggle:hover + .description-full,
    .description-toggle:focus + .description-full {
        display: block;
    }
    .card-body {
        display: flex;
        flex-direction: column;
    }

    .mt-auto-flex {
        margin-top: auto;
        margin-bottom: -10px;
    }



</style>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('.description-toggle').click(function () {
            $(this).parent().siblings('.description-full').toggle();
            $(this).parent().siblings('.description-short').toggle();
        });
    });

</script>
