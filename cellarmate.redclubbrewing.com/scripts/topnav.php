<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="images/cellarmatelogo.png" alt="Cellarmate">
                </a>
                
            </div>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- main dropdown -->
                <a class="btn btn-info btn-sm" href="about.php">About Cellarmate</a>
                <a class="btn btn-info btn-sm" href="faq.php">FAQ</a>
				<?php
						if(!isset($_SESSION['USER']))
						{
							//there is no current logged in user
							echo "<a class='btn btn-success' href='registration.php'>Register</a> ";
						}
				?>
                <li class="dropdown">
                   
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      	
                   		<i class='fa fa-user fa-3x'></i>
                   		
                    </a>
                    <!-- dropdown user-->
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                        	
							<?php
								if(isset($_SESSION['USER']))
								{
									echo "<a href='userprofile.php'><i class='fa fa-user fa-fw'></i>User Profile</a>";
								}
							?>
                        </li>
<!--
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i>Settings</a>
                        </li>
-->
                        <li class="divider"></li>
                        <li>
                        	<?php
								if(isset($_SESSION['USER']))
								{
									echo "<a href='scripts/logout.php'><i class='fa fa-sign-out fa-fw'></i>Logout</a>";
								}
								else
								{
									echo "<a href='login.php'><i class='fa fa-sign-in fa-fw'></i>Login</a>";
								}
							
							?>
                        </li>
                    </ul>
                    <!-- end dropdown-user -->
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->

        </nav>