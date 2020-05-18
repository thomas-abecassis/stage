<?php
file_put_contents('../../css/couleur.css', ':root{
  --mainColor:'.$_GET['mainColor'].';
  --secondColor:'.$_GET['secondColor'].';
}');
?>