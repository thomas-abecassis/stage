
<div class="col s12 m8 offset-m2">
	<div class="card" id="searchBox">
      <form method="post" action="index.php?controller=lot&action=searched">
	       <div class="row">
	          <p>
	          	<div class="col s5" id="contenantVille" style="padding: 0px;">
		          	<div class="searchBarBox input-field grey lighten-4">
			            <label for="immat_id"></label>
			            <input id= "searchBoxVille" class="searchBarInput" placeholder="où ?" type="text"  name="localisation" autocomplete="off" />
		        	</div>
		        	<div class="card" id="resultSearchVille"></div>
	        	</div>
	          </p>

	          <p>
	          	<div class="searchBarBox input-field col s3 grey lighten-4">
	            <label for="couleur_id"></label>
	            <input  class="searchBarInput" placeholder="min m²" type="text" name="minSurface" autocomplete="off" />
	            </div>
	          </p>

	          <p>
	          	<div class="searchBarBox input-field col s2  grey lighten-4">
	            <label for="couleur_id"></label>
	            <input  class="searchBarInput" placeholder="min €" type="text" name="minBudget" autocomplete="off"/>
	            </div>
	          </p>

	          <p>
	          	<div class="searchBarBox input-field col s2 grey lighten-4">
	            <label for="couleur_id"></label>
	            <input  class="searchBarInput" placeholder="max €" type="text" name="maxBudget" autocomplete="off"/>
	            </div>
	          </p>

	    </div>
	    	  <div id="plusCriteres">
	    	  	<a href="index.php?action=searchDeepen&controller=lotApprofondi">
	    	  	plus de critères
	    	  </a>
	    	  	<a href="index.php?action=searchDeepen&controller=lotApprofondi" class="btn-floating btn-small waves-effect waves-light red">
	    	  		<i class="material-icons">add</i>
	    	  	</a>
	    	  </div>


	    <div style="position: absolute; left: 50%;">
    		<div style="position: relative; left: -50%;">
	            <input  class="inputButton" type="submit" value="Envoyer" />
    		</div>
  		</div>


	          </p>
      </form>
	</div>
</div>
<script type="text/javascript" src="../js/search.js"></script>

<?php 



?>