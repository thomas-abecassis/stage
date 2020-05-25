	<div class="container">
		<div class="col s12 m8 offset-m2">
			<div class="card searchBoxApprofondie" id="searchBox" >
		      <form method="get" action="index/lotApprofondi/searchedDeepen/">
			       		<div class="categorie row">
				       		<div class="titreCategorie">Localisation
				       			<div class="col s12 ligne"></div></div>
			          	<div class="col s5" id="contenantVille" style="padding: 0px;">
				          	<div class="searchBarBox input-field grey lighten-4">
					            <label></label>
					            <input id= "searchBoxVille" class="searchBarInput" placeholder="où ?" type="text"  name="localisation" autocomplete="off" />
				        	</div>
				        	<div class="card" id="resultSearchVille"></div>
				        	</div>
				    	</div>
				    	<div class="categorie row">
				       		<div class="titreCategorie">Type(s) de bien
				       			<div class="col s12 ligne"></div></div>
				       			<div class="contientCheckBox">
				       				<?php
				       					foreach ($typesDeBiens as $type) {
				       						echo "<label ><input type=\"checkbox\" class=\"filled-in\" name=\"typeBien". ucfirst($type->typeDeBien) ."\" /><span> ".$type->typeDeBien." </span></label>";
				       					}
				       				?>
		      					</div>
				    	</div>
				    	<div class="categorie row">
				       		<div class="titreCategorie">Budget
				       			<div class="col s12 ligne"></div></div>

				          		<div class=" input-field col s3 grey lighten-4"><input class="searchBarInput" placeholder="min" type="number"  name="minBudget" autocomplete="off" /></div>

				          		<div class=" input-field col s3 grey lighten-4"><input class="searchBarInput" placeholder="max" type="number"  name="maxBudget" autocomplete="off"/></div>
				    	</div>
				    	<div class="categorie row">
				       		<div class="titreCategorie">Surface
				       			<div class="col s12 ligne"></div></div>

				          		<div class=" input-field col s3 grey lighten-4"><input class="searchBarInput" placeholder="min" type="number"  name="minSurface" autocomplete="off"/></div>

				          		<div class=" input-field col s3 grey lighten-4"><input class="searchBarInput" placeholder="max" type="number"  name="maxSurface" autocomplete="off"/></div>
				    	</div>
				    	<!--<div class="categorie row">
				       		<div class="titreCategorie">Nombre de chambre(s)
				       			<div class="col s12 ligne"></div>
				       			<div class="contientCheckBox">
		      						<label ><input type="checkbox" class="filled-in" name="nombreChambre1" /><span> 1 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombreChambre2"/><span> 2 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombreChambre3"/><span> 3 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombreChambre4"/><span> 4 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombreChambre5"/><span> 5 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombreChambre6Plus"/><span> 6+ </span></label>
		      					</div>
				        	</div>
				    	</div>-->
				    	<div class="categorie row">
				       		<div class="titreCategorie">Nombre de pièces
				       			<div class="col s12 ligne"></div></div>
				       			<div class="contientCheckBox">
		      						<label ><input type="checkbox" class="filled-in" name="nombrePieces1" /><span> 1 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombrePieces2"/><span> 2 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombrePieces3" /><span> 3 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombrePieces4" /><span> 4 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombrePieces5" /><span> 5 </span></label>
		      						<label ><input type="checkbox" class="filled-in" name="nombrePieces6Plus" /><span> 6+ </span></label>
				        		</div>
				    		</div>
				    	<div class="categorie row">
				       		<div class="titreCategorie">Type(s) de pièces
				       			<div class="col s12 ligne"></div></div>
				       			<div class="contientCheckBox">
				       				<?php
				       					foreach ($typesDePieces as $piece) {
				       						echo "<label ><input type=\"checkbox\" class=\"filled-in\" name=\"typePiece". ucfirst($piece->typeDePieces) ."\" /><span> ".$piece->typeDePieces." </span></label>";
				       					}
				       				?>
				        		</div>
				    		</div>
				    	<div class="categorie row">
				       		<div class="titreCategorie">Commodité(s)
				       			<div class="col s12 ligne"></div></div>
				       				<div class="contientCheckBox">
				       				<?php
				       					foreach ($commodites as $commodite) {
				       						echo "<label ><input type=\"checkbox\" class=\"filled-in\" name=\"commodite". ucfirst($commodite->commodites) ."\" /><span> ".$commodite->commodites." </span></label>";
				       					}
				       				?>
			      					</div>
				    	</div>
				    		<div class="categorie row">
				       		<div class="titreCategorie">Rangement(s)
				       			<div class="col s12 ligne"></div></div>
				       				<div class="contientCheckBox">
				       				<?php
				       					foreach ($rangements as $rangement) {
				       						echo "<label ><input type=\"checkbox\" class=\"filled-in\" name=\"rangement". ucfirst($rangement->rangement) ."\" /><span> ".$rangement->rangement." </span></label>";
				       					}
				       				?>
			      					</div>
				    	</div>
				    		<div class="categorie row">
				       		<div class="titreCategorie">Orientation(s)
				       			<div class="col s12 ligne"></div></div>
				       				<div class="contientCheckBox">
				       				<?php
				       					foreach ($orientations as $orientation) {
				       						echo "<label ><input type=\"checkbox\" class=\"filled-in\" name=\"orientation". ucfirst($orientation->orientation) ."\"/><span> ".$orientation->orientation." </span></label>";
				       					}
				       				?>
			      					</div>
				    	</div>
				    	<div class="categorie row">
				       		<div class="titreCategorie">Option(s)
				       			<div class="col s12 ligne"></div></div>
				       				<div class="contientCheckBox">
					       				<?php
					       					foreach ($options as $option) {
					       						echo "<label ><input type=\"checkbox\" class=\"filled-in\" name=\"myOptions". ucfirst($option->options) ."\" /><span> ".$option->options." </span></label>";
					       					}
					       				?>
			      					</div>
			      	</div>
			            <input  class="inputButton inputButtonCentre secondeCouleur" type="submit" value="Envoyer" />
		  		</div>
			    </div>
			    <input type='hidden' name='controller' value='lotApprofondi'>
	            <input type='hidden' name='action' value='searchedDeepen'>
	            <input type='hidden' name='page' value='1'>
		      </form>
			</div>
		</div>
	</div>
	<script src="js/search.js"></script>
