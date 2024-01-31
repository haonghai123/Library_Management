<?php

//author.php

include '../database_connection.php';

include '../function.php';

if (!is_admin_login()) {
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if (isset($_POST["add_author"])) {
	$formdata = array();

	if (empty($_POST["author_name"])) {
		$error .= '<li>Phải có tên tác giả</li>';
	} else {
		$formdata['author_name'] = trim($_POST["author_name"]);
	}

	if ($error == '') {
		$query = "
		SELECT * FROM lms_author 
        WHERE author_name = '" . $formdata['author_name'] . "'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if ($statement->rowCount() > 0) {
			$error = '<li>Tên tác giả đã tồn tại</li>';
		} else {
			$data = array(
				':author_name'			=>	$formdata['author_name'],
				':author_status'		=>	'Enable',
				':author_created_on'	=>	get_date_time($connect)
			);

			$query = "
			INSERT INTO lms_author 
            (author_name, author_status, author_created_on) 
            VALUES (:author_name, :author_status, :author_created_on)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:author.php?msg=add');
		}
	}
}

if (isset($_POST["edit_author"])) {
	$formdata = array();

	if (empty($_POST["author_name"])) {
		$error .= '<li>phải có tên tác giả</li>';
	} else {
		$formdata['author_name'] = trim($_POST['author_name']);
	}

	if ($error == '') {
		$author_id = convert_data($_POST['author_id'], 'decrypt');

		$query = "
		SELECT * FROM lms_author 
        WHERE author_name = '" . $formdata['author_name'] . "' 
        AND author_id != '" . $author_id . "'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if ($statement->rowCount() > 0) {
			$error = '<li>Tên tác giả đã tồn tại</li>';
		} else {
			$data = array(
				':author_name'		=>	$formdata['author_name'],
				':author_updated_on' =>	get_date_time($connect),
				':author_id'		=>	$author_id
			);

			$query = "
			UPDATE lms_author 
            SET author_name = :author_name, 
            author_updated_on = :author_updated_on  
            WHERE author_id = :author_id
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:author.php?msg=edit');
		}
	}
}

if (isset($_GET["action"], $_GET["code"], $_GET["status"]) && $_GET["action"] == 'delete') {
	$author_id = $_GET["code"];

	$status = $_GET["status"];

	$data = array(
		':author_status'			=>	$status,
		':author_updated_on'		=>	get_date_time($connect),
		':author_id'				=>	$author_id
	);

	$query = "
	 UPDATE lms_author 
    SET author_status = :author_status, 
    author_updated_on = :author_updated_on 
    WHERE author_id = :author_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:author.php?msg=' . strtolower($status) . '');
}


$query = "
	SELECT * FROM lms_author 
    ORDER BY author_name ASC
";

$statement = $connect->prepare($query);

$statement->execute();

include 'header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Quản lí tác giả</h1>
	<?php

	if (isset($_GET["action"])) {
		if ($_GET["action"] == "add") {
	?>

			<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
				<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="author.php">Quản lí tác giả</a></li>
				<li class="breadcrumb-item active">Thêm tác giả</li>
			</ol>

			<div class="row">
				<div class="col-md-6">
					<?php

					if ($error != '') {
						echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">' . $error . '</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
					}

					?>
					<div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-user-plus"></i> Thêm mới tác giả
						</div>
						<div class="card-body">
							<form method="post">
								<div class="mb-3">
									<label class="form-label">Tên tác giả</label>
									<input type="text" name="author_name" id="author_name" class="form-control" />
								</div>
								<div class="mt-4 mb-0">
									<input type="submit" name="add_author" class="btn btn-success" value="Thêm" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<?php
		} else if ($_GET["action"] == 'edit') {
			$author_id = convert_data($_GET["code"], 'decrypt');

			if ($author_id > 0) {
				$query = "
				SELECT * FROM lms_author 
                WHERE author_id = '$author_id'
				";

				$author_result = $connect->query($query);

				foreach ($author_result as $author_row) {
			?>

					<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="author.php">Quản lí tác giả</a></li>
						<li class="breadcrumb-item active">Chỉnh sửa tác giả</li>
					</ol>

					<div class="row">
						<div class="col-md-6">
							<div class="card mb-4">
								<div class="card-header">
									<i class="fas fa-user-edit"></i> Chỉnh sửa chi tiết tác giả
								</div>
								<div class="card-body">
									<form method="post">
										<div class="mb-3">
											<label class="form-label">Tên tác giả</label>
											<input type="text" name="author_name" id="author_name" class="form-control" value="<?php echo $author_row['author_name']; ?>" />
										</div>
										<div class="mt-4 mb-0">
											<input type="hidden" name="author_id" value="<?php echo $_GET['code']; ?>" />
											<input type="submit" name="edit_author" class="btn btn-primary" value="Chỉnh sửa" />
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

		<?php
				}
			}
		}
	} else {

		?>
		<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
			<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
			<li class="breadcrumb-item active">Quản lí tác giả</li>
		</ol>
		<?php

		if (isset($_GET["msg"])) {
			if ($_GET["msg"] == 'add') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Tác giả mới được thêm vào<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
			if ($_GET['msg'] == 'edit') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Dữ liệu tác giả đã chỉnh sửa <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
			if ($_GET["msg"] == 'disable') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Thay đổi trạng thái tác giả để tắt <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if ($_GET["msg"] == 'enable') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Thay đổi trạng thái tác giả để bật <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
		}

		?>
		<div class="card mb-4">
			<div class="card-header">
				<div class="row">
					<div class="col col-md-6">
						<i class="fas fa-table me-1"></i> Quản lí tác giả
					</div>
					<div class="col col-md-6" align="right">
						<a href="author.php?action=add" class="btn btn-success btn-sm">Thêm</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table id="datatablesSimple">
					<thead>
						<tr>
							<th>Tên tác giả</th>
							<th>Trạng thái</th>
							<th>Được tạo vào</th>
							<th>Cập nhật vào</th>
							<th>Hành động</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Tên tác giả</th>
							<th>Trạng thái</th>
							<th>Được tạo vào</th>
							<th>Cập nhật vào</th>
							<th>Hành động</th>
						</tr>
					</tfoot>
					<tbody>
						<?php
						if ($statement->rowCount() > 0) {
							foreach ($statement->fetchAll() as $row) {
								$author_status = '';
								if ($row['author_status'] == 'Enable') {
									$author_status = '<div class="badge bg-success">Bật</div>';
								} else {
									$author_status = '<div class="badge bg-danger">Tắt</div>';
								}

								echo '
						<tr>
							<td>' . $row["author_name"] . '</td>
							<td>' . $author_status . '</td>
							<td>' . $row["author_created_on"] . '</td>
							<td>' . $row["author_updated_on"] . '</td>
							<td>
								<a href="author.php?action=edit&code=' . convert_data($row["author_id"]) . '" class="btn btn-sm btn-primary">Chỉnh sửa</a>
								<button type="button" name="delete_button" class="btn btn-danger btn-sm" onclick="delete_data(`' . $row["author_id"] . '`, `' . $row["author_status"] . '`)">Xóa</button>
							</td>
						</tr>
						';
							}
						} else {
							echo '
					<tr>
						<td colspan="4" class="text-center">Không tìm thấy dữ liệu</td>
					</tr>
					';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>

		<script>
			function delete_data(code, status) {
				var new_status = 'Enable';

				if (status == 'Enable') {
					new_status = 'Disable';
				}

				if (confirm("Bạn có chắc chắn bạn muốn " + new_status + " tác giả này?")) {
					window.location.href = "author.php?action=delete&code=" + code + "&status=" + new_status + "";
				}
			}
		</script>

	<?php

	}

	?>
</div>

<?php

include 'footer.php';

?>