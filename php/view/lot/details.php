<div class="card col offset-l3 carteLot">
	<div class="relative">
	  <div class="myCarousel" id="myCarouselImage">
		  <a id="boutonGauche" class="btn-floating btn-large waves-effect waves-light grey"><i class="material-icons">arrow_back</i></a>
		  <a id="boutonDroite" class="btn-floating btn-large waves-effect waves-light grey"><i class="material-icons">arrow_forward</i></a>
		  <div id="slideImage" class="slide">
		  	<?php
		  	foreach(glob("../image/".htmlspecialchars($lot->getId())."/*.*") as $file) {
					echo "<div class=\"flexSlide intoSlide intoSlideImage\" >";
			    echo "<img class=\"intoSlideImage\" src=". $file ." \">";
					echo"</div>";
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
	  				echo "<div class=\"flexSlide intoSlide intoSlideBouton row \">";
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

<div class="col offset-l3 noPadding">
	<div class="decoupageSection"></div>
	<div class="descriptionWrap">
		<span class="titrePartie" >Critères</span>
		<div class="row">
		<?php
			echo "<div class=\" critere col s6\"><div class=\"nomCritere\">Type de bien : </div><div class=\"critereLot\">". $lot->getTypeDeBien() ."</div></div>";
			echo "<div class=\" critere col s6\"><div class=\"nomCritere\">Adresse : </div><div class=\"critereLot\">". $lot->getLocalisation() ."</div></div>";
			echo "<div class=\" critere col s6\"><div class=\"nomCritere\">Surface : </div><div class=\"critereLot\">". $lot->getSurface() ."m²</div></div>";
			echo "<div class=\" critere col s6\"><div class=\"nomCritere\">Nombre de pièces : </div><div class=\"critereLot\">". $lot->getNombrePiece() ."</div></div>";
		?>
	</div>
		<div class="decoupageSection"></div>
		<span class="titrePartie" >Les plus</span>
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
		<div class="decoupageSection"></div>
		<span class="titrePartie" >Description</span>
		<div id="description">
		<?php
			echo $lot->getDescription();
		?>
		</div>
		<div class="decoupageSection"></div>
	</div>
</div>

<script type="text/javascript" src="../js/myCarousel.js"></script>

<?php

?>
