<?php
if(!isset($_SESSION['admin'])){
    print "<br>Accès réservé";
    print '<meta http-equiv="refresh": content="3;url=../index.php">';
}
