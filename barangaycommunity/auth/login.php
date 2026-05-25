<?php

session_start();

include '../config/database.php';

$error = "";

if(isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {

        $error = "All fields are required.";

    } else {

        $stmt = $conn->prepare("
            SELECT * FROM officials
            WHERE username = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $username);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0) {

            $user = $result->fetch_assoc();

            if(password_verify($password, $user['password'])) {

                session_regenerate_id(true);

                $_SESSION['official_id'] = $user['official_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['position'] = $user['position'];
                $_SESSION['role'] = $user['role'];

                $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

                header("Location: ../dashboard/index.php");
                exit();

            } else {

                $error = "Invalid username or password.";

            }

        } else {

            $error = "Invalid username or password.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f4f7fb;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.container{
    width:100%;
    max-width:450px;
}

.card{
    background:#fff;
    border-radius:22px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.logo{
    width:85px;
    height:85px;
    border-radius:20px;
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:auto;
    font-size:34px;
    margin-bottom:20px;
}

.title{
    text-align:center;
    margin-bottom:30px;
}

.title h2{
    color:#0f172a;
    font-size:30px;
    margin-bottom:5px;
}

.title p{
    color:#64748b;
    font-size:14px;
}

.alert{
    background:#fee2e2;
    color:#b91c1c;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    font-size:14px;
    text-align:center;
}

.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:6px;
    font-size:13px;
    font-weight:500;
    color:#334155;
}

.input-group{
    position:relative;
}

.input-group i{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#94a3b8;
    font-size:14px;
}

input{
    width:100%;
    padding:13px 14px 13px 42px;
    border:1px solid #e2e8f0;
    border-radius:12px;
    outline:none;
    font-size:14px;
    transition:0.3s;
}

input:focus{
    border-color:#16a34a;
    box-shadow:0 0 0 4px rgba(22,163,74,0.12);
}

.login-btn{
    width:100%;
    border:none;
    padding:14px;
    border-radius:12px;
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(22,163,74,0.3);
}

.login-btn:hover{
    transform:translateY(-2px);
}

.footer{
    text-align:center;
    margin-top:20px;
    font-size:14px;
    color:#64748b;
}

.footer a{
    color:#16a34a;
    text-decoration:none;
    font-weight:500;
}

.footer a:hover{
    text-decoration:underline;
}

@media(max-width:500px){

    .card{
        padding:25px;
    }

    .title h2{
        font-size:24px;
    }

}

</style>

</head>

<body>

<div class="container">

    <div class="card">

        <!-- LOGO -->

        <div class="logo">
            <i class="fa-solid fa-user-lock"></i>
        </div>

        <!-- TITLE -->

        <div class="title">

            <h2>Welcome Back</h2>

            <p>
                Login to access the Barangay Management System
            </p>

        </div>

        <!-- ERROR MESSAGE -->

        <?php if($error != "") { ?>

            <div class="alert">
                <?= $error; ?>
            </div>

        <?php } ?>

        <!-- LOGIN FORM -->

        <form method="POST">

            <!-- USERNAME -->

            <div class="form-group">

                <label>Username</label>

                <div class="input-group">

                    <i class="fa-solid fa-user"></i>

                    <input type="text"
                           name="username"
                           placeholder="Enter username"
                           required>

                </div>

            </div>

            <!-- PASSWORD -->

            <div class="form-group">

                <label>Password</label>

                <div class="input-group">

                    <i class="fa-solid fa-lock"></i>

                    <input type="password"
                           name="password"
                           placeholder="Enter password"
                           required>

                </div>

            </div>

            <!-- BUTTON -->

            <button type="submit"
                    name="login"
                    class="login-btn">

                <i class="fa-solid fa-right-to-bracket"></i>
                Login

            </button>

        </form>

        <!-- FOOTER -->

        <div class="footer">

            Don't have an account?

            <a href="register.php">
                Create Account
            </a>

        </div>

    </div>

</div>

</body>
</html>