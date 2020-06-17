	<div class="container">
		<div class="col s12 m8 offset-m2">
			<div class="card searchBoxApprofondie" id="searchBox" >
		      <form id="submitForm" method="get" action="index/lotApprofondi/searchedDeepen/">
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
				       		<div class="titreCategorie">Budget
				       			<div class="col s12 ligne"></div></div>

				          		<div class=" input-field col s3 grey lighten-4"><input id="minEur" class="searchBarInput" placeholder="min" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57"   name="minBudget" autocomplete="off" /></div>

				          		<div class=" input-field col s3 grey lighten-4"><input id="maxEur" class="searchBarInput" placeholder="max" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  name="maxBudget" autocomplete="off"/></div>
				          		<span id="notifEur" class="displayNone red-text text-darken-1 col s7">Le budget minimum doit être inférieur au maximum</span>
				    	</div>
				    	<div class="categorie row">
				       		<div class="titreCategorie">Surface
				       			<div class="col s12 ligne"></div></div>

				          		<div class=" input-field col s3 grey lighten-4"><input id="minSurface" class="searchBarInput" placeholder="min" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  name="minSurface" autocomplete="off"/></div>

				          		<div class=" input-field col s3 grey lighten-4"><input id="maxSurface" class="searchBarInput" placeholder="max" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  name="maxSurface" autocomplete="off"/></div>

				          		<span id="notifSurface" class="displayNone red-text text-darken-1 col s7">La surface minimum doit être inférieur au maximum</span>
				    	</div>

				    	<?php
				 
				    		foreach ($categorieValeurs as $nomCategorie => $values) {

				    			echo "
						    	<div class=\"categorie row\">
						       		<div class=\"titreCategorie\">$nomCategorie
						       			<div class=\"col s12 ligne\"></div></div>
						       				<div class=\"contientCheckBox\">";
							       					foreach ($values as $value) {
							       						echo "<label ><input type=\"checkbox\" class=\"filled-in\" name=\"" . $value->id ."\" /><span> ".$value->valeur." </span></label>";
							       					}
							    echo "
					      					</div>
					      	</div>";
				    		}

				    		

					      		
				    	?>
			            <input  class="inputButton inputButtonCentre secondeCouleur" type="submit" value="Envoyer" />
		  		</div>
			    </div>
	            <input type='hidden' name='page' value='1'>
	            <input type='hidden' name='recherche' value='approfondi'>
		      </form>
			</div>
		</div>
	</div>
	<script src="js/search.js"></script>
