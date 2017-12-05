<?php 
	require_once "core/init.php";

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
</head>
<body>
	
	<?php 


		if(input::exist()) {

			//donot forget to do the validation;


			$user  = new User;

			$account = $user->create(array(


				'name' => input::get('name'),
				'username' => input::get('username'),
				'password' => input::get('password'),
				'salt' => 'salt',
				'date' => date('Y-m-d H:i:s')

			));

				if($account) {


					session::flash('home', 'your account was successfully created');

					redirect::to('index.php');
				} else {

					echo "There was a problem creating account";
				}
		}

	 ?>

	 <form action='' method='post'>
	 	<input type='text' name='name' placeholder='Name'>
	 	<input type='text' name='username' placeholder='Username'>
	 	<input type='password' name='password' placeholder='Password'>
	 	<button type='submit' name='submit'>Register</button>
	 </form>
</body>
</html>