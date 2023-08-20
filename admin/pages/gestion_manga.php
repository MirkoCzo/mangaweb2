<?php
$mg = new Manga($cnx);
$manga = $mg->getAllManga();
if($manga==null)
{
    $nbrmanga = 0; //gere le cas ou 0 manga dans la BD

}
else
{
    $nbrmanga = count($manga);
}

$cat = new Categorie($cnx);
$categories = $cat->getAllCategorie();

?>

<div class="container pt-2">
    <h1>Gestion des manga</h1>

    <div class="container pt-2">
        <?php
        if ($nbrmanga > 0) {
            ?>
            <table class="table .table-striped table-dark p-0" id="tableau">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Categorie</th>
                    <th scope="col">Image</th>
                    <th scope="col">Ajout</th>
                    <th scope="col">Supprimer</th>
                </tr>
                </thead>
                <tbody class="text-secondary" id="table-body">
                <form action="<?php $_SERVER['PHP_SELF']; ?>">
                    <?php
                    for($i=0;$i<$nbrmanga;$i++)
                    {?>

                        <tr>
                            <td contenteditable="true" name="nom_manga" id="<?php echo $manga[$i]->id_manga; ?>">
                                <?php echo $manga[$i]->nom_manga; ?>
                            </td>
                            <td contenteditable="true" name="description" id="<?php echo $manga[$i]->id_manga; ?>">
                                <?php echo $manga[$i]->description; ?>
                            </td>
                            <td contenteditable="true" name="prix" id="<?php echo $manga[$i]->id_manga; ?>">
                                <?php echo $manga[$i]->prix; ?>€
                            </td>
                            <td name="id_categorie">
                                <select id="<?php echo $manga[$i]->id_manga; ?>">
                                    <?php
                                    foreach ($categories as $cat) {
                                        echo '<option value="' . $cat->id_categorie . '"';
                                        if ($cat->id_categorie == $manga[$i]->id_categorie) {
                                            echo ' selected';
                                        }
                                        echo '>' . $cat->nom_categorie . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td contenteditable="true" name="image" id="<?php echo $manga[$i]->id_manga; ?>"><?php echo $manga[$i]->image;?></td>
                            <td></td>
                            <td><button class="delete" data-id="<?php echo $manga[$i]->id_manga; ?>">X</button></td>
                        </tr>
                        <?php
                    }

                    ?>

                </form>
                </tbody>
            </table>
            <button id="ajouterLigne">Ajouter une ligne</button>
            <script>
                $(document).ready(function () {
                    // Créer les options pour le menu déroulant de catégorie
                    var options = '';
                    <?php foreach ($categories as $cat) { ?>
                    options += '<option value="<?php echo $cat->id_categorie; ?>"><?php echo $cat->nom_categorie; ?></option>';
                    <?php } ?>

                    // Fonction pour ajouter une nouvelle ligne au tableau
                    function ajouterNouvelleLigne() {
                        var tbody = $("#table-body");

                        var nouvelleLigne = $("<tr></tr>");
                        nouvelleLigne.append('<td contenteditable="true" name="nom_manga" id="new_nom_manga"></td>');
                        nouvelleLigne.append('<td contenteditable="true" name="description" id="new_desc_manga"></td>');
                        nouvelleLigne.append('<td contenteditable="true" name="prix" id="new_prix_manga"></td>');
                        nouvelleLigne.append('<td contenteditable="true" name="categorie" id="new_categorie_manga"><select>' + options + '</select></td>');
                        nouvelleLigne.append('<td contenteditable="true" name="image" id="new_image_manga"></td>')
                        nouvelleLigne.append('<td><button class="ajouterManga">Ajouter manga</button></td>');
                        nouvelleLigne.append('<td></td>');


                        tbody.append(nouvelleLigne);
                    }

                    // Associer l'événement de clic au bouton "Ajouter"
                    $("#ajouterLigne").click(function () {
                        ajouterNouvelleLigne();
                    });



                //Jquery+ajax
                    $(document).on('click', '.ajouterManga', function (event) {
                        if (confirm('Ajouter?')) {
                            let nom_manga = $('#new_nom_manga').text();
                            let description = $('#new_desc_manga').text();
                            let prix = $('#new_prix_manga').text();
                            let categorie = $('#new_categorie_manga select').val();
                            let image = $('#new_image_manga').text();
                            let parametre = "nom_manga=" + nom_manga + "&description=" + description + "&prix=" + prix + "&id_categorie=" + categorie +"&image=" +image;
                            console.log(parametre);
                            console.log('babaou');
                            $.ajax({
                                type: 'POST',
                                data: parametre,
                                dataType: 'json',
                                url: './lib/php/ajax/ajaxAjouterManga.php',
                                success: function (data) {
                                    console.log('Ajouté');
                                    $('#new_nom_manga').text('');
                                    $('#new_desc_manga').text('');
                                    $('#new_prix_manga').text('');
                                    $('#new_categorie_manga select').val('');
                                    $('#new_image_manga').text('');
                                    location.reload();

                                },
                                error: function (xhr, status, error) {
                                    console.log('Erreur lors de l\'ajout du manga:', error);
                                    alert('manga non ajouté');
                                }
                            });
                        }
                    });
                });
            </script>
            <?php
        } elseif($nbrmanga==0){
            echo '<p>Aucun manga disponible.</p>';
        }
        ?>

    </div>
</div>
