$(document).ready(function () {

    // Effacer manga
    $('.delete').click(function () {
        let id_manga = $(this).data('id');
        console.log('id : ' + id_manga);
        if (confirm('Supprimer ?')) {
            let ligne = $(this).closest("tr");
            let parametre = 'id_manga=' + id_manga;
            $.ajax({
                type: 'POST',
                data: parametre,
                dataType: 'json',
                url: './lib/php/ajax/ajaxDeleteManga.php',
                success: function (data) {
                    console.log('success');
                    ligne.remove();
                    location.reload();
                }
            });
        }
    });



    $('td[id], select[id]').on('focusout change', function() {
        let valeurInitiale = $(this).data('initialValue');
        let valeurActuelle;
        let id_manga;
        let name;

        if ($(this).is('select')) {
            valeurActuelle = $(this).val();
            id_manga = $(this).attr('id');
            name = $(this).parent().attr('name');
        } else {
            valeurActuelle = $(this).text().trim();
            id_manga = $(this).attr('id');
            name = $(this).attr('name');
        }

        if (valeurInitiale !== valeurActuelle) {
            let parametre = 'champ=' + name + '&valeur=' + valeurActuelle + '&id_manga=' + id_manga;
            $.ajax({
                type: 'POST',
                data: parametre,
                dataType: 'json',
                url: './lib/php/ajax/ajaxUpdateManga.php',
                success: function(data) {
                    console.log('success');
                }
            });
        }

        $(this).data('initialValue', valeurActuelle);
    });

    $('td[id], select[id]').each(function() {
        if ($(this).is('select')) {
            $(this).data('initialValue', $(this).val());
        } else {
            $(this).data('initialValue', $(this).text().trim());
        }
    });







});

