<?php

//user_registration.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'database_connection.php';

include 'function.php';

if(is_user_login())
{
	header('location:issue_book_details.php');
}

$message = '';

$success = '';

if(isset($_POST["register_button"]))
{
	$formdata = array();

	if(empty($_POST["user_email_address"]))
	{
		$message .= '<li>phải có địa chỉ mail</li>';
	}
	else
	{
		if(!filter_var($_POST["user_email_address"], FILTER_VALIDATE_EMAIL))
		{
			$message .= '<li>Địa chỉ email không hợp lệ</li>';
		}
		else
		{
			$formdata['user_email_address'] = trim($_POST['user_email_address']);
		}
	}

	if(empty($_POST["user_password"]))
	{
		$message .= '<li>Phải có mật khẩu</li>';
	}
	else
	{
		$formdata['user_password'] = trim($_POST['user_password']);
	}

	if(empty($_POST['user_name']))
	{
		$message .= '<li>Phải có tên người dùng</li>';
	}
	else
	{
		$formdata['user_name'] = trim($_POST['user_name']);
	}

	if(empty($_POST['user_address']))
	{
		$message .= '<li>Phải có chi tiết địa chỉ người dùng</li>';
	}
	else
	{
		$formdata['user_address'] = trim($_POST['user_address']);
	}

	if(empty($_POST['user_contact_no']))
	{
		$message .= '<li>Phải có chi tiết số liên lạc người dùng</li>';
	}
	else
	{
		$formdata['user_contact_no'] = trim($_POST['user_contact_no']);
	}

	if(!empty($_FILES['user_profile']['name']))
	{
		$img_name = $_FILES['user_profile']['name'];
		$img_type = $_FILES['user_profile']['type'];
		$tmp_name = $_FILES['user_profile']['tmp_name'];
		$fileinfo = @getimagesize($tmp_name);
		$width = $fileinfo[0];
		$height = $fileinfo[1];

		$image_size = $_FILES['user_profile']['size'];

		$img_explode = explode(".", $img_name);

		$img_ext = strtolower(end($img_explode));

		$extensions = ["jpeg", "png", "jpg"];

		if(in_array($img_ext, $extensions))
		{
			if($image_size <= 2000000)
			{
				if($width == '225' && $height == '225')
				{
					$new_img_name = time() . '-' . rand() . '.' . $img_ext;
					if(move_uploaded_file($tmp_name, "upload/".$new_img_name))
					{
						$formdata['user_profile'] = $new_img_name;
					}
				}
				else
				{
					$message .= '<li>Ảnh phải có kích thước 225 X 225</li>';
				}
			}
			else
			{
				$message .= '<li>Hình ảnh có kích thước vượt quá 2MB</li>';
			}
		}
		else
		{
			$message .= '<li>Tệp tin ảnh không hợp lệ</li>';
		}
	}
	else
	{
		$message .= '<li>Vui lòng chọn ảnh cho hồ sơ của bạn</li>';
	}

	if($message == '')
	{
		$data = array(
			':user_email_address'		=>	$formdata['user_email_address']
		);

		$query = "
		SELECT * FROM lms_user 
        WHERE user_email_address = :user_email_address
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			$message = '<li>Email này đã đăng ký</li>';
		}
		else
		{
			$user_verificaton_code = md5(uniqid());

			$user_unique_id = 'U' . rand(10000000,99999999);

			$data = array(
				':user_name'			=>	$formdata['user_name'],
				':user_address'			=>	$formdata['user_address'],
				':user_contact_no'		=>	$formdata['user_contact_no'],
				':user_profile'			=>	$formdata['user_profile'],
				':user_email_address'	=>	$formdata['user_email_address'],
				':user_password'		=>	$formdata['user_password'],
				':user_verificaton_code'=>	$user_verificaton_code,
				':user_verification_status'	=>	'No',
				':user_unique_id'		=>	$user_unique_id,
				':user_status'			=>	'Enable',
				':user_created_on'		=>	get_date_time($connect)
			);

			$query = "
			INSERT INTO lms_user 
            (user_name, user_address, user_contact_no, user_profile, user_email_address, user_password, user_verificaton_code, user_verification_status, user_unique_id, user_status, user_created_on) 
            VALUES (:user_name, :user_address, :user_contact_no, :user_profile, :user_email_address, :user_password, :user_verificaton_code, :user_verification_status, :user_unique_id, :user_status, :user_created_on)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			require 'vendor/autoload.php';

			$mail = new PHPMailer(true);

			$mail->CharSet = "utf8";
			
			$mail->isSMTP();

			$mail->Host = 'smtp.gmail.com';  //Here you have to define GMail SMTP

			$mail->SMTPAuth = true;

			$mail->Username = 'mtpskypro22234@gmail.com';  //Here you can use your Gmail Email Address

			$mail->Password = 'mbhcktfjgqcmqvxc';  //Here you can use your Gmail Address Password mbhc ktfj gqcm qvxc


			$mail->SMTPSecure = 'ssl';

			$mail->Port = 465;

			$mail->setFrom('Openlibrary@gmail.com', 'Hain');

			$mail->addAddress($formdata['user_email_address'], $formdata['user_name']);

			$mail->isHTML(true);

			$mail->Subject = 'Xác minh đăng ký cho hệ thống quản lý thư viện Open Library';

			$mail->Body = '
			 <p>Cảm ơn bạn đã đăng ký Hệ thống Thư viện Open Library &; ID của bạn là: <b>'.$user_unique_id.'</b> sẽ được sử dụng cho mượn sách .</p>

                <p>Đây là mail xác nhận, Hãy nhấp vào link mail xác nhận.</p>
                <p><a href="'.base_url().'verify.php?code='.$user_verificaton_code.'">Xác nhận</a></p>
                <p>Cám ơn...</p>
			';

			$mail->send();

			$success = 'Xác nhận email đã gửi đến ' . $formdata['user_email_address'] . ', Xác nhận Email này';
		}

	}
}

include 'header.php';

?>


<div class="d-flex align-items-center justify-content-center mt-5 mb-5" style="min-height:700px;">
	<div class="col-md-6">
		<?php 

		if($message != '')
		{
			echo '<div class="alert alert-danger"><ul>'.$message.'</ul></div>';
		}

		if($success != '')
		{
			echo '<div class="alert alert-success">'.$success.'</div>';
		}

		?>
		<div class="card">
			<div class="card-header">Người dùng đăng ký mới</div>
			<div class="card-body">
				<form method="POST" enctype="multipart/form-data">
					<div class="mb-3">
						<label class="form-label">Địa chỉ mail</label>
						<input type="text" name="user_email_address" id="user_email_address" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">Mật khẩu</label>
						<input type="password" name="user_password" id="user_password" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">Tên người dùng</label>
                        <input type="text" name="user_name" class="form-control" id="user_name" value="" />
                    </div>
					<div class="mb-3">
						<label class="form-label">Số liên hệ người dùng</label>
						<input type="text" name="user_contact_no" id="user_contact_no" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">Địa chỉ người dùng</label>
						<textarea name="user_address" id="user_address" class="form-control"></textarea>
					</div>
					<div class="mb-3">
						<label class="form-label">Ảnh người dùng</label><br />
						<input type="file" name="user_profile" id="user_profile" />
						<br />
						<span class="text-muted">Chỉ cho phép tệp dưới dạng .jpg & .png . Kích thước ảnh phải là 225 x 225</span>
					</div>
					<div class="text-center mt-4 mb-2">
						<input type="submit" name="register_button" class="btn btn-primary" value="Đăng kí" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php 


include 'footer.php';

?>