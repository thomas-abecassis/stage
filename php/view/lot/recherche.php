
<div class="container">
	<div class="col s12 m8 offset-m2">
		<div class="card" id="searchBox">
	      <form method="get" action="index/lot/searched/">
		       <div class="row">
		          	
		          	<div class="col s5" id="contenantVille" style="padding: 0px;">
			          	<div class="searchBarBox input-field grey lighten-4">
				            <label></label>
				            <input id= "searchBoxVille" class="searchBarInput" placeholder="où ?" type="text"  name="localisation" autocomplete="off" />
			        	</div>
			        	<div class="card" id="resultSearchVille"></div>
		        	</div>

		          	<div class="searchBarBox input-field col s3 grey lighten-4">
		            <label></label>
		            <input  class="searchBarInput" placeholder="min m²" type="number" name="minSurface" autocomplete="off" />
		            </div>

		          	<div class="searchBarBox input-field col s2  grey lighten-4">
		            <label></label>
		            <input  class="searchBarInput" placeholder="min €" type="number" name="minBudget" autocomplete="off"/>
		            </div>

		          	<div class="searchBarBox input-field col s2 grey lighten-4">
		            <label></label>
		            <input  class="searchBarInput" placeholder="max €" type="number" name="maxBudget" autocomplete="off"/>
		            </div>
		      		<!--<input type='hidden' name='controller' value='lot'>
              		<input type='hidden' name='action' value='searched'> -->
              		<input type='hidden' name='page' value='1'>
		    </div>
		    	  <div id="plusCriteres">
		    	  	<a class="premiereCouleurText" href="index/lotApprofondi/searchDeepen/">
		    	  	plus de critères
		    	  </a>
		    	  	<a href="index/lotApprofondi/searchDeepen/" class="btn-floating btn-small waves-effect waves-light premiereCouleur">
		    	  		<i class="material-icons">add</i>
		    	  	</a>
		    	  </div>


		    <div style="position: absolute; left: 50%;">
	    		<div style="position: relative; left: -50%;">
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
