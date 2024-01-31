<?php

//search_book.php

include 'database_connection.php';

include 'function.php';

if(!is_user_login())
{
	header('location:user_login.php');
}

$query = "
	SELECT * FROM lms_book 
    WHERE book_status = 'Enable' 
    ORDER BY book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();


include 'header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">

	<h1>Search Book</h1>

	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Danh sách sách
				</div>
				<div class="col col-md-6" align="right">

				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Tên sách</th>
						<th>Số ISBN</th>
						<th>Loại</th>
						<th>Tác giả</th>
						<th>Vị trí kệ sách</th>
						<th>Số lượng có sẵn</th>
						<th>Trạng thái</th>
						<th>Đã thêm vào</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Tên sách</th>
						<th>Số ISBN</th>
						<th>Loại</th>
						<th>Tác giả</th>
						<th>Vị trí kệ sách</th>
						<th>Số lượng có sẵn</th>
						<th>Trạng thái</th>
						<th>Đã thêm vào</th>
					</tr>
				</tfoot>
				<tbody>
				<?php 

				if($statement->rowCount() > 0)
				{
					foreach($statement->fetchAll() as $row)
					{
						$book_status = '';
						if($row['book_no_of_copy'] > 0)
						{
							$book_status = '<div class="badge bg-success">Có sẵn</div>';
						}
						else
						{
							$book_status = '<div class="badge bg-danger">Không có sẵn</div>';
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
							</tr>
						';
					}
				}
				else
				{
					echo '
					<tr>
						<td colspan="8" class="text-center">Không có dữ liệu</td>
					</tr>
					';
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