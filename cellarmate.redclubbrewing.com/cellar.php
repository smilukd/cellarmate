
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
unset($_SESSION['aboutToRemove']);
unset($_SESSION['removal']);
unset($_SESSION['brewery']);


if(!isset($_SESSION['USER']))
{
	//non logged in user is trying to access the callar page, send them to the login page
	header('location: login.php');
}
elseif($_SESSION['USER']['role'] == "admin")
{
	header('location: admin.php');
}
elseif($_SESSION['USER']['role'] = "user")
{
	$id = $_SESSION['USER']['id'];
}
else
{
	//catch all for someone somehow slipping through
	header('location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cellarmate - Your Cellar</title>
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
		.purged{
			color:red;
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
                        <i class="fa fa-folder-open"></i><b>&nbsp;Hello! </b>Welcome Back <b><?php echo $fullname; ?> </b>
 						<!--<i class="fa  fa-pencil"></i>-->
                    </div>
                </div>
                <!--end  Welcome -->
            </div>

            <div class="row">
                <div class="col-lg-8">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3><i class="fa fa-bar-chart-o fa-fw"></i> Your cellar contents</h3>
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
										if(isset($_SESSION['PURGED']))
										{
											$purgedBeer = $_SESSION['PURGED'];
											echo "<h3 class='purged'>$purgedBeer has been purged from your cellar</h3>";
											unset($_SESSION['PURGED']);
										}
									
									?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><h4>Beer Name</h4></th>
                                                    <th><h4>Brewery</h4></th>
                                                     <?php
														if(!isset($_GET['searchValue']))
														{
															//only show this column if the user did not search for a beer
															echo "<th class='centering'><h4>Quantity</h4></th>";
														}
													?>
                                                   	<th class='centering'><h4>Vintage</h4></th>
                                                    <th><h4>&nbsp;</h4></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               	<?php
													
													if(!isset($_GET['searchValue']) && !isset($_GET['searchPage']))
													{
														//start the pagination at 0
														$start = 0;
														
														//set the limit per page = 10
														$limit = 10;
														
														//if the page number is set
														if(isset($_GET['page']))
														{
															$current_page = $_GET['page'];
															$start = ($current_page-1)*$limit;
														}
														else
														{
															$current_page = 1;
															$start = ($current_page-1)*$limit;
														}

														
														//lets get the distinct beers from the database
														$query = $db->prepare("SELECT DISTINCT 
																				USERS_BEER_NAME
																				, USERS_BREWERY_NAME
																				, USERS_BEER_VINTAGE 
																			FROM 
																			(SELECT USERS_BEER_NAME
																					, USERS_BREWERY_NAME
																					, USERS_BEER_VINTAGE
																			 FROM users_beer
																			 WHERE
																				USERS_BEER_USER_ID = $id AND USERS_CHECK_OUT_DATE IS NULL) subQuery 
																			ORDER BY USERS_BEER_NAME
																			LIMIT $start, $limit;");
														//$query->execute(array($id, $start, $limit));
														$query->execute();
														$query->setFetchMode(PDO::FETCH_ASSOC);

														$beerResult = $query->fetchAll();
														
														$data = $db->prepare("SELECT DISTINCT 
																				USERS_BEER_NAME
																				, USERS_BREWERY_NAME
																				, USERS_BEER_VINTAGE 
																			FROM 
																			(SELECT USERS_BEER_NAME
																					, USERS_BREWERY_NAME
																					, USERS_BEER_VINTAGE
																			 FROM users_beer
																			 WHERE
																				USERS_BEER_USER_ID = $id AND USERS_CHECK_OUT_DATE IS NULL) subQuery;");
														$data->execute(array($id));
														$totalRecd = $data->rowCount();
														$num_of_pages = ceil($totalRecd/$limit);



														foreach($beerResult as $beer)
														{
															$beerName = $beer['USERS_BEER_NAME'];
															$breweryName = $beer['USERS_BREWERY_NAME'];
															$vintage = $beer['USERS_BEER_VINTAGE'];
															echo "<tr>
																	<td><b>$beerName</b></td>
																	<td>$breweryName</td>";
															
																	//account for apostrophes in the beer name
																	$slashBeerName = addslashes($beerName);
																	//account or apostrophes in the brewery name
																	$slashBreweryName = addslashes($breweryName);
																	
																	//lets get the quantites for each beer
																	$query = $db->query("SELECT count(*)
																						FROM 
																							(SELECT USERS_BEER_NAME
																									, USERS_BREWERY_NAME
																									, USERS_BEER_VINTAGE
																							FROM users_beer
																							WHERE USERS_BEER_NAME = '$slashBeerName'
																									 AND USERS_BREWERY_NAME = '$slashBreweryName'
																									 AND USERS_BEER_VINTAGE = '$vintage'
																									 AND USERS_BEER_USER_ID = '$id'
																									 AND USERS_CHECK_OUT_DATE IS NULL) distinctBeerCount;");
																	$query->setFetchMode(PDO::FETCH_ASSOC);

																	$distinctBeers = $query->fetch();


																	$distinctCount = $distinctBeers['count(*)'];
																	echo "<td class='centering'>$distinctCount</td>";
																	echo "<td class='centering'>$vintage</td><td class='centering'><form action='scripts/removebeer.php' method='post'><button type='submit' class='btn btn-sm btn-warning' value='$beerName' name='directRemoval'>View</button></form></td></tr>";
														}
														
														if($totalRecd >10)
														{
															//only show pagination if there is more than one page able to be shown
															
															
															if($current_page == 1)
															{
																//we are on the first page, only show the right chevron to go to page 2
																$next = $current_page+1;
																echo $current_page."&nbsp;&nbsp;<a class='fa fa-chevron-right' href='?page=".$next."'></a>";
															}
															elseif($current_page > 1 && $current_page == $num_of_pages)
															{
																//we are at the last page
																//show only left chevron
																$prev = $current_page-1;
																echo "<a class='fa fa-chevron-left' href='?page=".$prev."'></a>&nbsp;&nbsp;".$current_page;
															}
															else
															{
																//we are not at the first, nor the last, lets show both chevrons
																$next = $current_page+1;
																$prev = $current_page-1;
																echo "<a class='fa fa-chevron-left' href='?page=".$prev."'></a>&nbsp;&nbsp;".$current_page."&nbsp;&nbsp;<a class='fa fa-chevron-right' href='?page=".$next."'></a>";
															}
															
														}
													}
													else
													{
														//lets get the searched for beer from the database
														
														//start the pagination at 0
														$start = 0;
														
														//set the limit per page = 10
														$limit = 10;
														
														//if the page number is set
														if(isset($_GET['searchPage']))
														{
															$current_page = $_GET['searchPage'];
															$start = ($current_page-1)*$limit;
														}
														else
														{
															$current_page = 1;
															$start = ($current_page-1)*$limit;
														}
														
														$searchedBeer = $_GET['searchValue'];
														
														$query = $db->prepare("SELECT DISTINCT 
																				USERS_BEER_NAME
																				, USERS_BREWERY_NAME
																				, USERS_BEER_VINTAGE 
																				, USERS_UNIQUE_BEER_ID
																			FROM users_beer
																			WHERE USERS_BEER_USER_ID = '$id'
																				AND USERS_BEER_NAME LIKE '%".$searchedBeer."%'
																				AND USERS_CHECK_OUT_DATE IS NULL																			 
																			ORDER BY USERS_BEER_NAME
																			LIMIT $start, $limit;");
														//$query->execute(array($id, $start, $limit));
														$query->execute();
														$query->setFetchMode(PDO::FETCH_ASSOC);

														$searchResult = $query->fetchAll();
														
														$data = $db->prepare("SELECT 
																				USERS_BEER_NAME
																				, USERS_BREWERY_NAME
																				, USERS_BEER_VINTAGE 
																				, USERS_UNIQUE_BEER_ID
																			FROM users_beer																			
																			WHERE
																				USERS_BEER_USER_ID = '$id'
																				AND USERS_BEER_NAME LIKE '%".$searchedBeer."%'
																				AND USERS_CHECK_OUT_DATE IS NULL;");
														$data->execute(array($id));
														$totalRecd = $data->rowCount();
														$num_of_pages = ceil($totalRecd/$limit);
														/*$query = $db->query("SELECT 
																				USERS_BEER_NAME
																				, USERS_BREWERY_NAME
																				, USERS_BEER_VINTAGE 
																				, USERS_UNIQUE_BEER_ID
																			FROM users_beer																			
																			WHERE
																				USERS_BEER_USER_ID = '$id'
																				AND USERS_BEER_NAME LIKE '%".$searchedBeer."%'
																				AND USERS_CHECK_OUT_DATE IS NULL;");
														$query->setFetchMode(PDO::FETCH_ASSOC);

														$searchResult = $query->fetch();
														
														
														
														
														$totalRecd = $searchResult->rowCount();
														$num_of_pages = ceil($totalRecd/$limit);
														echo $totalRecd;
														*/
														if($totalRecd >10)
														{
															//only show pagination if there is more than one page able to be shown
															
															
															if($current_page == 1)
															{
																//we are on the first page, only show the right chevron to go to page 2
																$searchedBeer = $_GET['searchValue'];
																$next = $current_page+1;
																echo $current_page."&nbsp;&nbsp;<a class='fa fa-chevron-right' href='?searchPage=".$next."&searchValue=".$searchedBeer."'></a>";
															}
															elseif($current_page > 1 && $current_page == $num_of_pages)
															{
																//we are at the last page
																//show only left chevron
																$prev = $current_page-1;
																echo "<a class='fa fa-chevron-left' href='?searchPage=".$prev."&searchValue=".$searchedBeer."'></a>&nbsp;&nbsp;".$current_page;
															}
															else
															{
																//we are not at the first, nor the last, lets show both chevrons
																$next = $current_page+1;
																$prev = $current_page-1;
																echo "<a class='fa fa-chevron-left' href='?searchPage=".$prev."&searchValue=".$searchedBeer."'></a>&nbsp;&nbsp;".$current_page."&nbsp;&nbsp;<a class='fa fa-chevron-right' href='?searchPage=".$next."&searchValue=".$searchedBeer."'></a>";
															}
															
														}

														if(!$searchResult)
														{
															echo "<h3>No results for '".$searchedBeer."'!</h3>";
														}
														else
														{
															
															foreach($searchResult as $beer)
															{
																$beerName = $beer['USERS_BEER_NAME'];
																$breweryName = $beer['USERS_BREWERY_NAME'];
																$vintage = $beer['USERS_BEER_VINTAGE'];
																$beerID = $beer['USERS_UNIQUE_BEER_ID'];
																echo "<tr>
																		<td class='centering'>$beerName</td>
																		<td class='centering'>$breweryName</td>";
																echo "<td class='centering'>$vintage</td><td class='centering'><form action='scripts/removebeer.php' method='post'><button type='submit' class='btn btn-sm btn-success' value='$beerID' name='searchRemoval'>View</button></form></td></tr>";
															}	
														}
													}
												?>
                                               
                                            </tbody>
                                        </table>
                                        <?php
											//provide the user a way to exit the search they just did
											if(isset($_POST['search']))
											{
												echo "<a href='cellar.php' type='button' class='btn btn-outline btn-primary'>Close</a>";
											}
										
										?>
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
		$("#cellar").addClass("selected");
		
	</script>

</body>

</html>
