<?php

//verify.php

include 'database_connection.php';

include 'function.php';

include 'header.php';

if(isset($_GET['code']))
{
	$data = array(
		':user_verificaton_code'		=>	trim($_GET['code'])
	);

	$query = "
	SELECT user_verification_status FROM lms_user 
	WHERE user_verificaton_code = :user_verificaton_code
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	if($statement->rowCount() > 0)
	{
		foreach($statement->fetchAll() as $row)
		{
			if($row['user_verification_status'] == 'No')
			{
				$data = array(
					':user_verification_status'		=>	'Yes',
					':user_verificaton_code'		=>	trim($_GET['code'])
				);

				$query = "
				UPDATE lms_user 
				SET user_verification_status = :user_verification_status 
				WHERE user_verificaton_code = :user_verificaton_code
				";

				$statement = $connect->prepare($query);

				$statement->execute($data);

				echo '<div class="alert alert-success">Email của bạn đã được xác minh thành công, bây giờ bạn có thể <a href="user_login.php">Đăng nhập</a> into system.</div>';
			}
			else
			{
				echo '<div class="alert alert-info">Email của bạn đã được xác minh</div>';
			}
		}
	}
	else
	{
		echo '<div class="alert alert-danger">URL không hợp lệ</div>';
	}
}

include 'footer.php';

?>