<?php

//profile.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if(isset($_POST['edit_admin']))
{

	$formdata = array();

	if(empty($_POST['admin_email']))
	{
		$error .= '<li>Email Address is required</li>';
	}
	else
	{
		if(!filter_var($_POST["admin_email"], FILTER_VALIDATE_EMAIL))
		{
			$error .= '<li>Invalid Email Address</li>';
		}
		else
		{
			$formdata['admin_email'] = $_POST['admin_email'];
		}
	}

	if(empty($_POST['admin_password']))
	{
		$error .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['admin_password'] = $_POST['admin_password'];
	}

	if($error == '')
	{
		$admin_id = $_SESSION['admin_id'];

		$data = array(
			':admin_email'		=>	$formdata['admin_email'],
			':admin_password'	=>	$formdata['admin_password'],
			':admin_id'			=>	$admin_id
		);

		$query = "
		UPDATE lms_admin 
            SET admin_email = :admin_email,
            admin_password = :admin_password 
            WHERE admin_id = :admin_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		$message = 'User Data Edited';
	}
}

$query = "
	SELECT * FROM lms_admin 
    WHERE admin_id = '".$_SESSION["admin_id"]."'
";

$result = $connect->query($query);


include '../header.php';

?>

<div class="container-fluid px-4">
	<h1 class="mt-4">Profile</h1>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Profile</a></li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			<?php 

			if($error != '')
			{
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if($message != '')
			{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$message.' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			?>
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-edit"></i> Edit Profile Details
				</div>
				<div class="card-body">

				<?php 

				foreach($result as $row)
				{
				?>

					<form method="post">
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="text" name="admin_email" id="admin_email" class="form-control" value="<?php echo $row['admin_email']; ?>" />
						</div>
						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" name="admin_password" id="admin_password" class="form-control" value="<?php echo $row['admin_password']; ?>" />
						</div>
						<div class="mt-4 mb-0">
							<input type="submit" name="edit_admin" class="btn btn-primary" value="Edit" />
						</div>
					</form>

				<?php 
				}

				?>

				</div>
			</div>

		</div>
	</div>
</div>

<?php 

include '../footer.php';

?>