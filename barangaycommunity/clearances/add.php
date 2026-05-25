<?php

session_start();

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

include '../config/database.php';

$residents = mysqli_query($conn,
    "SELECT * FROM residents");

if(isset($_POST['add'])) {

    $resident_id = $_POST['resident_id'];
    $clearance_type = $_POST['clearance_type'];
    $purpose = $_POST['purpose'];

    $query = "

        CALL issue_clearance_procedure(

            '$resident_id',
            '$clearance_type',
            '$purpose'

        )

    ";

    mysqli_query($conn, $query);

    header("Location: index.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Issue Clearance</title>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
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
    padding:40px;
    color:#333;
}

.container{
    max-width:900px;
    margin:auto;
}

.card{
    background:#fff;
    padding:30px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.header{
    margin-bottom:25px;
}

.header h2{
    font-size:28px;
    color:#0f172a;
    display:flex;
    align-items:center;
    gap:10px;
}

.logged-user{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:10px;
    font-size:14px;
    color:#64748b;
    background:#f8fafc;
    padding:8px 14px;
    border-radius:10px;
}

.logged-user strong{
    color:#0f172a;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.full{
    grid-column:span 2;
}

.field{
    display:flex;
    flex-direction:column;
}

label{
    font-size:13px;
    margin-bottom:6px;
    color:#334155;
    font-weight:500;
}

input,
select,
textarea{
    width:100%;
    padding:12px 14px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    outline:none;
    font-size:14px;
    transition:0.3s ease;
    background:#fff;
    resize:none;
}

input:focus,
select:focus,
textarea:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,0.15);
}

.actions{
    margin-top:25px;
    display:flex;
    justify-content:flex-end;
    gap:12px;
    flex-wrap:wrap;
}

.back-btn{
    background:#e2e8f0;
    color:#0f172a;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-size:14px;
    font-weight:500;
    transition:0.3s ease;
}

.back-btn:hover{
    background:#cbd5e1;
}

.save-btn{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    border:none;
    padding:12px 20px;
    border-radius:10px;
    cursor:pointer;
    font-size:14px;
    font-weight:500;
    transition:0.3s ease;
    box-shadow:0 4px 10px rgba(37,99,235,0.3);
}

.save-btn:hover{
    transform:translateY(-2px);
    opacity:0.95;
}

@media(max-width:768px){

    body{
        padding:20px;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:span 1;
    }

    .header h2{
        font-size:24px;
    }

    .actions{
        justify-content:stretch;
    }

    .actions a,
    .actions button{
        width:100%;
        text-align:center;
    }

}

</style>

</head>

<body>

<div class="container">

    <div class="card">

        <div class="header">

            <h2>
                <i class="fa-solid fa-file-circle-check"></i>
                Issue Clearance
            </h2>

            <span class="logged-user">

                <i class="fa-solid fa-user-circle"></i>

                Logged in as:
                <strong>
                    <?= $_SESSION['full_name']; ?>
                </strong>

                (<?= $_SESSION['role']; ?>)

            </span>

        </div>

        <form method="POST">

            <div class="form-grid">

                <div class="field full">

                    <label>Select Resident</label>

                    <select name="resident_id" required>

                        <option value="">
                            Choose Resident
                        </option>

                        <?php while($resident = mysqli_fetch_assoc($residents)) { ?>

                            <option value="<?= $resident['resident_id']; ?>">

                                #<?= $resident['resident_id']; ?> -
                                <?= $resident['first_name']; ?>
                                <?= $resident['last_name']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="field full">

                    <label>Clearance Type</label>

                    <input type="text"
                           name="clearance_type"
                           placeholder="Enter clearance type"
                           required>

                </div>

                <div class="field full">

                    <label>Purpose</label>

                    <textarea name="purpose"
                              rows="4"
                              placeholder="Enter purpose"
                              required></textarea>

                </div>

            </div>

            <div class="actions">

                <a href="index.php" class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>

                <button type="submit"
                        name="add"
                        class="save-btn">

                    <i class="fa-solid fa-floppy-disk"></i>
                    Issue Clearance

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>