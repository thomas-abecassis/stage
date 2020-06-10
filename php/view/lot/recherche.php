<div class="container noMarginTop">
	<div id="banniere" class="fond"></div>
	<div class="col s12 l8 offset-l2">
		<div class="card" id="searchBox">
	      <form id="submitForm" method="get" action="index/lotApprofondi/searchedDeepen/">
		       <div class="row">
		          	
		          	<div class="col s12 l5" id="contenantVille" style="padding: 0px;">
			          	<div class="searchBarBox input-field grey lighten-4">
				            <label></label>
				            <input id= "searchBoxVille" class="searchBarInput" placeholder="où ?" type="text"  name="localisation" autocomplete="off" />
			        	</div>
			        	<div class="card" id="resultSearchVille"></div>
		        	</div>

		          	<div class="searchBarBox input-field col s6 l3 grey lighten-4">
		            <label></label>
		            <input  class="searchBarInput" placeholder="min m²" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="minSurface" autocomplete="off" />
		            </div>

			        <div class="searchBarBox input-field col s6 l2  grey lighten-4">
			        <label></label>
			        <input  id="minEur" class="searchBarInput" placeholder="min €" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="minBudget" autocomplete="off"/>
			        </div>

			        <div class="hide-on-med-and-down searchBarBox input-field col s6 l2 grey lighten-4">
			        <label></label>
			        <input  id="maxEur" class="searchBarInput" placeholder="max €" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="maxBudget" autocomplete="off"/>
			        </div>

			        <span id="notifEur" class="displayNone red-text text-darken-1 col s6 l4 push-s6 push-l8">Le budget minimum doit être inférieur au maximum</span>
		      		<!--<input type='hidden' name='controller' value='lot'>
              		<input type='hidden' name='action' value='searched'> -->
              		<input type='hidden' name='page' value='1'>
              		<input type='hidden' name='recherche' value='simple'>
		    </div>
		    	  <div id="plusCriteres">
		    	  	<a class="premiereCouleurText" href="index/lotApprofondi/searchDeepen/">
		    	  	plus de critères
		    	  	</a>
		    	  	<a href="index/lotApprofondi/searchDeepen/" class="btn-floating btn-small waves-effect waves-light premiereCouleur">
		    	  		<i class="material-icons">add</i>
		    	  	</a>
		    	  </div>


		    <div id="wrapperButtonRecherche" class="absolute">
	    		<div class="relative" style="left: -50%;">
		            <input  class="secondeCouleur inputButton" type="submit" value="Envoyer" />
	    		</div>
	  		</div>
	  		
	      </form>
		</div>
	</div>
</div>
<script src="js/search.js"></script>

<?php



?>
