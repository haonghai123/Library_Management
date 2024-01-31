<?php

//location_rack.php

include '../database_connection.php';

include '../function.php';

if (!is_admin_login()) {
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if (isset($_POST["add_location_rack"])) {
	$formdata = array();

	if (empty($_POST["location_rack_name"])) {
		$error .= '<li>Phải có tên vị trí kệ</li>';
	} else {
		$formdata['location_rack_name'] = trim($_POST["location_rack_name"]);
	}

	if ($error == '') {
		$query = "
		SELECT * FROM lms_location_rack 
        WHERE location_rack_name = '" . $formdata['location_rack_name'] . "'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if ($statement->rowCount() > 0) {
			$error = '<li>Tên vị trí kệ sách đã tồn tại</li>';
		} else {
			$data = array(
				':location_rack_name'		=>	$formdata['location_rack_name'],
				':location_rack_status'		=>	'Enable',
				':location_rack_created_on'	=>	get_date_time($connect)
			);

			$query = "
			INSERT INTO lms_location_rack 
            (location_rack_name, location_rack_status, location_rack_created_on) 
            VALUES (:location_rack_name, :location_rack_status, :location_rack_created_on)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:location_rack.php?msg=add');
		}
	}
}

if (isset($_POST["edit_location_rack"])) {
	$formdata = array();

	if (empty($_POST["location_rack_name"])) {
		$error .= '<li>Phải có tên vị trí kệ sách</li>';
	} else {
		$formdata['location_rack_name'] = trim($_POST["location_rack_name"]);
	}

	if ($error == '') {
		$location_rack_id = convert_data($_POST["location_rack_id"], 'decrypt');

		$query = "
		SELECT * FROM lms_location_rack 
	        WHERE location_rack_name = '" . $formdata['location_rack_name'] . "' 
	        AND location_rack_id != '" . $location_rack_id . "'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if ($statement->rowCount() > 0) {
			$error = '<li>Đã tồn tại tên vị trí kệ sách</li>';
		} else {
			$data = array(
				':location_rack_name'		=>	$formdata['location_rack_name'],
				':location_rack_updated_on'	=>	get_date_time($connect),
				':location_rack_id'			=>	$location_rack_id
			);

			$query = "
			UPDATE lms_location_rack 
	            SET location_rack_name = :location_rack_name, 
	            location_rack_updated_on = :location_rack_updated_on  
	            WHERE location_rack_id = :location_rack_id
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:location_rack.php?msg=edit');
		}
	}
}

if (isset($_GET["action"], $_GET["code"], $_GET["status"]) && $_GET["action"] == 'delete') {
	$location_rack_id = $_GET["code"];

	$status = $_GET["status"];

	$data = array(
		':location_rack_status'			=>	$status,
		':location_rack_updated_on'		=>	get_date_time($connect),
		':location_rack_id'				=>	$location_rack_id
	);
	$query = "
	UPDATE lms_location_rack 
    SET location_rack_status = :location_rack_status, 
    location_rack_updated_on = :location_rack_updated_on 
    WHERE location_rack_id = :location_rack_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:location_rack.php?msg=' . strtolower($status) . '');
}


$query = "
	SELECT * FROM lms_location_rack 
    ORDER BY location_rack_name ASC
";

$statement = $connect->prepare($query);

$statement->execute();

include 'header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Quản lý vị trí giá đỡ</h1>
	<?php

	if (isset($_GET["action"])) {
		if ($_GET["action"] == 'add') {
	?>

			<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
				<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="category.php">Quản lý vị trí giá đỡ</a></li>
				<li class="breadcrumb-item active">Thêm vị trí giá đỡ</li>
			</ol>

			<div class="row">
				<div class="col-md-6">
					<?php

					if ($error != '') {
						echo '
				<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">' . $error . '</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
				';
					}

					?>
					<div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-user-plus"></i> Thêm mới vị trí giá đỡ
						</div>
						<div class="card-body">
							<form method="post">
								<div class="mb-3">
									<label class="form-label">Tên giá đỡ</label>
									<input type="text" name="location_rack_name" id="location_rack_name" class="form-control" />
								</div>
								<div class="mt-4 mb-0">
									<input type="submit" name="add_location_rack" class="btn btn-success" value="Thêm" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<?php
		} else if ($_GET["action"] == 'edit') {
			$location_rack_id = convert_data($_GET["code"], 'decrypt');

			if ($location_rack_id > 0) {
				$query = "
				SELECT * FROM lms_location_rack 
                WHERE location_rack_id = '$location_rack_id'
				";

				$location_rack_result = $connect->query($query);

				foreach ($location_rack_result as $location_rack_row) {
			?>

					<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="location_rack.php">Quản lí vị trí kệ</a></li>
						<li class="breadcrumb-item active">Chỉnh sửa vị trí kệ</li>
					</ol>
					<div class="row">
						<div class="col-md-6">
							<div class="card mb-4">
								<div class="card-header">
									<i class="fas fa-user-edit"></i> Chỉnh sửa chi tiết vị trí kệ
								</div>
								<div class="card-body">
									<form method="post">
										<div class="mb-3">
											<label class="form-label">Tên vị trí giá đỡ</label>
											<input type="text" name="location_rack_name" id="location_rack_name" class="form-control" value="<?php echo $location_rack_row["location_rack_name"]; ?>" />
										</div>
										<div class="mt-4 mb-0">
											<input type="hidden" name="location_rack_id" value="<?php echo $_GET['code']; ?>" />
											<input type="submit" name="edit_location_rack" class="btn btn-primary" value="Chỉnh sửa" />
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
			<li class="breadcrumb-item active">Quản lí vị trí kệ</li>
		</ol>
		<?php

		if (isset($_GET["msg"])) {
			if ($_GET["msg"] == 'add') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Đã thêm vị trí kệ mới<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if ($_GET["msg"] == 'edit') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Dữ liệu vị trí kệ đã được chỉnh sửa <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if ($_GET["msg"] == 'disable') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Thay đổi vị trí trạng thái kệ đã Disable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if ($_GET["msg"] == 'enable') {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Thay đổi vị trí trạng thái kệ đã Enable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
		}

		?>
		<div class="card mb-4">
			<div class="card-header">
				<div class="row">
					<div class="col col-md-6">
						<i class="fas fa-table me-1"></i> Quản lí vị trí kệ
					</div>
					<div class="col col-md-6" align="right">
						<a href="location_rack.php?action=add" class="btn btn-success btn-sm">Thêm</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table id="datatablesSimple">
					<thead>
						<tr>
							<th>Tên vị trí kệ</th>
							<th>Trạng thái</th>
							<th>Tạo vào ngày</th>
							<th>Cập nhật vào ngày</th>
							<th>Hành động</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Tên vị trí kệ</th>
							<th>Trạng thái</th>
							<th>Tạo vào ngày</th>
							<th>Cập nhật vào ngày</th>
							<th>Hành động</th>
						</tr>
					</tfoot>
					<tbody>
						<?php
						if ($statement->rowCount() > 0) {
							foreach ($statement->fetchAll() as $row) {
								$location_rack_status = '';
								if ($row['location_rack_status'] == 'Enable') {
									$location_rack_status = '<div class="badge bg-success">Tốt</div>';//@@@@@@@@@@@
								} else {
									$location_rack_status = '<div class="badge bg-danger">Không</div>';//@@@@@@@@@@@@@
								}

								echo '
						<tr>
							<td>' . $row["location_rack_name"] . '</td>
							<td>' . $location_rack_status . '</td>
							<td>' . $row["location_rack_created_on"] . '</td>
							<td>' . $row["location_rack_updated_on"] . '</td>
							<td>
								<a href="location_rack.php?action=edit&code=' . convert_data($row["location_rack_id"]) . '" class="btn btn-sm btn-primary">Chỉnh sửa</a>
								<button type="button" name="delete_button" class="btn btn-danger btn-sm" onclick="delete_data(`' . $row["location_rack_id"] . '`, `' . $row["location_rack_status"] . '`)">Xóa</button>
							</td>
						</tr>
						';
							}
						} else {
							echo '
					<tr>
						<td colspan="5" class="text-center">Không tìm thấy dữ liệu</td>
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

				if (confirm("Bạn có chắc chắn" + new_status + " Thể loại này?")) {
					window.location.href = "location_rack.php?action=delete&code=" + code + "&status=" + new_status + ""
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