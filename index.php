<?php 
	
	require_once "core/init.php";

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Practice 4</title>
</head>
<body>

	<?php 

		

		if(session::exist('home')) {

			echo session::flash('home');

		}



		$user  = new User;


		if($user->logged_in()) {

			echo "Welcome ".$user->data()->username;

			echo "<ul>
						
						<li><a href='logout.php'>Logout</a></li>

			</ul>";
		} else {

			echo "You need to <a href='login.php'>Login<a> or <a href='register.php'>Register</a>";
		}



	 ?>



	
</body>
</html>