<?php

include 'database_connection.php';
include 'function.php';

if (is_user_login()) {
	header('location:issue_book_details.php');
}

include 'header.php';



?>

<div class="p-5 mb-4 bg-light rounded-3">

	<div class="container-fluid py-5">

		<h1 class="display-5 fw-bold">Open Library</h1>

		<p class="fs-4">Chào mừng bạn đã đến với Open Library của chúng tôi. Hệ thống thư viện trực tuyến</p>

	</div>

</div>

<div class="row align-items-md-stretch">

	<div class="col-md-6">

		<div class="h-100 p-5 text-white bg-dark rounded-3">

			<h2>Admin Đăng nhập</h2>
			<p></p>
			<a href="admin_login.php" class="btn btn-outline-light">Admin đăng nhập</a>

		</div>

	</div>

	<div class="col-md-6">

		<div class="h-100 p-5 bg-light border rounded-3">

			<h2>Người dùng đăng nhập</h2>

			<p></p>

			<a href="user_login.php" class="btn btn-outline-secondary">Người dùng đăng nhập</a>

			<a href="user_registration.php" class="btn btn-outline-primary">Người dùng đăng kí</a>

		</div>

	</div>

</div>

<?php

include 'footer.php';

?>