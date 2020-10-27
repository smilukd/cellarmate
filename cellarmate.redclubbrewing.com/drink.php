
<?php
/* enable this once the site is passing post data, for now its commented out so it works
	if(!isset($_POST['id']))
	{
		//a user not logged in is trying to access this page, send them back to the login page
		header('location: login.php');
	}
	else
	{
		include('scripts/connect.php');
	}
*/
include('scripts/connect.php');
session_start();
unset($_SESSION['insertedBeer']);

if(isset($_SESSION['results']))
{
	unset($_SESSION['results']);
}
if(isset($_SESSION['brewery']))
{
	unset($_SESSION['brewery']);
}

if(isset($_SESSION['purged']))
{
	unset($_SESSION['removal']);
	unset($_SESSION['purged']);
}

if(!isset($_SESSION['USER']))
{
	header('location: login.php');
}
elseif($_SESSION['USER']['role'] == "admin")
{
	header('location: admin.php');
}

//if(isset($_SESSION['removal']['triedOnce']))
//{
//	unset($_SESSION['removal']);
//}



if(!isset($_SESSION['USER']))
{
	//non logged in user is trying to access the callar page, send them to the login page
	header('location: login.php');
}
else
{
	$id = $_SESSION['USER']['id'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cellarmate - Drink A Beer</title>
<!--    Bootstrap templace courtesy of Bootsrtap Free Admin Template - SIMINTA | Admin Dashboad Template -->
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <!-- Page-Level CSS -->
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <style>
		.centering{
			text-align: center;
		}
		.actionMove{
			margin-top: -120%;
		}
		.middle{
			vertical-align: middle;
		}
		#reason{
			font-size: 1.75em;
		}
	</style>
   </head>
   
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <?php
			include('scripts/topnav.php');
		
		?>
        <!-- end navbar top -->

        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <?php
							include('scripts/userimagesection.php');
							
						?>
                        <!--end user image section-->
                    </li>
                    
                    <?php
							include('scripts/searchbar.php');
							include('scripts/nav.html');
						?>
                    
                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">
                    	<?php
								//USER CELLAR NAME
								$cellar = $_SESSION['USER']['cellarName'];
								echo $cellar;
								
							?> 
                    </h1>
                </div>
                <!--End Page Header -->
            </div>

            <div class="row">
                <!-- Welcome -->
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-folder-open"></i><b>&nbsp;Hello, <?php echo $fullname; ?> </b>
 						<!--<i class="fa  fa-pencil"></i>-->
                    </div>
                </div>
                <!--end  Welcome -->
            </div>

            <div class="row">
                <div class="col-lg-8">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3><i class="fa fa-bar-chart-o fa-fw"></i><?php 
																		if(isset($_SESSION['aboutToRemove']))
																		{
																			if($_SESSION['aboutToRemove']['removalMethod'] == "edit")
																			{
																				echo " Edit a beer";
																			}
																			else
																			{
																				echo " Beer details";
																			}	
																		}
																		else
																		{
																			echo " Drink a beer";
																		}
																		
																		?>
																			</h3>
                            <div class="pull-right">
                                <div class="btn-group actionMove">
                                    <?php
										include('scripts/actionbutton.html');
									?>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                 		<?php
                                  		if(!isset($_POST['drink']) && !isset($_SESSION['aboutToRemove']) && !isset($_SESSION['removal']))
                                  		{
											
											echo "<form action='scripts/removebeer.php' method='post'>
									   		
											<input type='text' class='form-control' name='removal' placeholder='Scan barcode or type name' autofocus><br><button type='submit' class='btn btn-info' name='search' value='search'>Search</button><br>
											
									   		</form>";
											//print_r($_SESSION);
                                 		
                                  		}
										?>
									
                                   <br>
                                   <?php
									$hasPageLoaded = true;
									if(isset($_POST['purge']))
									{
									//the user wants to straight purge the beer from the database, not drink it.
										//$removalID = $_SESSION['USERS_UNIQUE_BEER_ID'];
										//echo $removalID;
										
										//print_r($_SESSION['removal'][0]);
										$removalID = $_SESSION['removal'][0]['USERS_UNIQUE_BEER_ID'];
										echo "<form action='scripts/drinkbeer.php' method='post'>";
										echo "<span id='reason'><input class='form-group' type='text' size='40' placeholder='Reason for deletion' name='reason' required></span>";
										echo "<br>";
										echo "<button class='btn btn-danger btn-lg' name='purgeConfirm' type='submit' value='$removalID'>Confirm DELETE!</button>";

										echo "</form><br>";
									}
									?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            
                                            
                                               	<?php
											
													if(isset($_SESSION['removal']) && !isset($_SESSION['aboutToRemove']))
													{
														$returnedBeers = $_SESSION['removal'];
														$_SESSION['viewed'] = true;
														if(!is_array($returnedBeers))
														{
															//No beers found
															echo "<h2>".$returnedBeers."</h2>";
															echo "<br><a href='cellar.php' class='btn btn-info'>Back to cellar</a>";
															
														}
														else
														{
															//bring the table head in only when its a search for a beer to remove
															include('scripts/tablehead.html');
															echo "<tbody>";
															foreach($returnedBeers as $beer)
															{
																echo "<tr>";
																echo "<td class='centering'>".$beer['USERS_BEER_NAME']."</td>";
																echo "<td class='centering'>".$beer['USERS_BREWERY_NAME']."</td>";
																echo "<td class='centering'>".$beer['USERS_BEER_VINTAGE']."</td>";
																echo "<td class='centering'><form action='scripts/preremoval.php' method='post'><button class='btn btn-info' type='submit' name='view' value='".$beer['USERS_UNIQUE_BEER_ID']."'>View</button> <button class='btn btn-success' type='submit' name='remove' value='".$beer['USERS_UNIQUE_BEER_ID']."'>Drink</button></td>";
																echo "</tr>";
															}
															
														}
														
													}
												
													if(isset($_SESSION['aboutToRemove']))
													{
														//the user seleceted a beer to remove
														$beerToRemove = $_SESSION['aboutToRemove'];
														//print_r($_SESSION);
														if(isset($_POST['drink']) || isset($_POST['purge']))
														{
															if(isset($_POST['drink']))
															{
																//user wants to drink the beer
																
																//probably dont need this, I think i would still have access to the $beerToRemove, but thats OK, this should work and be 'safer'
																$removalID = $_POST['drink'];
										//confirm the user wants to drink this beer
																
																echo "<td colspan='2'><form action='scripts/drinkbeer.php' method='post'><h3>Are you sure you want to remove this beer from your cellar?</h3><h3>{$_SESSION['removal'][0]['USERS_BEER_NAME']}</h3><br><button class='btn btn-danger btn-lg' name='drinkConfirm' type='submit' value='$removalID'>Click to Drink!</button></form><a class='btn btn-success pull-right' href='cellar.php'>Cancel</a></td>";
																
															}
															elseif(isset($_POST['purge']))
															{
																//user wants to remove this beer from the database
															}
															
														}
														if($beerToRemove['removalMethod'] == "view" && !isset($_POST['drink']))
														{
															//display the data for the beer, then give them the option to remove it for whatever reason
															if(!isset($_POST['purge']))
															{
																echo "<tbody>
																<form action='drink.php' method='post'><tr><td colspan='2'><button class='btn btn-success btn-lg pull-right' name='drink' type='submit' value='".$beerToRemove['USERS_UNIQUE_BEER_ID']."'>DRINK THIS BEER!</button></td>";
															}
															include('scripts/displayremovalbeer.php');
															
															echo "<td colspan='2'><a href='cellar.php' class='pull-right btn btn-info btn-sm'>Cancel</a></td>";
															
															/*
															if(!isset($_POST['drink']) && !isset($_POST['purge']))
															{	
																//if both of the POSTS are NOT set
																echo "<td colspan='2'><button class='pull-right btn btn-default btn-sm' name='purge' type='submit' value=''>DELETE from database</button></td>";
															}
															*/
															
															
															echo "</form>";
														}
														elseif($_SESSION['aboutToRemove']['removalMethod'] == "edit")
														{
															//this is where we display the beer to edit the details.
															//all the needed data is in the session['aboutToRemove']
															//print_r($_SESSION);
															$uniqueBeerId = $_SESSION['aboutToRemove']['USERS_UNIQUE_BEER_ID'];
															
															$query = $db->prepare("SELECT USERS_BARCODE
																						, USERS_BEER_NAME
																						, USERS_BEER_ABV
																						, USERS_BEER_CONTAINER_SIZE
																						, USERS_BEER_IBU
																						, USERS_BEER_IMAGE
																						, USERS_BEER_NOTES
																						, USERS_BEER_STYLE
																						, USERS_BEER_VINTAGE
																						, USERS_BREWERY_NAME
																						, USERS_BEER_USER_ID
																						, USERS_PURCHASE_PLACE
																						, USERS_PURCHASE_PRICE
																						, USERS_PURCHASE_DATE
																						, USERS_BEER_DESCRIPTION 
																					FROM users_beer
																					WHERE USERS_UNIQUE_BEER_ID = ?");
															$query->execute(array($uniqueBeerId));
															$query->setFetchMode(PDO::FETCH_ASSOC);
															$result = $query->fetch();
															echo "<div class='col-lg-5'>";
															if(isset($_SESSION['updatedBeer']))
															{
																echo "<h3 class='green'>Beer updated successfully</h3>";
																unset($_SESSION['updatedBeer']);
																
															}
															echo "<form action='scripts/insertBeer.php' method='post'>";
															
															echo "<label>Beer Name</label><input type='text' class='form-control' value='{$result['USERS_BEER_NAME']}' name='beerName'>";
															echo "<label>Brewery</label><input type='text' class='form-control' value='{$result['USERS_BREWERY_NAME']}' name='breweryName'>";
															echo "<label>Container Size</label><input type='text' class='form-control' name='containerSize' value='{$result['USERS_BEER_CONTAINER_SIZE']}'>";
															echo "<label>IBU</label><input type='text' class='form-control' value='{$result['USERS_BEER_IBU']}' name='ibu'>";
															echo "<label>ABV</label><input type='text' class='form-control' value='{$result['USERS_BEER_ABV']}' name='abv'>";
															echo "<label>Beer Style</label><input type='text' class='form-control' value='{$result['USERS_BEER_STYLE']}' name='style'>";
															if($result['USERS_BEER_IMAGE'] != NULL)
															{
																echo "<img src='{$result['USERS_BEER_IMAGE']}' alt='No Image Available' name='image' value='{$result['USERS_BEER_IMAGE']}'>";
															}
															else
															{
																echo "<br><br>No Image Available";
															}


															echo "</div>
																	<div class='col-lg-5'>";


															echo "<label>Vintage</label><input type='text' class='form-control' value='{$result['USERS_BEER_VINTAGE']}' name='beerVintage'>";
															echo "<label>Purchase Place</label><input type='text' class='form-control'  name='purchasePlace' value ='{$result['USERS_PURCHASE_PLACE']}'>";
															echo "<label>Purchase Price</label><input type='text' class='form-control' name='purchasePrice' value='{$result['USERS_PURCHASE_PRICE']}'>";
							//if I get time maybe add a date picker calendar....
															//echo "<label>Purchase Date</label><input type='text' class='form-control' name='purchaseDate' value='{$result['USERS_PURCHASE_DATE']}'>";
																								
															echo "<label>Description</label><textarea rows='5' cols='50' class='form-control' name='description'>{$result['USERS_BEER_DESCRIPTION']}</textarea>";
															echo "<label>Notes</label><textarea rows='3' cols='50' class='form-control' name='notes'>{$result['USERS_BEER_NOTES']}</textarea>";
															echo "<br><a href='cellar.php' class='btn btn-info pull-left'>Back to Cellar</a><button class='btn btn-success pull-right' name='updateBeer' value='$uniqueBeerId'>Update Details</button><br><br><br>
																</form><form action='scripts/preremoval.php' method='post'><button class='btn btn-success pull-right' name='remove' value='$uniqueBeerId'>Drink!</button></form></div>";																	
																}

															}
												?>
                                               
                                            </tbody>
                                        </table>
                                        
                                    </div>

                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!--End simple table example -->

                </div>

                <?php
					include('scripts/usercellarcount.php');
				?>

            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/scripts/dashboard-demo.js"></script>
    <script>
		$("#drink").addClass("selected");
	</script>

</body>

</html>
