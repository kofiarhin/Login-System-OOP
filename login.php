<?php 	

		require_once "core/init.php";

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>	Login Page</title>
</head>
<body>
	

	<?php 	

			if(input::exist()) {

				$user = new User;

				$remember = (input::get('remember') === 'on') ? true : false;


				$login = $user->login(input::get('username'), input::get('password'), $remember);



				if($login) {
					
					redirect::to('index.php');
				} else {

					echo "please check details and try again";
				}




			}

	 ?>

	 <form action='' method='post'>
	 	<input type='text' name='username' placeholder='Username'>
	 	<input type='password' name='password' placeholder='Password'>
	 	<label for='remember'><input type='checkbox' name='remember' id='remember'>Remember</label>
	 	<button type='submit' name='submit'>Login</button>
	 </form>
</body>
</html>