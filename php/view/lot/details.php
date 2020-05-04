
<div class="card col s4 m5 l6 offset-l3 carteLot">
	<div class="relative">    		
	  <div class="myCarousel" id="myCarouselImage">
		  <a id="boutonGauche" class="btn-floating btn-large waves-effect waves-light grey"><i class="material-icons">arrow_back</i></a>
		  <a id="boutonDroite" class="btn-floating btn-large waves-effect waves-light grey"><i class="material-icons">arrow_forward</i></a>
		  <div id="slideImage" class="slide">
		  	<?php
		  	foreach(glob("../image/".htmlspecialchars($lot->getId())."/*.*") as $file) {
			    echo "<img class=\"intoSlide intoSlideImage\" src=". $file ." \">";
			}
			?>
		</div>
	  </div>
	  <div class="myCarousel" id="myCarouselBouton">
	  	<div id="slideBouton" class="slide">
	  		<?php 
	  		$i=0;
	  		echo "";
		  	foreach(glob("../image/".htmlspecialchars($lot->getId())."/*.*") as $file) {
		  		if($i%3 ==0){
		  			if($i!=0){
		  				echo "</div>";
		  			}
	  				echo "<div class=\"intoSlide intoSlideBouton row \">";
	  				echo "<div class=\"boutonSlider col s2 offset-s2\"> <div class=\"selectionne ImageBoutonSlide\" style=\"  background-image:url('".$file."');\"></div> ";
		  		}else{
		  			echo "<div class=\"boutonSlider col s2 offset-s1\" > <div class=\"ImageBoutonSlide\" style=\"  background-image:url('".$file."');\"></div> </div>";
		  		}

			    if($i%3 ==0){
	  				echo "</div>";
		  		}
		  		$i++;
			}
			?>
			</div></div>
	  		<!---<div id="slideBouton" class="slide">
	  		<div class="intoSlide intoSlideBouton row ">
		    	<div class="boutonSlider col s2 offset-s2"> <div class="selectionne ImageBoutonSlide"></div> </div>
		    	<div class="boutonSlider col s2 offset-s1" > <div class="ImageBoutonSlide"></div> </div>
		    	<div class="boutonSlider col s2 offset-s1" > <div class="ImageBoutonSlide"></div> </div>
	    	</div>
	    	<div class="intoSlide  intoSlideBouton row">
		    	<div class="boutonSlider col s2 offset-s2" > <div class="ImageBoutonSlide"></div> </div>
		    	<div class="boutonSlider col s2 offset-s1" > <div class="ImageBoutonSlide"></div>  </div>
		    	<div class="boutonSlider col s2 offset-s1" > <div class="ImageBoutonSlide"></div> </div>
	    	</div>
	    	<div class="intoSlide  intoSlideBouton row">
		    	<div class="boutonSlider col s2 offset-s2" > <div class="ImageBoutonSlide"></div> </div>
		    	<div class="boutonSlider col s2 offset-s1" > <div class="ImageBoutonSlide"></div> </div>
	    	</div></div> -->
	  </div>
	</div>
    	<?php echo "<div class=\"infosEssentiels\"><div class=\"nom\">".htmlspecialchars($lot->getNom())."</div><div class=
    	\"loyer\">". htmlspecialchars($lot->getLoyer())."€/mois </div></div>" ; ?>
</div>

<div class="col s6 offset-s3">

<ul class="liste">	
<?php 
	echo "<li>". $lot->getTypeDeBien() ."</li>";
	echo "<li>". $lot->getLocalisation() ."</li>";
	echo "<li>". $lot->getSurface() ."</li>";
	echo "<li>". $lot->getNombrePiece() ."</li>";
?>
</ul>

<span id="titreDescription" >Description</span>

	<ul class="liste">	
<?php 
	foreach ($lotApprofondi->getCommodites() as $value ) {
		echo "<li>" . $value . "</li>";
	}
	foreach ($lotApprofondi->getOptions() as $value ) {
		echo "<li>" . $value . "</li>";
	}
?>
</ul>

<?php 
echo $lot->getDescription();
?>

</div>


<script type="text/javascript" src="../js/myCarousel.js"></script>

<?php 

?>

