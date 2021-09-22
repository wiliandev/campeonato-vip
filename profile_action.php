<?php

//profile_action.php

include "connection.php";

session_start();

$output = '';
if(isset($_POST["action"])){

  // User Register
    if($_POST["action"] == "register_user"){

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
	$link = $_POST['link'];
    $gender = $_POST['gender'];
    $status = "Ativo";
    $password = sha1($_POST['password']);

    // Check if username already exists.
    $sql = "SELECT * FROM tbl_users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $checkrows = mysqli_num_rows($result);

    if($checkrows > 0) {
      $output = array(
          'status'		    =>	'error',
      );
    } else {
      $sql = "INSERT INTO tbl_users (fullname, 
                                      username, 
                                      email,
									  link,
                                      gender,
                                      status,
                                      password,
                                      created_date) 
                              VALUES('$fullname', 
                                    '$username',
                                    '$email',
									'$link',
                                    '$gender',
                                    '$status',
                                    '$password',
                                    NOW())";
      if(mysqli_query($conn, $sql)){
          $output = array(
              'status'        => 'success'
          );
      }
    }

    echo json_encode($output);

  }

  // User login
  if($_POST["action"] == "login_user"){

    $username = $_POST['username'];
    $password = sha1($_POST['password']);	
  
    $sql = "SELECT * FROM tbl_users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    // Verifica se o nome de usuário está inativo
    if($row[6] == "Inativo")
    {
      $output = array(
        'status'        => 'inativo',            
        'error'	      	=>	'Este nome de usuário foi definido como inativo. Entre em contato com o seu administrador.'
      );
    } else {  
      if(mysqli_num_rows($result) > 0){    
        $_SESSION['user_id']       = $row[0];
        $_SESSION['fullname']      = $row[1];
        $_SESSION['username']      = $row[2];
        $_SESSION['email']         = $row[3];
		$_SESSION['link']          = $row[4];
        $_SESSION['gender']        = $row[5];
        $_SESSION['created_date']  = $row[8];

        $output = array(
          'status'        => 'success'
        );
      } else {
        $output = array(
          'status'        => 'error',            
          'error'	      	=> 'Usuário ou senha incorretos.'
        );
      }
    }

    echo json_encode($output);

  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){

    $id = $_SESSION['user_id'];
      
    $sql = "SELECT id, fullname, username, email, link, gender FROM tbl_users WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_row($result);

    $output = array(
      "id"		            =>	$row[0],
      "fullname"		      =>	$row[1],
      "username"		      => 	$row[2],
      "email"		          => 	$row[3],
	  "link"		          => 	$row[4],
      "gender"		        => 	$row[5]
    );

    echo json_encode($output);

  }

  // Single edit fetch
  if($_POST["action"] == "update_user"){

    $id = $_SESSION['user_id'];

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
	$link = $_POST['link'];
    $gender = $_POST['gender'];

    $sql = "UPDATE tbl_users SET fullname = '$fullname',
                              username = '$username',
                              email = '$email',
							  link = '$link',
                              gender = '$gender'
                              WHERE id = '$id'";

    if(mysqli_query($conn, $sql)){

      $output = array(
        'status'        => 'success'
      );

      $_SESSION['fullname']      = $fullname;
      $_SESSION['username']      = $username;
      $_SESSION['email']         = $email;
	  $_SESSION['link']          = $link;
      $_SESSION['gender']        = $gender;

    }else{
      $output = array(
        'status'        => 'error'
      );
    }

    echo json_encode($output);

  }

  // Update User Password
  if($_POST["action"] == "update_password"){

    $id = $_SESSION['user_id'];

    $password = sha1($_POST['current_password']);
    $new_password = sha1($_POST['new_password']);

    $sql = "SELECT * FROM tbl_users WHERE password = '$password' AND id = '$id'";
    $result = mysqli_query($conn, $sql);
    $checkrows = mysqli_num_rows($result);

    if($checkrows > 0) {

        $sql = "UPDATE tbl_users SET password = '$new_password' WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);

        if($result > 0)	{
          $output = array(
            'status'	=>	'success'
          );                
          echo json_encode($output);
        } 

    } else {
        $output = array(
            'error'		     =>	'true'
        );
        echo json_encode($output); 
    }
  }
}

?>