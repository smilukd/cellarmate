
<?php

include('scripts/connect.php');
session_start();
unset($_SESSION['insertedBeer']);
unset($_SESSION['aboutToRemove']);
unset($_SESSION['removal']);
unset($_SESSION['brewery']);


if($_SESSION['USER']['role'] == "admin")
{
	header('location: admin.php');
}
elseif($_SESSION['USER']['role'] == "user")
{
	$id = $_SESSION['USER']['id'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cellarmate - FAQ</title>
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
		.bold{
			font-weight: bold;
		}
		<?php if(!isset($_SESSION['USER']))
		{
			echo "#wrapper{
					margin-top: 0px!important;
				}";	
		}
		?>
		
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
                   	
                    <?php
							if(isset($_SESSION['USER']))
						{
							include('scripts/searchbar.php');
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
                    	<?php
								//USER CELLAR NAME
								if(isset($_SESSION['USER']))
								{
									$cellar = $_SESSION['USER']['cellarName'];
									echo $cellar;
								}
								
							?> 
                    </h1>
                </div>
                <!--End Page Header -->
            </div>

            <div class="row">
                <!-- Welcome -->
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-folder-open"></i><b>&nbsp;Hello! </b><?php if(isset($_SESSION['USER']))
																				{
																					echo "<b>$fullname</b>";
																				}
																				else
																				{
																					echo "Welcome to Cellarmate!";
																				}
																				?>
 						<!--<i class="fa  fa-pencil"></i>-->
                    </div>
                </div>
                <!--end  Welcome -->
            </div>

            <div class="row">
                <div class="col-lg-8">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3><i class="fa fa-bar-chart-o fa-fw"></i> About Cellarmate</h3>
                            <div class="pull-right">
                                <div class="btn-group actionMove">
                                    <?php
										if(isset($_SESSION['USER']))
										{
											include('scripts/actionbutton.html');
										}
										
									
									?>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
									<h3><i><strong>Better beer tracking through barcodes</strong></i></h3>
										<br>

										<div class="col-lg-11 col-sm-11">
											<ul>
												<li>
													<label>What if I don't have a barcode scanner?</label>
													<p>You can simply type the UPC (barcode) number in. Remember to include the numbers on the outer edges of the barcode!</p>
												</li>
												<li>
													<label>What if I have multiple beers with the same barcode?</label>
													<p>That happens often. Seasonal release beers often have the same barcode information as other seasonal releases from the same brewery. Cellarmate will display all of the beers found with that barcode then you can select the proper beer and enter it into your cellar. If the proper beer is not found, you can add that beer's data and it will be associated with that barcode in your cellar.</p>
												</li>
												<li>
													<label>What if my beer has no barcode?</label>
													<p>Not all beers have barcodes. Some taproom only releases do not have barcodes because they were neer intended for retail sales. You have quite a special beer there! Another case is that the beer you want to enter is a homebrew. In either case, select the "No Barcode" option, and then fill out the data about the beer. It wil then be entered into your cellar.</p>
												</li>
												<li>
													<label>What if the beer I have was not in the list of beers to choose from?</label>
													<p>You can select the "Not Listed" option and enter the data about the beer and it will be added to your cellar and associated with the barcode you scanned.</p>
												</li>
											</ul>
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
					if(isset($_SESSION['user']))
					{
						include('scripts/usercellarcount.php');
					}
					else
					{
						include('scripts/allcellarcount.php');
					}
					
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
    <script>
		$("#cellar").addClass("selected");
		
	</script>

</body>

</html>
