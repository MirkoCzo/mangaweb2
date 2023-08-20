<?php
session_start();
include 'admin/lib/php/admin_liste_include.php';
if(isset($_SESSION['client_id'])) {
    var_dump($_SESSION['client_id']);
}
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./lib/css/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .content {
            flex: 1;
        }
    </style>

    <title>Manga Shop</title>


</head>
<body>
<div class="content">

    <header id="header">

    </header>
    <nav>
        <?php
        if(file_exists('./lib/php/menu.php'))
        {
            include('./lib/php/menu.php');
        }
        ?>

    </nav>

    <section id="mains">

        <?php
        if(!isset($_SESSION['page'])){
            $_SESSION['page']="accueil.php";
        }
        if(isset($_GET['page'])){
            $_SESSION['page'] = $_GET['page'];
        }
        $path='./pages/'.$_SESSION['page'];
        if(file_exists($path)){
            include ($path);
        }else{
            include ('./pages/page404.php');
        }
        ?>
    </section>
</div>
    <footer
            class="text-center text-lg-start"
            style="background-color: #555555"
    >
        <div class="container py-3">

        <div class="container p-4 pb-0">

                <div class="row">

                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">
                            Manga-Shop
                        </h6>
                        <p>
                            Site de vente en ligne de manga.
                        </p>
                    </div>


                    <hr class="w-100 clearfix d-md-none" />


                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Produits</h6>
                        <p>
                            <a>Manga</a>
                        </p>
                        <p>
                            <a>Goodies</a>
                        </p>
                        <p>
                            <a>Stickers</a>
                        </p>
                        <p>
                            <a>Posters</a>
                        </p>
                    </div>


                    <hr class="w-100 clearfix d-md-none" />


                    <hr class="w-100 clearfix d-md-none" />


                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
                        <p><i class="fas fa-home mr-3"></i> Avenue du champ de mars</p>
                        <p><i class="fas fa-envelope mr-3"></i> Manga-Shop@gmail.com</p>
                        <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
                    </div>

                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Suivez-moi</h6>


                        <a
                                class="btn btn-primary btn-floating m-1"
                                style="background-color: #333333"
                                target="_blank"
                                href="https://github.com/MirkoCzo"
                                role="button"
                        ><i class="fab fa-github"></i></a>
                    </div>
                </div>
        </div>

        </div>

        <div
                class="text-center p-3"
                style="background-color: rgba(0, 0, 0, 0.2)"
        >
            © 2023 Copyright:
            <a href="index.php?page=accueil.php"
            >Manga-Shop.com</a
            >
        </div>
        <!-- Copyright -->
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>

</html>
