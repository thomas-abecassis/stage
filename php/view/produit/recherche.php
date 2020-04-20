
<div class="col s12 m8 offset-m2">
	<div class="card" id="searchBox">
      <form method="get" action="index.php?controller=produit&action=searched">
	       <div class="row">
	          <p>
	          	<div class="searchBarBox input-field col s3 grey lighten-4">
	            <label for="immat_id"></label>
	            <input class="searchBarInput" placeholder="où ?" type="text"  name="localisation"  />
	        </div>
	          </p>

	          <p>
	          	<div class="searchBarBox input-field col s3 grey lighten-4">
	            <label for="couleur_id"></label>
	            <input  class="searchBarInput" placeholder="min m²" type="text" name="minSurface" />
	            </div>
	          </p>

	          <p>
	          	<div class="searchBarBox input-field col s3  grey lighten-4">
	            <label for="couleur_id"></label>
	            <input  class="searchBarInput" placeholder="min €" type="text" name="minBudget" />
	            </div>
	          </p>

	          <p>
	          	<div class="searchBarBox input-field col s3 grey lighten-4">
	            <label for="couleur_id"></label>
	            <input  class="searchBarInput" placeholder="max €" type="text" name="maxBudget"/>
	            </div>
	          </p>

	    </div>
	    	  <div id="plusCriteres">
	    	  	<a href="index.php?action=searchDeepen&controller=produit">
	    	  	plus de critères
	    	  </a>
	    	  	<a href="index.php?action=searchDeepen&controller=produit" class="btn-floating btn-small waves-effect waves-light red">
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

<?php 



?>