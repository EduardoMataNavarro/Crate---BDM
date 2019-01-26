<?php
	include("config.php");
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		try
		{
			$db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
			if (isset($_POST['logIn'])) {
				$usermail_input = mysqli_real_escape_string($db_connection, $_POST["user"]);
				$userpass_input = mysqli_real_escape_string($db_connection, $_POST["passwrd"]);
				$mysql_statement = "CALL SP_LOGIN('".$usermail_input."','".$userpass_input."')";

				$query_result = mysqli_query($db_connection, $mysql_statement);
				if($query_result)
				{
					$row = mysqli_fetch_array($query_result, MYSQLI_ASSOC);
					if(isset($row["idUsuario"]))
					{
						session_start();
						$_SESSION["username"] = $row["nombre"];
						$_SESSION["user_id"] = $row["idUsuario"];
						$_SESSION["usermail"] = $row["correo"];
						$_SESSION["userPhoto"] = $row["imagenAvatar"];
						$_SESSION["bannerPhoto"] = $row["imagenPortada"];
						$_SESSION["avatarPhotoFormat"] = $row["imgAvatarFormato"];
						$_SESSION["bannerPhotoFormat"] = $row["imgBannerFormato"];
						$_SESSION["loggedin"] = 1;
						
						mysqli_close($db_connection);
						//setcookie('crate_usermail', $_SESSION['usermail'], time() + 604800, "/");
						//setcookie('crate_userpass', $row['userPass'], time() + 604800, "/");
						echo json_encode(array('loggedIn' => true, 'username' => $_SESSION['username']));
					}
					else
					{
						echo json_encode(array('loggedIn' => false));
					}
				}
				else 
					echo json_encode(array('loggedIn' => false));
			}
			if (isset($_POST['register'])) {
				$username_input    = mysqli_real_escape_string($db_connection, $_POST["userName"]);
				$usermail_input    = mysqli_real_escape_string($db_connection, $_POST["mail"]);
				$userpass_input    = mysqli_real_escape_string($db_connection, $_POST["passwrdConfirm"]);
				$userphone_input   = mysqli_real_escape_string($db_connection, $_POST["phone"]);
				$useraddress_input = mysqli_real_escape_string($db_connection, $_POST["address"]);

				$avatarP_input = "";
				$bannerP_input = "";
				$avatarP_type  = "";
				$bannerP_type = "";
				if(isset($_FILES["userphoto"])){
					$avatarP_input = addslashes(file_get_contents($_FILES["userphoto"]["tmp_name"]));
					$avatarP_type  = $_FILES['userphoto']['type'];
					echo 'hay imagen de perfil';
				}	
				if (isset($_FILES["bannerPhoto"])) {
					$bannerP_input = addslashes(file_get_contents($_FILES["bannerPhoto"]["tmp_name"]));
					$bannerP_type  = $_FILES['bannerPhoto']['type'];
					echo 'hay imagen de portada';
				}

				if ($username_input != '' and $usermail_input != '' and $userpass_input != '') {
					$mysql_statement = "CALL SP_ADD_USUARIO('".$username_input."', '".$userpass_input."', '".$usermail_input."', '".$userphone_input."', '".$useraddress_input."','".$avatarP_input."','".$bannerP_input."','".$avatarP_type."', '".$bannerP_type."');";
					$query_result = mysqli_query($db_connection, $mysql_statement);
					if ($query_result) {
						$row = mysqli_fetch_array($query_result, MYSQLI_ASSOC);
						if (isset($row["userId"])) {
							session_start();
							$_SESSION["username"] = $username_input;
							$_SESSION["user_id"] = $row["userId"];
							$_SESSION["usermail"] = $usermail_input;
							$_SESSION["userPhoto"] = $row["imagenAvatar"];
							$_SESSION["bannerPhoto"] = $row["imagenPortada"];
							$_SESSION["avatarPhotoFormat"] = $row["imgAvatarFormato"];
							$_SESSION["bannerPhotoFormat"] = $row["imgBannerFormato"];
							$_SESSION["loggedin"] = 1;
							mysqli_close($db_connection);
							header("location: index.php");
						}
					}
					echo 'el query fallo';
				}
			}
	  	}
		catch(Exception $e)
		{
			echo "Hubo un problema".$e;
		}
	}
?>