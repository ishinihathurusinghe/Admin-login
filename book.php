<?php

//book.php

include '../database_connection.php';

include '../function.php';


if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if(isset($_POST["add_book"]))
{
	$formdata = array();

	if(empty($_POST["book_name"]))
	{
		$error .= '<li>Book Name is required</li>';
	}
	else
	{
		$formdata['book_name'] = trim($_POST["book_name"]);
	}

	if(empty($_POST["book_category"]))
	{
		$error .= '<li>Book Category is required</li>';
	}
	else
	{
		$formdata['book_category'] = trim($_POST["book_category"]);
	}

	if(empty($_POST["book_author"]))
	{
		$error .= '<li>Book Author is required</li>';
	}
	else
	{
		$formdata['book_author'] = trim($_POST["book_author"]);
	}

	if(empty($_POST["book_location_rack"]))
	{
		$error .= '<li>Book Location Rack is required</li>';
	}
	else
	{
		$formdata['book_location_rack'] = trim($_POST["book_location_rack"]);
	}

	if(empty($_POST["book_isbn_number"]))
	{
		$error .= '<li>Book ISBN Number is required</li>';
	}
	else
	{
		$formdata['book_isbn_number'] = trim($_POST["book_isbn_number"]);
	}
	if(empty($_POST["book_no_of_copy"]))
	{
		$error .= '<li>Book No. of Copy is required</li>';
	}
	else
	{
		$formdata['book_no_of_copy'] = trim($_POST["book_no_of_copy"]);
	}

	if($error == '')
	{
		$data = array(
			':book_category'		=>	$formdata['book_category'],
			':book_author'			=>	$formdata['book_author'],
			':book_location_rack'	=>	$formdata['book_location_rack'],
			':book_name'			=>	$formdata['book_name'],
			':book_isbn_number'		=>	$formdata['book_isbn_number'],
			':book_no_of_copy'		=>	$formdata['book_no_of_copy'],
			':book_status'			=>	'Enable',
			':book_added_on'		=>	get_date_time($connect)
		);

		$query = "
		INSERT INTO lms_book 
        (book_category, book_author, book_location_rack, book_name, book_isbn_number, book_no_of_copy, book_status, book_added_on) 
        VALUES (:book_category, :book_author, :book_location_rack, :book_name, :book_isbn_number, :book_no_of_copy, :book_status, :book_added_on)
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:book.php?msg=add');
	}
}

if(isset($_POST["edit_book"]))
{
	$formdata = array();

	if(empty($_POST["book_name"]))
	{
		$error .= '<li>Book Name is required</li>';
	}
	else
	{
		$formdata['book_name'] = trim($_POST["book_name"]);
	}

	if(empty($_POST["book_category"]))
	{
		$error .= '<li>Book Category is required</li>';
	}
	else
	{
		$formdata['book_category'] = trim($_POST["book_category"]);
	}

	if(empty($_POST["book_author"]))
	{
		$error .= '<li>Book Author is required</li>';
	}
	else
	{
		$formdata['book_author'] = trim($_POST["book_author"]);
	}

	if(empty($_POST["book_location_rack"]))
	{
		$error .= '<li>Book Location Rack is required</li>';
	}
	else
	{
		$formdata['book_location_rack'] = trim($_POST["book_location_rack"]);
	}

	if(empty($_POST["book_isbn_number"]))
	{
		$error .= '<li>Book ISBN Number is required</li>';
	}
	else
	{
		$formdata['book_isbn_number'] = trim($_POST["book_isbn_number"]);
	}
	if(empty($_POST["book_no_of_copy"]))
	{
		$error .= '<li>Book No. of Copy is required</li>';
	}
	else
	{
		$formdata['book_no_of_copy'] = trim($_POST["book_no_of_copy"]);
	}

	if($error == '')
	{
		$data = array(
			':book_category'		=>	$formdata['book_category'],
			':book_author'			=>	$formdata['book_author'],
			':book_location_rack'	=>	$formdata['book_location_rack'],
			':book_name'			=>	$formdata['book_name'],
			':book_isbn_number'		=>	$formdata['book_isbn_number'],
			':book_no_of_copy'		=>	$formdata['book_no_of_copy'],
			':book_updated_on'		=>	get_date_time($connect),
			':book_id'				=>	$_POST["book_id"]
		);
		$query = "
		UPDATE lms_book 
        SET book_category = :book_category, 
        book_author = :book_author, 
        book_location_rack = :book_location_rack, 
        book_name = :book_name, 
        book_isbn_number = :book_isbn_number, 
        book_no_of_copy = :book_no_of_copy, 
        book_updated_on = :book_updated_on 
        WHERE book_id = :book_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:book.php?msg=edit');
	}
}

if(isset($_GET["action"], $_GET["code"], $_GET["status"]) && $_GET["action"] == 'delete')
{
	$book_id = $_GET["code"];
	$status = $_GET["status"];

	$data = array(
		':book_status'		=>	$status,
		':book_updated_on'	=>	get_date_time($connect),
		':book_id'			=>	$book_id
	);

	$query = "
	UPDATE lms_book 
    SET book_status = :book_status, 
    book_updated_on = :book_updated_on 
    WHERE book_id = :book_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:book.php?msg='.strtolower($status).'');
}


$query = "
	SELECT * FROM lms_book 
    ORDER BY book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();


include '../header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Book Management</h1>
	<?php 
	if(isset($_GET["action"]))
	{
		if($_GET["action"] == 'add')
		{
	?>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="book.php">Book Management</a></li>
        <li class="breadcrumb-item active">Add Book</li>
    </ol>

    <?php 

    if($error != '')
    {
    	echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    ?>

    <div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-user-plus"></i> Add New Book
        </div>
        <div class="card-body">
        	<form method="post">
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Book Name</label>
        					<input type="text" name="book_name" id="book_name" class="form-control" />
        				</div>
        			</div>
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Author</label>
        					<select name="book_author" id="book_author" class="form-control">
        						<?php echo fill_author($connect); ?>
        					</select>
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Category</label>
        					<select name="book_category" id="book_category" class="form-control">
        						<?php echo fill_category($connect); ?>
        					</select>
        				</div>
        			</div>
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Location Rack</label>
        					<select name="book_location_rack" id="book_location_rack" class="form-control">
        						<?php echo fill_location_rack($connect); ?>
        					</select>
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Book ISBN Number</label>
        					<input type="text" name="book_isbn_number" id="book_isbn_number" class="form-control" />
        				</div>
        			</div>
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">No. of Copy</label>
        					<input type="number" name="book_no_of_copy" id="book_no_of_copy" step="1" class="form-control" />
        				</div>
        			</div>
        		</div>
        		<div class="mt-4 mb-3 text-center">
        			<input type="submit" name="add_book" class="btn btn-success" value="Add" />
        		</div>
        	</form>
        </div>
    </div>

	<?php 
		}
		else if($_GET["action"] == 'edit')
		{
			$book_id = convert_data($_GET["code"], 'decrypt');

			if($book_id > 0)
			{
				$query = "
				SELECT * FROM lms_book 
                WHERE book_id = '$book_id'
				";

				$book_result = $connect->query($query);

				foreach($book_result as $book_row)
				{
	?>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="book.php">Book Management</a></li>
        <li class="breadcrumb-item active">Edit Book</li>
    </ol>
    <div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-user-plus"></i> Edit Book Details
       	</div>
       	<div class="card-body">
       		<form method="post">
       			<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Book Name</label>
       						<input type="text" name="book_name" id="book_name" class="form-control" value="<?php echo $book_row['book_name']; ?>" />
       					</div>
       				</div>
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Select Author</label>
       						<select name="book_author" id="book_author" class="form-control">
       							<?php echo fill_author($connect); ?>
       						</select>
       					</div>
       				</div>
       			</div>
       			<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Select Category</label>
       						<select name="book_category" id="book_category" class="form-control">
       							<?php echo fill_category($connect); ?>
       						</select>
       					</div>
       				</div>
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Select Location Rack</label>
       						<select name="book_location_rack" id="book_location_rack" class="form-control">
       							<?php echo fill_location_rack($connect); ?>
       						</select>
       					</div>
       				</div>
       			</div>
       			<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Book ISBN Number</label>
       						<input type="text" name="book_isbn_number" id="book_isbn_number" class="form-control" value="<?php echo $book_row['book_isbn_number']; ?>" />
       					</div>
       				</div>
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">No. of Copy</label>
       						<input type="number" name="book_no_of_copy" id="book_no_of_copy" class="form-control" step="1" value="<?php echo $book_row['book_no_of_copy']; ?>" />
       					</div>
       				</div>
       			</div>
       			<div class="mt-4 mb-3 text-center">
       				<input type="hidden" name="book_id" value="<?php echo $book_row['book_id']; ?>" />
       				<input type="submit" name="edit_book" class="btn btn-primary" value="Edit" />
       			</div>
       		</form>
       		<script>
       			document.getElementById('book_author').value = "<?php echo $book_row['book_author']; ?>";
       			document.getElementById('book_category').value = "<?php echo $book_row['book_category']; ?>";
       			document.getElementById('book_location_rack').value = "<?php echo $book_row['book_location_rack']; ?>";
       		</script>
       	</div>
   	</div>
	<?php
				}
			}
		}
	}
	else
	{	
	?>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Book Management</li>
	</ol>
	<?php 

	if(isset($_GET["msg"]))
	{
		if($_GET["msg"] == 'add')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Book Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET['msg'] == 'edit')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET["msg"] == 'disable')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Status Change to Disable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET['msg'] == 'enable')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Status Change to Enable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
	}

	?>
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Book Management
                </div>
                <div class="col col-md-6" align="right">
                	<a href="book.php?action=add" class="btn btn-success btn-sm">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
        	<table id="datatablesSimple">
        		<thead> 
        			<tr> 
        				<th>Book Name</th>
        				<th>ISBN No.</th>
        				<th>Category</th>
        				<th>Author</th>
        				<th>Location Rack</th>
        				<th>No. of Copy</th>
        				<th>Status</th>
        				<th>Created On</th>
        				<th>Updated On</th>
        				<th>Action</th>
        			</tr>
        		</thead>
        		<tfoot>
        			<tr>
        				<th>Book Name</th>
        				<th>ISBN No.</th>
        				<th>Category</th>
        				<th>Author</th>
        				<th>Location Rack</th>
        				<th>No. of Copy</th>
        				<th>Status</th>
        				<th>Created On</th>
        				<th>Updated On</th>
        				<th>Action</th>
        			</tr>
        		</tfoot>
        		<tbody>
        		<?php 

        		if($statement->rowCount() > 0)
        		{
        			foreach($statement->fetchAll() as $row)
        			{
        				$book_status = '';
        				if($row['book_status'] == 'Enable')
        				{
        					$book_status = '<div class="badge bg-success">Enable</div>';
        				}
        				else
        				{
        					$book_status = '<div class="badge bg-danger">Disable</div>';
        				}
        				echo '
        				<tr>
        					<td>'.$row["book_name"].'</td>
        					<td>'.$row["book_isbn_number"].'</td>
        					<td>'.$row["book_category"].'</td>
        					<td>'.$row["book_author"].'</td>
        					<td>'.$row["book_location_rack"].'</td>
        					<td>'.$row["book_no_of_copy"].'</td>
        					<td>'.$book_status.'</td>
        					<td>'.$row["book_added_on"].'</td>
        					<td>'.$row["book_updated_on"].'</td>
        					<td>
        						<a href="book.php?action=edit&code='.convert_data($row["book_id"]).'" class="btn btn-sm btn-primary">Edit</a>
        						<button type="button" name="delete_button" class="btn btn-danger btn-sm" onclick="delete_data(`'.$row["book_id"].'`, `'.$row["book_status"].'`)">Delete</button>
        					</td>
        				</tr>
        				';
        			}
        		}
        		else
        		{
        			echo '
        			<tr>
        				<td colspan="10" class="text-center">No Data Found</td>
        			</tr>
        			';
        		}

        		?>
        		</tbody>
        	</table>
        </div>
    </div>
    <script>

    	function delete_data(code, status)
    	{
    		var new_status = 'Enable';
    		if(status == 'Enable')
    		{
    			new_status = 'Disable';
    		}

    		if(confirm("Are you sure you want to "+new_status+" this Category?"))
    		{
    			window.location.href = "book.php?action=delete&code="+code+"&status="+new_status+"";
    		}
    	}

    </script>
    <?php 
	}
    ?>
</div>


<?php

include '../footer.php';

?>