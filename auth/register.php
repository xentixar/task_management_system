<?php require '../connection/database.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register | Task Management System</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

	<div class="container" style="height: 100vh;display: flex;align-items: center;justify-content: center;">
		<div style="width: 500px;">
			<?php 
			if(isset($_POST['register']))
			{
				$name = $_POST['name'] ?? '';
				$email = $_POST['email'] ?? '';
				$password = $_POST['password'] ?? '';
				$confirm_password = $_POST['confirm_password'] ?? '';

				if($name!="" && $email!="" && $password!="" && $confirm_password!="")
				{
					if($password === $confirm_password)
					{
						$check_existing_email_query = "SELECT * FROM users WHERE email='$email'";
						$check_existing_email_query_result = $conn->query($check_existing_email_query);
						if($check_existing_email_query_result->num_rows === 0)
						{
							$password = password_hash($password, PASSWORD_BCRYPT);
							$insert_user_query = "INSERT INTO users(name,email,password) VALUES('$name','$email','$password')";
							$insert_user_query_result = $conn->query($insert_user_query);
							if($insert_user_query_result)
							{
								header('Location:login.php?msg=registered successfully');
							}else{
								?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
									  <strong>Registration failed. Please try again.</strong>
									  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								<?php
							}
						}else{
							?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
								  <strong>Email already exists.</strong>
								  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							<?php
						}
					}else{
						?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <strong>Password don't match.</strong>
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
					<label class="form-label" for="name">Name <b>*</b></label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter your name...">
				</div>
				<div class="form-group mb-3">
					<label class="form-label" for="email">Email <b>*</b></label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email...">
				</div>
				<div class="form-group mb-3">
					<label class="form-label" for="password">Password <b>*</b></label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password...">
				</div>
				<div class="form-group mb-3">
					<label class="form-label" for="confirm_password">Confirm Password <b>*</b></label>
					<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm your password...">
				</div>
				<button class="btn btn-primary" type="submit" name="register">Register</button>

				<div class="my-3 text-center">
					<strong>Already registered?</strong> <a href="login.php">Login</a>
				</div>
			</form>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>