
<?php
session_start();
include('scripts/connect.php');
if($_SESSION['USER']['role'] == "admin")
{
	header('location: admin.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cellarmate</title>
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
		.actionMove{
			margin-top: -120%;
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
							if(isset($_SESSION['USER']))
							{
								include('scripts/userimagesection.php');
							}
						?>
                        <!--end user image section-->
                    </li>
                    <li class="sidebar-search"></li>
                        <!-- search section-->
                        
  
                        <!--end search section-->
                   
                    <?php
						if(isset($_SESSION['USER']))
						{
							include('scripts/nav.html');
						}
						else
						{
							echo "<li class='selected'>
								<a href='login.php'><i class='fa fa-user'></i> Log In</a>
							</li>";
						}
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
                    	Cellarmate - <span class='h2'>Beer Inventory System</span>
                    </h1>
                </div>
                <!--End Page Header -->
            </div>

            <div class="row">
                <!-- Welcome -->
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        
                        <?php 
							if(isset($_SESSION['USER']))
							{
								$fullname = $_SESSION['USER']['firstName']." ".$_SESSION['USER']['lastName'];
								echo "<i class='fa fa-folder-open'></i><b>&nbsp;Hello ! </b>Welcome Back <b>$fullname</b>";
								//echo $_SESSION['USER']['firstName']." ".$_SESSION['USER']['lastName']; 
							}
							else
							{
								echo "<b>Better beer tracking through barcodes<b>";
							}
						?> </b>
 						<!--<i class="fa  fa-pencil"></i>-->
                    </div>
                </div>
                <!--end  Welcome -->
            </div>


            <div class="row">
                <div class="col-lg-8">



                   
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3><i class="fa fa-bar-chart-o fa-fw"></i> Most Recently Added Beers</h3>
                            <div class="pull-right">
                                
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Beer Name</th>
                                                    <th>Brewery</th>
                                                    <th>Time</th>
                                                    <th>Username</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               	<?php
													//lets get the distinct beers from the database
												//MOST RECENTLY ADDED BEERS
													$query = $db->query("SELECT ub.USERS_BEER_NAME
																		, ub.USERS_BREWERY_NAME
																		, ub.USERS_CHECK_IN_DATE
																		, u.USER_USERNAME
																		, u.USER_CELLAR_VISIBLE 
																		FROM users_beer ub 
																		JOIN user u ON u.USER_ID = ub.USERS_BEER_USER_ID 
																		GROUP BY ub.USERS_CHECK_IN_DATE 
																		ORDER BY max(ub.USERS_CHECK_IN_DATE) desc LIMIT 10;");
													$query->setFetchMode(PDO::FETCH_ASSOC);

													$beerResult = $query->fetchAll();
												
													
												
													foreach($beerResult as $beer)
													{
														$beerName = $beer['USERS_BEER_NAME'];
														$breweryName = $beer['USERS_BREWERY_NAME'];
														$timestamp = $beer['USERS_CHECK_IN_DATE'];
														
														$dateTimeArray = explode(" ",$timestamp);
														$date = $dateTimeArray[0];
														$time = $dateTimeArray[1];
														
														$formattedDate = date('m-d-Y',strtotime($date));
														$formattedTime = date('G:i:s', strtotime($time));
														if($beer['USER_CELLAR_VISIBLE'] == 1)
														{
															$username = $beer['USER_USERNAME'];
														}
														else
														{
															$username - "Private User";
														}
														//$vintage = $beer['USERS_BEER_VINTAGE'];
														echo "<tr>
																<td>$beerName</td>
																<td>$breweryName</td>
																<td>$formattedDate - $formattedTime</td>
																<td>$username</td>
															  </tr>";
																
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

                <div class="col-lg-4">
                	<?php
						include('scripts/allcellarcount.php');
					?>
    		    </div>

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

</body>

</html>
