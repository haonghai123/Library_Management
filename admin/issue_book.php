<?php

//issue_book.php

include '../database_connection.php';

include '../function.php';

if (!is_admin_login()) {
    header('location:../admin_login.php');
}

$error = '';

if (isset($_POST["issue_book_button"])) {
    $formdata = array();

    if (empty($_POST["book_id"])) {
        $error .= '<li>Phải có Số ISBN</li>';
    } else {
        $formdata['book_id'] = trim($_POST['book_id']);
    }

    if (empty($_POST["user_id"])) {
        $error .= '<li>Phải có ID người dùng</li>';
    } else {
        $formdata['user_id'] = trim($_POST['user_id']);
    }

    if ($error == '') {
        //Check Book Available or Not

        $query = "
        SELECT * FROM lms_book 
        WHERE book_isbn_number = '" . $formdata['book_id'] . "'
        ";

        $statement = $connect->prepare($query);

        $statement->execute();

        if ($statement->rowCount() > 0) {
            foreach ($statement->fetchAll() as $book_row) {
                //check book is available or not
                if ($book_row['book_status'] == 'Enable' && $book_row['book_no_of_copy'] > 0) {
                    //Check User is exist

                    $query = "
                    SELECT user_id, user_status FROM lms_user 
                    WHERE user_unique_id = '" . $formdata['user_id'] . "'
                    ";

                    $statement = $connect->prepare($query);

                    $statement->execute();

                    if ($statement->rowCount() > 0) {
                        foreach ($statement->fetchAll() as $user_row) {
                            if ($user_row['user_status'] == 'Enable') {
                                //Check User Total issue of Book

                                $book_issue_limit = get_book_issue_limit_per_user($connect);

                                $total_book_issue = get_total_book_issue_per_user($connect, $formdata['user_id']);

                                if ($total_book_issue < $book_issue_limit) {
                                    $total_book_issue_day = get_total_book_issue_day($connect);

                                    $today_date = get_date_time($connect);

                                    $expected_return_date = date('Y-m-d H:i:s', strtotime($today_date . ' + ' . $total_book_issue_day . ' days'));

                                    $data = array(
                                        ':book_id'      =>  $formdata['book_id'],
                                        ':user_id'      =>  $formdata['user_id'],
                                        ':issue_date_time'  =>  $today_date,
                                        ':expected_return_date' => $expected_return_date,
                                        ':return_date_time' =>  '',
                                        ':book_fines'       =>  0,
                                        ':book_issue_status'    =>  'Issue'
                                    );

                                    $query = "
                                    INSERT INTO lms_issue_book 
                                    (book_id, user_id, issue_date_time, expected_return_date, return_date_time, book_fines, book_issue_status) 
                                    VALUES (:book_id, :user_id, :issue_date_time, :expected_return_date, :return_date_time, :book_fines, :book_issue_status)
                                    ";

                                    $statement = $connect->prepare($query);

                                    $statement->execute($data);

                                    $query = "
                                    UPDATE lms_book 
                                    SET book_no_of_copy = book_no_of_copy - 1, 
                                    book_updated_on = '" . $today_date . "' 
                                    WHERE book_isbn_number = '" . $formdata['book_id'] . "' 
                                    ";

                                    $connect->query($query);

                                    header('location:issue_book.php?msg=add');
                                } else {
                                    $error .= 'Người dùng đã hết hạn mượn sách, đầu tiên hãy trả lại sách';
                                }
                            } else {
                                $error .= '<li>Tài khoản người dùng đã bị Disable, Vui lòng liên hệ với quản trị viên</li>';
                            }
                        }
                    } else {
                        $error .= '<li>Không tìm thấy người dùng</li>';
                    }
                } else {
                    $error .= '<li>Sách không có sẵn</li>';
                }
            }
        } else {
            $error .= '<li>Không tìm thấy sách</li>';
        }
    }
}

if (isset($_POST["book_return_button"])) {
    if (isset($_POST["book_return_confirmation"])) {
        $data = array(
            ':return_date_time'     =>  get_date_time($connect),
            ':book_issue_status'    =>  'Return',
            ':issue_book_id'        =>  $_POST['issue_book_id']
        );

        $query = "
        UPDATE lms_issue_book 
        SET return_date_time = :return_date_time, 
        book_issue_status = :book_issue_status 
        WHERE issue_book_id = :issue_book_id
        ";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        $query = "
        UPDATE lms_book 
        SET book_no_of_copy = book_no_of_copy + 1 
        WHERE book_isbn_number = '" . $_POST["book_isbn_number"] . "'
        ";

        $connect->query($query);

        header("location:issue_book.php?msg=return");
    } else {
        $error = 'Trước tiên, vui lòng xác nhận sách trả lại bằng cách nhấp vào ô kiểm tra';
    }
}

$query = "
	SELECT * FROM lms_issue_book 
    ORDER BY issue_book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

include 'header.php';

?>
<div class="container-fluid py-4" style="min-height: 700px;">
    <h1>Quản lý sách mượn</h1>
    <?php

    if (isset($_GET["action"])) {
        if ($_GET["action"] == 'add') {
    ?>
            <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="issue_book.php">Quản lý sách mượn</a></li>
                <li class="breadcrumb-item active">Mượn sách mới</li>
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
                            <i class="fas fa-user-plus"></i> mượn sách mới
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label class="form-label">Số ISBN</label>
                                    <input type="text" name="book_id" id="book_id" class="form-control" />
                                    <span id="book_isbn_result"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ID người dùng</label>
                                    <input type="text" name="user_id" id="user_id" class="form-control" />
                                    <span id="user_unique_id_result"></span>
                                </div>
                                <div class="mt-4 mb-0">
                                    <input type="submit" name="issue_book_button" class="btn btn-success" value="Issue" />
                                </div>
                            </form>
                            <script>
                                var book_id = document.getElementById('book_id');

                                book_id.onkeyup = function() {
                                    if (this.value.length > 2) {
                                        var form_data = new FormData();

                                        form_data.append('action', 'search_book_isbn');

                                        form_data.append('request', this.value);

                                        fetch('action.php', {
                                            method: "POST",
                                            body: form_data
                                        }).then(function(response) {
                                            return response.json();
                                        }).then(function(responseData) {
                                            var html = '<div class="list-group" style="position:absolute; width:93%">';

                                            if (responseData.length > 0) {
                                                for (var count = 0; count < responseData.length; count++) {
                                                    html += '<a href="#" class="list-group-item list-group-item-action"><span onclick="get_text(this)">' + responseData[count].isbn_no + '</span> - <span class="text-muted">' + responseData[count].book_name + '</span></a>';
                                                }
                                            } else {
                                                html += '<a href="#" class="list-group-item list-group-item-action">No Book Found</a>';
                                            }

                                            html += '</div>';

                                            document.getElementById('book_isbn_result').innerHTML = html;
                                        });
                                    } else {
                                        document.getElementById('book_isbn_result').innerHTML = '';
                                    }
                                }

                                function get_text(event) {
                                    document.getElementById('book_isbn_result').innerHTML = '';

                                    document.getElementById('book_id').value = event.textContent;
                                }

                                var user_id = document.getElementById('user_id');

                                user_id.onkeyup = function() {
                                    if (this.value.length > 2) {
                                        var form_data = new FormData();

                                        form_data.append('action', 'search_user_id');

                                        form_data.append('request', this.value);

                                        fetch('action.php', {
                                            method: "POST",
                                            body: form_data
                                        }).then(function(response) {
                                            return response.json();
                                        }).then(function(responseData) {
                                            var html = '<div class="list-group" style="position:absolute;width:93%">';

                                            if (responseData.length > 0) {
                                                for (var count = 0; count < responseData.length; count++) {
                                                    html += '<a href="#" class="list-group-item list-group-item-action"><span onclick="get_text1(this)">' + responseData[count].user_unique_id + '</span> - <span class="text-muted">' + responseData[count].user_name + '</span></a>';
                                                }
                                            } else {
                                                html += '<a href="#" class="list-group-item list-group-item-action">Không tìm thấy người dùng</a>';
                                            }
                                            html += '</div>';

                                            document.getElementById('user_unique_id_result').innerHTML = html;
                                        });
                                    } else {
                                        document.getElementById('user_unique_id_result').innerHTML = '';
                                    }
                                }

                                function get_text1(event) {
                                    document.getElementById('user_unique_id_result').innerHTML = '';

                                    document.getElementById('user_id').value = event.textContent;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else if ($_GET["action"] == 'view') {
            $issue_book_id = convert_data($_GET["code"], 'decrypt');

            if ($issue_book_id > 0) {
                $query = "
                SELECT * FROM lms_issue_book 
                WHERE issue_book_id = '$issue_book_id'
                ";

                $result = $connect->query($query);

                foreach ($result as $row) {
                    $query = "
                    SELECT * FROM lms_book 
                    WHERE book_isbn_number = '" . $row["book_id"] . "'
                    ";

                    $book_result = $connect->query($query);

                    $query = "
                    SELECT * FROM lms_user 
                    WHERE user_unique_id = '" . $row["user_id"] . "'
                    ";

                    $user_result = $connect->query($query);

                    echo '
                    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="issue_book.php">Quản lí sách mượn</a></li>
                        <li class="breadcrumb-item active">Xem chi tiết sách đã mượn</li>
                    </ol>
                    ';

                    if ($error != '') {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }

                    foreach ($book_result as $book_data) {
                        echo '
                        <h2>Book Details</h2>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Số ISBN</th>
                                <td width="70%">' . $book_data["book_isbn_number"] . '</td>
                            </tr>
                            <tr>
                                <th width="30%">Tên sách</th>
                                <td width="70%">' . $book_data["book_name"] . '</td>
                            </tr>
                            <tr>
                                <th width="30%">Tác giả</th>
                                <td width="70%">' . $book_data["book_author"] . '</td>
                            </tr>
                        </table>
                        <br />
                        ';
                    }

                    foreach ($user_result as $user_data) {
                        echo '
                        <h2>User Details</h2>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">ID của người dùng</th>
                                <td width="70%">' . $user_data["user_unique_id"] . '</td>
                            </tr>
                            <tr>
                                <th width="30%">Tên người dùng</th>
                                <td width="70%">' . $user_data["user_name"] . '</td>
                            </tr>
                            <tr>
                                <th width="30%">Địa chỉ người dùng</th>
                                <td width="70%">' . $user_data["user_address"] . '</td>
                            </tr>
                            <tr>
                                <th width="30%">Liên hệ người dùng</th>
                                <td width="70%">' . $user_data["user_contact_no"] . '</td>
                            </tr>
                            <tr>
                                <th width="30%">Địa chỉ mail người dùng</th>
                                <td width="70%">' . $user_data["user_email_address"] . '</td>
                            </tr>
                            <tr>
                                <th width="30%">Ảnh người dùng</th>
                                <td width="70%"><img src="' . base_url() . 'upload/' . $user_data["user_profile"] . '" class="img-thumbnail" width="100" /></td>
                            </tr>
                        </table>
                        <br />
                        ';
                    }

                    $status = $row["book_issue_status"];

                    $form_item = '';

                    if ($status == "Issue") {
                        $status = '<span class="badge bg-warning">Issue</span>';

                        $form_item = '
                        <label><input type="checkbox" name="book_return_confirmation" value="Yes" /> Tôi đã trả sách</label>
                        <br />
                        <div class="mt-4 mb-4">
                            <input type="submit" name="book_return_button" value="Book Return" class="btn btn-primary" />
                        </div>
                        ';
                    }

                    if ($status == 'Not Return') {
                        $status = '<span class="badge bg-danger">Chưa trả lại</span>';

                        $form_item = '
                        <label><input type="checkbox" name="book_return_confirmation" value="Yes" /> Tôi đã mượn được sách</label><br />
                        <div class="mt-4 mb-4">
                            <input type="submit" name="book_return_button" value="Book Return" class="btn btn-primary" />
                        </div>
                        ';
                    }

                    if ($status == 'Return') {
                        $status = '<span class="badge bg-primary">Trả lại</span>';
                    }

                    echo '
                    <h2>Chi tiết sách mượn</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Ngày mượn sách</th>
                            <td width="70%">' . $row["issue_date_time"] . '</td>
                        </tr>
                        <tr>
                            <th width="30%">Ngày trả lại sách</th>
                            <td width="70%">' . $row["return_date_time"] . '</td>
                        </tr>
                        <tr>
                            <th width="30%">trạng thái mượn sách</th>
                            <td width="70%">' . $status . '</td>
                        </tr>
                        <tr>
                            <th width="30%">Tổng tiền phạt</th>
                            <td width="70%">' . get_currency_symbol($connect) . ' ' . $row["book_fines"] . '</td>
                        </tr>
                    </table>
                    <form method="POST">
                        <input type="hidden" name="issue_book_id" value="' . $issue_book_id . '" />
                        <input type="hidden" name="book_isbn_number" value="' . $row["book_id"] . '" />
                        ' . $form_item . '
                    </form>
                    <br />
                    ';
                }
            }
        }
    } else {
        ?>
        <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Quản lý sách mượn</li>
        </ol>

        <?php
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == 'add') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Mượn sách mới thành công<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }

            if ($_GET["msg"] == 'return') {
                echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">Trả sách lại cho thư viện thành công <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
            ';
            }
        }
        ?>

        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col col-md-6">
                        <i class="fas fa-table me-1"></i> Quản lý sách mượn
                    </div>
                    <div class="col col-md-6" align="right">
                        <a href="issue_book.php?action=add" class="btn btn-success btn-sm">Thêm</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Số ISBN</th>
                            <th>ID người dùng</th>
                            <th>Ngày phát hành</th>
                            <th>Ngày trả</th>
                            <th>Tiền phạt trả lại muộn</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Số ISBN</th>
                            <th>ID người dùng</th>
                            <th>Ngày phát hành</th>
                            <th>Ngày trả</th>
                            <th>Tiền phạt trả lại muộn</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        if ($statement->rowCount() > 0) {
                            $one_day_fine = get_one_day_fines($connect);

                            $currency_symbol = get_currency_symbol($connect);

                            set_timezone($connect);

                            foreach ($statement->fetchAll() as $row) {
                                $status = $row["book_issue_status"];

                                $book_fines = $row["book_fines"];

                                if ($row["book_issue_status"] == "Issue") {
                                    $current_date_time = new DateTime(get_date_time($connect));
                                    $expected_return_date = new DateTime($row["expected_return_date"]);

                                    if ($current_date_time > $expected_return_date) {
                                        $interval = $current_date_time->diff($expected_return_date);

                                        $total_day = $interval->d;

                                        $book_fines = $total_day * $one_day_fine;

                                        $status = 'Not Return';

                                        $query = "
        						UPDATE lms_issue_book 
													SET book_fines = '" . $book_fines . "', 
													book_issue_status = '" . $status . "' 
													WHERE issue_book_id = '" . $row["issue_book_id"] . "'
        						";

                                        $connect->query($query);
                                    }
                                }

                                if ($status == 'Issue') {
                                    $status = '<span class="badge bg-warning">Đang mượn</span>';
                                }

                                if ($status == 'Not Return') {
                                    $status = '<span class="badge bg-danger">Chưa trả</span>';
                                }

                                if ($status == 'Return') {
                                    $status = '<span class="badge bg-primary">Trả sách</span>';
                                }

                                echo '
        				<tr>
        					<td>' . $row["book_id"] . '</td>
        					<td>' . $row["user_id"] . '</td>
        					<td>' . $row["issue_date_time"] . '</td>
        					<td>' . $row["return_date_time"] . '</td>
        					<td>' . $currency_symbol . $book_fines . '</td>
        					<td>' . $status . '</td>
        					<td>
                                <a href="issue_book.php?action=view&code=' . convert_data($row["issue_book_id"]) . '" class="btn btn-info btn-sm">Xem</a>
                            </td>
        				</tr>
        				';
                            }
                        } else {
                            echo '
        			<tr>
        				<td colspan="7" class="text-center">Không tìm thấy dữ liệu</td>
        			</tr>
        			';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php

include 'footer.php';

?>