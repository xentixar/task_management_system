<?php require '../connection/database.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Task Management System</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

	<div class="container" style="height: 100vh;display: flex;align-items: center;justify-content: center;">
		<div style="width: 500px;">
			<?php 
			if(isset($_POST['login']))
			{
				$email = $_POST['email'] ?? '';
				$password = $_POST['password'] ?? '';

				if($email!="" && $password!="")
				{
					$select_user_query = "SELECT * FROM users WHERE email='$email'";
					$select_user_query_result = $conn->query($select_user_query);
					if($select_user_query_result->num_rows===1)
					{
						$user = mysqli_fetch_assoc($select_user_query_result);
						if(password_verify($password, $user['password']))
						{
							session_start();
							$_SESSION['user']['id'] = $user['id'];
							$_SESSION['user']['name'] = $user['name'];
							$_SESSION['user']['email'] = $user['email'];
							header('Location:../admin/dashboard.php');
						}else{
							?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
								  <strong>Invalid credentials.</strong>
								  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							<?php
						}
					}else{
						?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <strong>Invalid credentials.</strong>
							  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php
					}
				}else{
					?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <strong>All fields are required.</strong>
						  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php
				}
			}
			?>
			<form action="#" method="POST" >
				<div class="form-group mb-3">
					<label class="form-label" for="email">Email <b>*</b></label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email...">
				</div>
				<div class="form-group mb-3">
					<label class="form-label" for="password">Password <b>*</b></label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password...">
				</div>
				<button class="btn btn-primary" type="submit" name="login">Login</button>
				<div class="my-3 text-center">
					<strong>Don't have an account?</strong> <a href="register.php">Register</a>
				</div>
			</form>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>