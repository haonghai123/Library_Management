<?php

//issue_book_details.php

include 'database_connection.php';

include 'function.php';

if (!is_user_login()) {
	header('location:user_login.php');
}

$query = "
	SELECT * FROM lms_issue_book 
	INNER JOIN lms_book 
	ON lms_book.book_isbn_number = lms_issue_book.book_id 
	WHERE lms_issue_book.user_id = '" . $_SESSION['user_id'] . "' 
	ORDER BY lms_issue_book.issue_book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

include 'header.php';

?>
<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Chi tiết sách mượn</h1>
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Chi tiết sách mượn
				</div>
				<div class="col col-md-6" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Số ISBN</th>
						<th>Tên sách</th>
						<th>Ngày mượn sách</th>
						<th>Ngày trả</th>
						<th>Tiền phạt</th>
						<th>Trạng thái</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Số ISBN</th>
						<th>Tên sách</th>
						<th>Ngày mượn sách</th>
						<th>Ngày trả</th>
						<th>Tiền phạt</th>
						<th>Trạng thái</th>
					</tr>
				</tfoot>
				<tbody>
					<?php
					if ($statement->rowCount() > 0) {
						foreach ($statement->fetchAll() as $row) {
							$status = $row["book_issue_status"];
							if ($status == 'Issue') {
								$status = '<span class="badge bg-warning">Mượn</span>';
							}

							if ($status == 'Not Return') {
								$status = '<span class="badge bg-danger">Không trả lại</span>';
							}

							if ($status == 'Return') {
								$status = '<span class="badge bg-primary">Trả lại</span>';
							}

							echo '
						<tr>
							<td>' . $row["book_isbn_number"] . '</td>
							<td>' . $row["book_name"] . '</td>
							<td>' . $row["issue_date_time"] . '</td>
							<td>' . $row["return_date_time"] . '</td>
							<td>' . get_currency_symbol($connect) . $row["book_fines"] . '</td>
							<td>' . $status . '</td>
						</tr>
						';
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

</div>

<?php

include 'footer.php';

?>