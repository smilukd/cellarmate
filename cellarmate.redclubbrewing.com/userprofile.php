
<!-- edit this page so that if the page was acessed by admin sending over the userID to edit via $_POST, it brings up that data-->
<!--maybe with a $_SESSION['USER']['role'] = "admin" && isset($_POST['editUser']) -->
<!--where that POST value contains the userID to display.-->






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
session_start();
include('scripts/connect.php');
//prevent unauthoized access to the page
if(!isset($_SESSION['USER']))
{
	header('location: login.php');
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cellarmate - User Profile</title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
		form input{
			margin-bottom: 2%;
		}
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
							include('scripts/userimagesection.php');
						?>
                        <!--end user image section-->
                    </li>
                    <li class="sidebar-search">
                        <!-- search section-->
                        
  
                        <!--end search section-->
                    </li>
                    <?php
							
							if($_SESSION['USER']['role'] == "admin")
							{
								include('scripts/navAdmin.html');								
							}
							elseif($_SESSION['USER']['role'] == "user")
							{
								include('scripts/nav.html');
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
							if($_SESSION['USER']['role'] == "admin")
							{
								echo "Admin User Update";
							}
							else 
							{
								echo "User Profile Update";
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
                        <i class="fa fa-folder-open"></i><b>&nbsp;Hello ! </b>Welcome Back <b>
                        <?php 
							if(isset($_SESSION['USER']))
							{
								echo $_SESSION['USER']['firstName']." ".$_SESSION['USER']['lastName']; 
							}
						?> </b>
 						<!--<i class="fa  fa-pencil"></i>-->
                    </div>
                </div>
                <!--end  Welcome -->
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <!--End area chart example -->
                    <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           <?php
							if(isset($_POST['editUser']))
							{
								echo "<h3><i class='fa fa-bar-chart-o fa-fw'></i> ADMIN User Profile Editor</h3>";
							}
							else
							{
								echo "<h3><i class='fa fa-bar-chart-o fa-fw'></i> Your User Profile</h3>";
							}
                            ?>
                            <div class="pull-right">
                                <div class="btn-group actionMove">
                                    <?php
										if($_SESSION['USER']['role'] != "admin")
										{
											include('scripts/actionbutton.html');
										}
										
									
									?>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                   <h2>User Profile</h2>
                                   <?php 
									if(isset($_GET['result']))
									{
										//successful update of user data
										if($_GET['result'] == "successful")
										{
											echo "<h2 class='green'>Update Successful</h2>";
										}
										else
										{
											echo "<h2 class='red'>Update Failed!</h2>";
										}
									}
									?>
                                   <?php
										if(!isset($_POST['editUser']))
										{
											//retrieve the logged in user data from the database
											$userId = $_SESSION['USER']['id'];
										
										}
										else
										{
											//retrieve the user data from the $_POST from the admin page
											$userId = $_POST['editUser'];
										}
									   $query = $db->prepare("SELECT USER_USERNAME, USER_FIRST_NAME, USER_LAST_NAME, USER_EMAIL, USER_LOCATION, USER_CELLAR_NAME, USER_CELLAR_VISIBLE, USER_PROFILE_PICTURE FROM user WHERE USER_ID = ?;");
										$query->execute(array($userId));
										$query->setFetchMode(PDO::FETCH_ASSOC);

										$user = $query->fetch();
										
									
									?>
                                   	<div class="col-lg-12">
										<form action="scripts/updateuser.php" method="post" enctype="multipart/form-data">
											<label class="form-inline">First Name </label><input class="form-control" id="firstName" type="text" name="firstName" value="<?php echo $user['USER_FIRST_NAME']; ?>" required> 
											<label class="form-inline">Last Name </label><input class="form-control" id="lastName" type="text" name="lastName" value="<?php echo $user['USER_LAST_NAME']; ?>" required>
											<label class="form-inline">Email </label><input class="form-control" id="email" type="text" name="email" value="<?php echo $user['USER_EMAIL']; ?>" required> 
											<label class="form-inline">Verify Email </label><input class="form-control" id="emailVer" type="text" name="emailVer" placeholder="Retype Email Address" onfocusout="checkEmail()" required>
											<div class="red" id="noEMatch"></div>
											<label class="form-inline">Location </label><input class="form-control" id="location" type="text" name="location"value="<?php echo $user['USER_LOCATION']; ?>">
											<label class="form-inline">Cellar Name </label><input class="form-control" id="cellarName" type="text" name="cellarName" value="<?php echo $user['USER_CELLAR_NAME']; ?>" required>
											<span class="row">
											<?php
												//show the user the whether or not their cellar is currently visible
												if($user['USER_CELLAR_VISIBLE'] == 1)
												{
													echo"<strong>Make cellar visible to others users?</strong>
														<label>Yes </label><input id='publicYes' type='radio' name='public' value='yes' checked>
														<label>No </label><input id='publicNo' type='radio' name='public' value='no' >";
												}
												else{
													echo"<strong>Make cellar visible to others users?</strong>
														<label>Yes </label><input id='publicYes' type='radio' name='public' value='yes' >
														<label>No </label><input id='publicNo' type='radio' name='public' value='no' checked>";
												}
											?>
											</span>
											<br>
						<!--					check that the username does not exist before registration-->
											<label class="form-inline">Username </label><input class="form-control" id="username" type="text" name="username" placeholder="<?php echo $user['USER_USERNAME']; ?>" value="<?php echo $user['USER_USERNAME']; ?>" onfocusout="checkUser()" onKeyDown="$('#userCheck').val("")"><label class="userResult" id="userCheck"></label>
										
											<!--<label class="form-inline">Password </label>
											<input class="form-control" id="password" type="password" name="password" placeholder="Password" required> 
											<label class="form-inline">Verify Password </label>
											<input class="form-control" id="passwordVer" type="password" name="passwordVer" placeholder="Retype Password" onfocusout="checkPass()" required>
											-->
											<div class="red" id="noPWMatch"></div>
											<br><br>
											<img src="userImages/<?php echo $user['USER_PROFILE_PICTURE']; ?>" alt="No Image Selected" width='100px'>
											<br>
											<br>
											<label>Upload a new profile picture <input type="file" name="file" id="file"></label>
											<br>
											<br>
											<button class="btn btn-success" type="submit" value="<?php echo $userId; ?>" name="submitRegistration">Update Profile</button>

										</form>
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
						$id = $_SESSION['USER']['id'];
						if($_SESSION['USER']['role'] == "admin")
						{
							echo "<div class='col-lg-4'>";
							include('scripts/allcellarcount.php');
							echo "</div>";
						}
						else
						{
							include('scripts/usercellarcount.php');
						}
						
						
					?>

                

            </div>

        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->

    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/scripts/dashboard-demo.js"></script>
<!--    <script src="assets/plugins/jquery-1.10.2.js"></script>-->
	<script>
		function checkUser()
		{
			var originalUsername = $('#username').attr('placeholder');
			var username = $('#username').val();
			//check to make sure the username is available.
			if(originalUsername != username)	//check to make sure that the username has actuall changed before checking whether it exists
				{
					$.ajax({
							type: "POST",
							url: "scripts/usercheck.php",
							data: {user: username},
							cache: false,					
							success: function(html)
							{
								var currentUserName = $('#username').val();

								$("#userCheck").html(html);

								var result = $('#userCheck').html();

								//username exists, have user input a new one
								if(!result.includes("OK"))
								{

									$('#username').val("");
									/*$("#userCheck").removeClass("green");
									$("#userCheck").addClass("red");*/
									//$("#userCheck").html(currentUserName + " already exists, choose another" );
								}
								else
									{
										//$("#userCheck").removeClass("red");
										//$("#userCheck").addClass("green");
										$("#userCheck").html(html);
									}

							}
						});
				}
		}
		
		function checkPass(){
			
			//check to see if the passwords match
			var pass1 = $('#password').val();
			var pass2 = $('#passwordVer').val();
			
			if(pass1 != pass2)
			{
				//passwords do not match
				$('#passwordVer').val("");
				$('#noPWMatch').html("Passwords do not match!");
			}
		}
		
		function checkEmail()
		{
			var email1 = $('#email').val();
			var email2 = $('#emailVer').val();
			
			if(email1 != email2)
			{
				//emails do not match
				$('#emailVer').val("");
				$('#noEMatch').html("Emails do not match!");
			}
		}
	</script>
</body>

</html>
