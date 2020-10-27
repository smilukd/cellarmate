<div class="user-section">
	<div class="user-section-inner">
<!--                               User image from database-->
	  <?php 
		if(isset($_SESSION['USER']))
		{
			if(!is_null($_SESSION['USER']['image'])){
				//echo $_SESSION['USER']['image'];
			echo "<img src='userImages/".$_SESSION['USER']['image']."' alt='User Profile Image'>";
			}

		}
		?>

	</div>
	<div class="user-info squeeze">
		<div>
		<?php 
			if(isset($_SESSION['USER']))
			{
				//display user icon, username, and online status
				$fullname = ucfirst($_SESSION['USER']['firstName']." ".$_SESSION['USER']['lastName']);
				$username = $_SESSION['USER']['username'];
				echo $username;
				


				echo "</div>
				<div class='user-text-online'>
					<span class='user-circle-online btn btn-success btn-circle '></span>&nbsp;Online
				</div>";
			}
				?>
	</div>
</div>