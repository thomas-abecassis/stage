
    		
  <div class="myCarousel">
    <a  href="#one!"><img src="../image/1/1.jpg"></a>
  </div>
        



<script type="text/javascript">
$('.carousel.carousel-slider').carousel({
    fullWidth: true,
    indicators: true
  });
</script>

<?php
  	echo htmlspecialchars($v->getId())."<br>".htmlspecialchars($v->getNom()) ."<br>" . htmlspecialchars($v->getLoyer()) . "€ <br> <br>";

  	echo '<a href=index.php?action=delete&id='.htmlspecialchars($v->getId()).'>supprimer le produit</a> <br>';

  	echo '<a href=index.php?action=update&id='.htmlspecialchars($v->getId()).'>mettre à jour le produit </a> <br>';

  	echo "<a href=index.php?action=panier&id=".htmlspecialchars($v->getId())."> ajouter panier </a> <br>";
?>

