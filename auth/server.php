<?php
	session_start();
	$username= "";
	$email="";
	$errors=  array();

	$mysqli=mysqli_connect('localhost','root','','registration');


	if(isset($_POST['register'])){
		$username=$mysqli->real_escape_string($_POST['username']);
		$email=$mysqli->real_escape_string($_POST['email']);
		$password_1=$mysqli->real_escape_string($_POST['password_1']);
		$password_2=$mysqli->real_escape_string($_POST['password_2']);

		if(empty($username)){
			array_push($errors, "Numele de utilizator este obligatoriu");
		}
		if(empty($email)){
			array_push($errors, "Adresa de e-mail este obligatorie");
		}
		if(empty($password_1)){
			array_push($errors, "Parola este obligatorie");
		}
		if($password_1 != $password_2){
			array_push($errors, "Parolele trebuie să fie identice");
		}
		if(count($errors)==0)
		{
			$stmt = $mysqli->prepare("SELECT * FROM users WHERE email=?");
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if(mysqli_num_rows($result)==1){
				array_push($errors, "Acest email a fost deja utilizat");
			}
			$stmt = $mysqli->prepare("SELECT * FROM users WHERE username=?");
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if(mysqli_num_rows($result)==1){
				array_push($errors, "Acest username a fost deja utilizat");
			}
		}
		if(count($errors)==0){
			$password=md5($password_1);
			$stmt = $mysqli->prepare("INSERT INTO users (username,email,password) VALUES (?, ?, ?)");
			$stmt->bind_param('sss', $username, $email, $password);
			$stmt->execute();
			$stmt->close();
			$_SESSION['username']=$username;
			$_SESSION['success']="You are now logged in";
			$name = $_SESSION['username'];

			$stmt = $mysqli->prepare("SELECT isadmin from users where username like ?");
			$stmt->bind_param('s', $name);
			$stmt->execute();
			$rez = $stmt->get_result();
			$stmt->close();
			while ($inreg = mysqli_fetch_assoc($rez)){
				$admin = $inreg['isadmin'];
				$_SESSION['isadmin'] = $admin;
				if($admin == 1)
				header('location: ../principal/principal-admin.php');
				else{
				header('location: ../principal/principal-utilizator.php');
				}
			}
		}

	}
	if (isset($_POST['login'])){
		$username=$mysqli->real_escape_string($_POST['username']);
		$password=$mysqli->real_escape_string($_POST['password']);

		if(empty($username)){
			array_push($errors, "Numele de utilizator este obligatoriu");
		}
		if(empty($password)){
			array_push($errors, "Parola este obligatorie");
		}
		if(count($errors)==0)
		{
			$password=md5($password);
			$sql="SELECT * FROM users WHERE username='$username' AND password='$password'";
			$result=mysqli_query($mysqli,$sql);
			
			if(mysqli_num_rows($result)==1){
				$_SESSION['username']=$username;
				$_SESSION['success']="You are now logged in";
				$name = $_SESSION['username'];
				$sql = "SELECT isadmin from users where username like '$name'";
				$rez = mysqli_query($mysqli,$sql);
				while ($inreg = mysqli_fetch_assoc($rez)){
					$admin = $inreg['isadmin'];
					$_SESSION['isadmin'] = $admin;
					if($admin == 1)
					header('location: ../principal/principal-admin.php');
					else{
					header('location: ../principal/principal-utilizator.php');
					}
				}
				

			}else{
				array_push($errors, "Nume sau parolă incorecte");

			}
		}

	}

	if (isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION['username']);
		header('location: login.php');
	}
