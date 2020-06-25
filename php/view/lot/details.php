
<div class="containerLot">
<div id="retour">
<?php
	echo '<a href="index/lotApprofondi/' . $retour . '/?'. $getURL.'"> <i class="material-icons">keyboard_backspace</i> <span class=" sousLignerHover absolute">Retour aux résultats </span></a>';
?>

</div>
<div class="card offset-l3 carteLot">
	<div class="relative">
	  <div class="myCarousel" id="myCarouselImage">
			<?php
				$filecount = 0;
				$files = glob("image/".htmlspecialchars($lot->getId())."/*.*");
				if ($files){
				 $filecount = count($files);
				}
				if($filecount!=0){
			  	echo "<a id=\"boutonGauche\" class=\"btn-floating btn-large waves-effect waves-light grey\"><i class=\"material-icons\">arrow_back</i></a>";
			  	echo "<a id=\"boutonDroite\" class=\"btn-floating btn-large waves-effect waves-light grey\"><i class=\"material-icons\">arrow_forward</i></a>";
				}
			?>
		  <div id="slideImage" class="slide">
		  	<?php
				if($filecount!==0){
			  	foreach(glob("image/".htmlspecialchars($lot->getId())."/*.*") as $file) {
						echo "<div class=\"flexSlide intoSlide intoSlideImage\" >";
				    echo "<img alt=\"Photo de l'annonce\" class=\"intoSlideImage\" src=\"". str_replace(' ', '%20', $file) ." \">";
						echo"</div>";
					}
			}
			else{
				echo "<div class=\"flexSlide intoSlide intoSlideImage\" >";
				echo "<img alt=\"Photo absente\" class=\"intoSlideImage\" src=\"image/noPhoto.png\">";
			}
			?>
		</div>
	  </div>
	  <div class="myCarousel" id="myCarouselBouton">
	  	<div id="slideBouton" class="slide">
	  		<?php
		  		$i=0;
		  		echo "";
			  	foreach(glob("image/".htmlspecialchars($lot->getId())."/*.*") as $file) {
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
	  </div>
	</div>
    	<?php echo '<div class="infosEssentiels "><div class="nom">' .htmlspecialchars($lot->getNom()). '</div><div class=
    	"loyer premiereCouleurText">' . htmlspecialchars($lot->getLoyer()) . '€/mois CC</div></div>' ; ?>
</div>
<div class="floatLeft">
<div id="sticky">
	<div id="anchor"></div>
<div id="contact" class="card ">
	<div class="contenuContact">
		<span class="phraseContact" >Ce bien vous intéresse ?</span>
		<span  class="lightBold phraseContact">Contactez nous !</span>
		<div class="col s6 m6 l12">
			<div class="contactButton displayFlex premiereCouleur" id="contactTelButton"><i class="material-icons">local_phone</i><span>Téléphone</span></div>
			<div class="contactContent displayNone premiereCouleurBorder" id="contactTelContent"><i class="material-icons">local_phone</i><span>
			<?php
				$telLot=$lot->getTelephone();
				if (!is_null($telLot)){
					echo $telLot;
				}
				else{
				 global $tel;
				 echo $tel;
				}
			 ?>
			 </span></div>
		</div>
		<div class="col s6 m6 l12">
			<div class="contactButton displayFlex premiereCouleur" id="contactMailButton"><i class="material-icons">email</i><span>e-mail</span></div>
			<div class="contactContent displayNone premiereCouleurBorder" id="contactMailContent"><i class="material-icons">email</i>
				<span>
					<?php
						$mailLot=$lot->getMail();
						if(!is_null($mailLot)){
							echo $mailLot;
						}
						else{
						 	global $mail;
						 	echo $mail;
						}
					 ?>
				</span>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<div id="descriptionWrapper" class="noPadding">
	<div class="decoupageSection"></div>
	<div class="descriptionWrap">
		<?php
			if(Session::is_commercial()){
				echo '<div class="paddingSmall">
						<span class="titrePartie" >Informations commerciales</span>
						<div class="description">';
				echo $lot->getInformationsCommercial();
				echo '</div>
					  <div class="decoupageSection"></div>';
			}
		?>
		<div class="paddingSmall">
		<span class="titrePartie" >Spécificités</span>
			<div class="row">	
				<?php
					echo "<div class=\" critere col s12 l6\"><div class=\"nomCritere\">Type de bien : </div><div class=\"critereLot\">". $lot->getTypeDeBien() ."</div></div>";
					echo "<div class=\" critere col s12 l6\"><div class=\"nomCritere\">Adresse : </div><div class=\"critereLot\">". $lot->getLocalisation() ."</div></div>";
					echo "<div class=\" critere col s12 l6\"><div class=\"nomCritere\">Surface : </div><div class=\"critereLot\">". $lot->getSurface() ."m²</div></div>";
					echo "<div class=\" critere col s12 l6\"><div class=\"nomCritere\">Nombre de pièces : </div><div class=\"critereLot\">". $lot->getNombreDePieces() ."</div></div>";
				?>
			</div>
		</div>
		<div class="decoupageSection"></div>
		<div class="paddingSmall">
		<span class="titrePartie" >Critères</span>
			<div class="row">
				<?php
					$ligneCategorie = true;
					foreach ($lotApprofondi->getPlus() as $categorieNom => $categorie ) {
						// on ne veut pas re-afficher le type de bien et le nombre de pièces
						if($categorieNom !=="Type(s) de bien" && $categorieNom !=="Nombre de pièce(s)"){
							if($ligneCategorie)
								echo '<div class="overflowAuto">';
							echo '<div class="paddingTop col s6">';
							echo $categorieNom;
							foreach ($categorie as $valeur) {
								echo "<li>" . $valeur . "</li>";
							}
							echo '</div>';
							if(!$ligneCategorie)
								echo "</div>";
							$ligneCategorie=!$ligneCategorie;
						}
					}
			?>
			</div>
		</div>
		<div class="decoupageSection"></div>
		<div class="paddingSmall">
		<span class="titrePartie" >Description</span>
			<div  class="description">
				<?php
					echo $lot->getDescription();
				?>
			</div>
		</div>
		<div class="decoupageSection"></div>
	</div>
</div>

<script src="js/myCarousel.js" defer></script>
<script src="js/boutonContact.js" defer></script>
<script src="js/stickyContact.js" defer></script>