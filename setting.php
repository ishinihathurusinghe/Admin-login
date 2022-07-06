<?php

//setting.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

if(isset($_POST['edit_setting']))
{
	$data = array(
		':library_name'					=>	$_POST['library_name'],
		':library_address'				=>	$_POST['library_address'],
		':library_contact_number'		=>	$_POST['library_contact_number'],
		':library_email_address'		=>	$_POST['library_email_address'],
		':library_total_book_issue_day'	=>	$_POST['library_total_book_issue_day'],
		':library_one_day_fine'			=>	$_POST['library_one_day_fine'],
		':library_currency'				=>	$_POST['library_currency'],
		':library_timezone'				=>	$_POST['library_timezone'],
		':library_issue_total_book_per_user'	=>	$_POST['library_issue_total_book_per_user']
	);

	$query = "
	UPDATE lms_setting 
        SET library_name = :library_name,
        library_address = :library_address, 
        library_contact_number = :library_contact_number, 
        library_email_address = :library_email_address, 
        library_total_book_issue_day = :library_total_book_issue_day, 
        library_one_day_fine = :library_one_day_fine, 
        library_currency = :library_currency, 
        library_timezone = :library_timezone, 
        library_issue_total_book_per_user = :library_issue_total_book_per_user
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	$message = '
	<div class="alert alert-success alert-dismissible fade show" role="alert">Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
	';
}

$query = "
SELECT * FROM lms_setting 
LIMIT 1
";

$result = $connect->query($query);

include '../header.php';

?>

<div class="container-fluid px-4">
	<h1 class="mt-4">Setting</h1>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Setting</a></li>
	</ol>
	<?php 

	if($message != '')	
	{
		echo $message;
	}

	?>
	<div class="card mb-4">
		<div class="card-header">
			<i class="fas fa-user-edit"></i> Library Setting
		</div>
		<div class="card-body">

			<form method="post">
				<?php 
				foreach($result as $row)
				{
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Library Name</label>
							<input type="text" name="library_name" id="library_name" class="form-control" value="<?php echo $row['library_name']; ?>" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Address</label>
							<textarea name="library_address" id="library_address" class="form-control"><?php echo $row["library_address"]; ?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Contact Number</label>
							<input type="text" name="library_contact_number" id="library_contact_number" class="form-control" value="<?php echo $row['library_contact_number']; ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="text" name="library_email_address" id="library_email_address" class="form-control" value="<?php echo $row['library_email_address']; ?>" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Book Return Day Limit</label>
							<input type="number" name="library_total_book_issue_day" id="library_total_book_issue_day" class="form-control" value="<?php echo $row['library_total_book_issue_day']; ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Book Late Return One Day Fine</label>
							<input type="number" name="library_one_day_fine" id="library_one_day_fine" class="form-control" value="<?php echo $row['library_one_day_fine']; ?>" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Currency</label>
							<select name="library_currency" id="library_currency" class="form-control">
								<?php echo Currency_list(); ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Timezone</label>
							<select name="library_timezone" id="library_timezone" class="form-control">
								<?php echo Timezone_list(); ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="form-label">Per User Book Issue Limit</label>
						<input type="number" name="library_issue_total_book_per_user" id="library_issue_total_book_per_user" class="form-control" value="<?php echo $row['library_issue_total_book_per_user']; ?>" />
					</div>
				</div>
				<div class="mt-4 mb-0">
					<input type="submit" name="edit_setting" class="btn btn-primary" value="Save" />
				</div>
				<script type="text/javascript">

				document.getElementById('library_currency').value = "<?php echo $row['library_currency']; ?>";

				document.getElementById('library_timezone').value="<?php echo $row['library_timezone']; ?>"; 

				</script>
				<?php 
				}
				?>
			</form>

		</div>
	</div>
</div>

<?php 

include '../footer.php';

?>