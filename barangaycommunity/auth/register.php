<?php

session_start();

include '../config/database.php';

$error = "";
$success = "";

if(isset($_POST['register'])) {

    $full_name = trim($_POST['full_name']);
    $position = trim($_POST['position']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if(
        empty($full_name) ||
        empty($position) ||
        empty($username) ||
        empty($password) ||
        empty($role)
    ){

        $error = "All fields are required.";

    } 
     elseif(strlen($password) < 8){
        $error = "Password must be at least 8 characters.";
    }
    elseif(
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/[0-9]/', $password)
    ){
        $error = "Password must contain uppercase, lowercase, and number.";
    }
    else {

        /*
        |--------------------------------------------------------------------------
        | CHECK IF USERNAME EXISTS
        |--------------------------------------------------------------------------
        */

        $check = $conn->prepare("
            SELECT official_id
            FROM officials
            WHERE username = ?
            LIMIT 1
        ");

        $check->bind_param("s", $username);

        $check->execute();

        $checkResult = $check->get_result();

        if($checkResult->num_rows > 0){

            $error = "Username already exists.";

        } else {

            /*
            |--------------------------------------------------------------------------
            | HASH PASSWORD
            |--------------------------------------------------------------------------
            */

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            /*
            |--------------------------------------------------------------------------
            | INSERT OFFICIAL
            |--------------------------------------------------------------------------
            */

            $stmt = $conn->prepare("
                INSERT INTO officials(
                    full_name,
                    position,
                    username,
                    password,
                    role
                )
                VALUES(
                    ?, ?, ?, ?, ?
                )
            ");

            $stmt->bind_param(
                "sssss",
                $full_name,
                $position,
                $username,
                $hashedPassword,
                $role
            );

            if($stmt->execute()){

                $success = "Official account registered successfully.";

            } else {

                $error = "Something went wrong. Please try again.";

            }

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register Official</title>

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
    max-width:500px;
}

.card{
    background:#fff;
    border-radius:20px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.logo{
    width:80px;
    height:80px;
    border-radius:20px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:auto;
    font-size:32px;
    margin-bottom:20px;
}

.title{
    text-align:center;
    margin-bottom:30px;
}

.title h2{
    color:#0f172a;
    font-size:28px;
    margin-bottom:5px;
}

.title p{
    color:#64748b;
    font-size:14px;
}

.alert-error{
    background:#fee2e2;
    color:#b91c1c;
    padding:12px;
    border-radius:10px;
    margin-bottom:18px;
    font-size:14px;
    text-align:center;
}

.alert-success{
    background:#dcfce7;
    color:#166534;
    padding:12px;
    border-radius:10px;
    margin-bottom:18px;
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

input,
select{
    width:100%;
    padding:13px 14px 13px 42px;
    border:1px solid #e2e8f0;
    border-radius:12px;
    outline:none;
    font-size:14px;
    transition:0.3s;
    background:#fff;
}

input:focus,
select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,0.12);
}

.register-btn{
    width:100%;
    border:none;
    padding:14px;
    border-radius:12px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(37,99,235,0.3);
}

.register-btn:hover{
    transform:translateY(-2px);
}

.footer{
    text-align:center;
    margin-top:20px;
    font-size:14px;
    color:#64748b;
}

.footer a{
    color:#2563eb;
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
            <i class="fa-solid fa-user-shield"></i>
        </div>

        <!-- TITLE -->

        <div class="title">

            <h2>Register Official</h2>

            <p>
                Create an official account for the barangay system.
            </p>

        </div>

        <!-- ERROR -->

        <?php if($error != "") { ?>

            <div class="alert-error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php } ?>

        <!-- SUCCESS -->

        <?php if($success != "") { ?>

            <div class="alert-success">
                <?= htmlspecialchars($success) ?>
            </div>

        <?php } ?>

        <!-- FORM -->

        <form method="POST">

            <!-- FULL NAME -->

            <div class="form-group">

                <label>Full Name</label>

                <div class="input-group">

                    <i class="fa-solid fa-user"></i>

                    <input type="text"
                           name="full_name"
                           placeholder="Enter full name"
                           required>

                </div>

            </div>

            <!-- POSITION -->

            <div class="form-group">

                <label>Position</label>

                <div class="input-group">

                    <i class="fa-solid fa-briefcase"></i>

                    <input type="text"
                           name="position"
                           placeholder="Enter position"
                           required>

                </div>

            </div>

            <!-- USERNAME -->

            <div class="form-group">

                <label>Username</label>

                <div class="input-group">

                    <i class="fa-solid fa-at"></i>

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

            <!-- ROLE -->

            <div class="form-group">

                <label>Role</label>

                <div class="input-group">

                    <i class="fa-solid fa-user-gear"></i>

                    <select name="role" required>

                        <option value="">
                            Select Role
                        </option>

                        <option value="Admin">
                            Admin
                        </option>

                        <option value="Staff">
                            Staff
                        </option>

                    </select>

                </div>

            </div>

            <!-- BUTTON -->

            <button type="submit"
                    name="register"
                    class="register-btn">

                <i class="fa-solid fa-user-plus"></i>
                Register Official

            </button>

        </form>

        <!-- FOOTER -->

        <div class="footer">

            Already have an account?

            <a href="login.php">
                Login here
            </a>

        </div>

    </div>

</div>

</body>
</html>