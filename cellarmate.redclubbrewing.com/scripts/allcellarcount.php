<div class="panel panel-primary text-center no-boder">
	<div class="panel-body yellow"><!-- TOTAL NUMBER OF BEERS AREA -->

<!--                            <i class="fa fa-bar-chart-o fa-3x"></i>-->
	   <?php
			//lets get the total number of beers in the users cellar
			$query = $db->query("SELECT count(*)
									FROM users_beer WHERE USERS_CHECK_OUT_DATE IS NULL;");
			$query->setFetchMode(PDO::FETCH_ASSOC);

			$beerCount = $query->fetch();

		?>
		<h3><?php echo $beerCount['count(*)']; ?></h3>
	</div>
	<div class="panel-footer">
		<span class="panel-eyecandy-title">Total Number of Beers in ALL cellars
		</span>
	</div>
</div>
<div class="panel panel-primary text-center no-boder">
	<div class="panel-body blue"><!-- UNIQUE BEER COUNT AREA -->
<!--                            <i class="fa fa-pencil-square-o fa-3x"></i>-->
		<?php
			$query = $db->query("SELECT count(*)
									FROM (SELECT DISTINCT USERS_BARCODE
															, USERS_BEER_NAME
															, USERS_BEER_VINTAGE
											FROM users_beer WHERE USERS_CHECK_OUT_DATE IS NULL) distinctBeer;");
			$query->setFetchMode(PDO::FETCH_ASSOC);

			$uniqueCount = $query->fetch();


		?>
		<h3><?php echo $uniqueCount['count(*)']; ?></h3>
	</div>
	<div class="panel-footer">
		<span class="panel-eyecandy-title">Unique Beers across ALL cellars
		</span>
	</div>
</div>
<div class="panel panel-primary text-center no-boder">
	<div class="panel-body green"><!-- CONSUMED BEERS COUNT AREA -->
<!--                            <i class="fa fa fa-floppy-o fa-3x"></i>-->
	   <?php
			$query = $db->query("SELECT sum(USER_CONSUMED_BEERS)
									FROM user;");
			$query->setFetchMode(PDO::FETCH_ASSOC);

			$consumedCount = $query->fetch();


		?>
		<h3><?php echo $consumedCount['sum(USER_CONSUMED_BEERS)']; ?></h3>
	</div>
	<div class="panel-footer">
		<span class="panel-eyecandy-title">Consumed Beers from ALL cellars
		</span>
	</div>
</div>