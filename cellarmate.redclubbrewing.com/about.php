
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
    <title>Cellarmate - About Us</title>
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
								if(isset($_SESSION['USER']))
								{
									//USER CELLAR NAME
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
											<h4 class="bold">Why does keeping track of the beer in your cellar have to be so hard?</h4>
											<div class="offset-lg-1 offset-sm-1 colg-g-10 col-sm-10">
												<p>Frankly, it doesn't. On almost every beer you own there is an under two square inch area that holds all the information you would ever want. The UPC barcode!</p>
												<p>This trove of information allows you to simply scan each beer's barcode and add, edit, or remove it from your cellar. Keeping track of your beers should be fun and easy!</p>
											</div>
										</div>
										<div class="col-lg-11 col-sm-11">
											<h4 class="bold">Cellarmate.com was started as a college final project</h4>
											<div class="offset-lg-1 offset-sm-1 colg-g-10 col-sm-10">
												<p>It was the idea of Luke Smith, a student at Dunwoody College of Technology in Minneapolis, MN. </p>
												<p>Luke had a sizable beer cellar that had no form of inventory control. He had tried the normal methods of keeping track of the bottles on the shelves in his basement cellar.
												Lists on paper, spreadsheets, hanging tags around the necks of bottles, but nothing made it easier to know what he has or what he used to have.</p>
												<p>Once day while purchasing some beer at the local liquor store, it dawned on him, why not use the barcode on the bottles to keep track his collection, in a similar way to 
												how the check out register did at the store? This project was in the back of his mind when he enrolled in Dunwoody, and when the opportunity to create a final project that was a 
												full-stack website, it only made sense that Cellarmate should be his project.</p>
											</div>
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
