<div class="col s12 m8 offset-m2">
	<div class="card searchBoxApprofondie" id="searchBox" >
      <form method="post" action="index.php?controller=produit&action=searchedDeepen">
	       		<div class="categorie row">
		       		<div class="titreCategorie">Localisation
		       			<div class="col s12 ligne"></div></div>
		          		<div class=" input-field col s3 grey lighten-4"><label for="immat_id"></label><input class="searchBarInput" placeholder="où ?" type="text"  name="localisation"/>
		        	</div>
		    	</div>
		    	<div class="categorie row">
		       		<div class="titreCategorie">Type(s) de bien
		       			<div class="col s12 ligne"></div></div>
		       			<div class="contientCheckBox">
      						<label ><input type="checkbox" class="filled-in" name="typeBienAppartement" /><span> appartement </span></label>
      						<label ><input type="checkbox" class="filled-in" name="typeBienMaison" /><span> maison </span></label>
      						<label ><input type="checkbox" class="filled-in" name="typeBienCommerce" /><span> commerce </span></label>
      						<label ><input type="checkbox" class="filled-in" name="typeBienViager" /><span> viager </span></label>
      						<label ><input type="checkbox" class="filled-in" name="typeBienPropriete"/><span> proprieté </span></label>
      					</div>
		    	</div>
		    	<div class="categorie row">
		       		<div class="titreCategorie">Budget
		       			<div class="col s12 ligne"></div></div>

		          		<div class=" input-field col s3 grey lighten-4"><label for="immat_id"></label><input class="searchBarInput" placeholder="min" type="text"  name="minBudget" /></div>

		          		<div class=" input-field col s3 grey lighten-4"><label for="immat_id"></label><input class="searchBarInput" placeholder="max" type="text"  name="maxBudget" /></div>   	
		    	</div>
		    	<div class="categorie row">
		       		<div class="titreCategorie">Surface
		       			<div class="col s12 ligne"></div></div>

		          		<div class=" input-field col s3 grey lighten-4"><label for="immat_id"></label><input class="searchBarInput" placeholder="min" type="text"  name="minSurface" /></div>

		          		<div class=" input-field col s3 grey lighten-4"><label for="immat_id"></label><input class="searchBarInput" placeholder="max" type="text"  name="maxSurface" /></div>
		    	</div>
		    	<div class="categorie row">
		       		<div class="titreCategorie">Nombre de chambre(s)
		       			<div class="col s12 ligne"></div>
		       			<div class="contientCheckBox">
      						<label ><input type="checkbox" class="filled-in" name="nomreChambre1" /><span> 1 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomreChambre2"/><span> 2 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomreChambre3"/><span> 3 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomreChambre4"/><span> 4 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomreChambre5"/><span> 5 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomreChambre6Plus"/><span> 6+ </span></label>
      					</div>
		        	</div>
		    	</div>
		    	<div class="categorie row">
		       		<div class="titreCategorie">Nombre de pièces
		       			<div class="col s12 ligne"></div></div>
		       			<div class="contientCheckBox">
      						<label ><input type="checkbox" class="filled-in" name="nomrePieces1" /><span> 1 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomrePieces2"/><span> 2 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomrePieces3" /><span> 3 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomrePieces4" /><span> 4 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomrePieces5" /><span> 5 </span></label>
      						<label ><input type="checkbox" class="filled-in" name="nomrePieces6Plus" /><span> 6+ </span></label>
		        		</div>
		    		</div>
		    	<div class="categorie row">
		       		<div class="titreCategorie">Type(s) de pièces
		       			<div class="col s12 ligne"></div></div>
		       			<div class="contientCheckBox">
      						<label ><input type="checkbox" class="filled-in" name="typePieceSam" /><span> S.A.M séparée </span></label>
      						<label ><input type="checkbox" class="filled-in" name="typePieceToilettes" /><span> toilettes séparée</span></label>
      						<label ><input type="checkbox" class="filled-in" name="typePieceSdb" /><span> salle de bain </span></label>
      						<label ><input type="checkbox" class="filled-in" name="typePieceSd" /><span> salle d'eau (douche) </span></label>
      						<label ><input type="checkbox" class="filled-in" name="typePieceHall" /><span> pas de hall d'entrée</span></label>
		        		</div>
		    		</div>
		    	<div class="categorie row">
		       		<div class="titreCategorie">Commodité(s)
		       			<div class="col s12 ligne"></div></div>
		       				<div class="contientCheckBox">
	      						<label ><input type="checkbox" class="filled-in" name="commoditePiscine"/><span> piscine </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="commoditeAlarme"/><span> alarme </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="commoditeClim"/><span> climatisation </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="commoditeCheminee"/><span> cheminée </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="commoditeTerasse"/><span> terrasse(s) </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="commoditeBalcon"/><span> balcon(s) </span></label>
	      					</div>
		    	</div>
		    		<div class="categorie row">
		       		<div class="titreCategorie">Rangement
		       			<div class="col s12 ligne"></div></div>
		       				<div class="contientCheckBox">
	      						<label  ><input type="checkbox" class="filled-in" name="rangementCave" /><span> cave </span></label>
	      						<label ><input type="checkbox" class="filled-in"  name="rangementPlacards"/><span> placards </span></label>
	      						<label ><input type="checkbox" class="filled-in"  name="rangementParking"/><span> parking ouvert </span></label>
	      						<label ><input type="checkbox" class="filled-in"  name="rangementGarage"/><span> garage </span></label>
	      					</div>
		    	</div>
		    		<div class="categorie row">
		       		<div class="titreCategorie">Orientation
		       			<div class="col s12 ligne"></div></div>
		       				<div class="contientCheckBox">
	      						<label ><input type="checkbox" class="filled-in" name="orientationSud" /><span> sud</span></label>
	      						<label ><input type="checkbox" class="filled-in" name="orientationEst" /><span> est </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="orientationNord" /><span> nord </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="orientationOuest"/><span> ouest</span></label>
	      						<label ><input type="checkbox" class="filled-in" name="orientationVue" /><span> belle vue </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="orientationVis" /><span> sans vis à vis</span></label>
	      					</div>
		    	</div>
		    	<div class="categorie row">
		       		<div class="titreCategorie">Options
		       			<div class="col s12 ligne"></div></div>
		       				<div class="contientCheckBox">
	      						<label ><input type="checkbox" class="filled-in" name="optionsMeuble" /><span> meublé</span></label>
	      						<label ><input type="checkbox" class="filled-in" name="optionsInterphone"/><span> interphone </span></label>
	      						<label ><input type="checkbox" class="filled-in" name="optionsDigicode" /><span> digicode</span></label>
	      						<label ><input type="checkbox" class="filled-in" name="optionsGardien" /><span> gardien</span></label>
	      						<label ><input type="checkbox" class="filled-in" name="optionsAscenseur" /><span> avec ascenseur </span></label>
	      					</div>
	      	</div>
	            <input  class="inputButton inputButtonApprofondie" type="submit" value="Envoyer" />
  		</div>
	    </div>
      </form>
	</div>
</div>

<?php?>
