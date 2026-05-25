<?php

session_start();

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

include '../config/database.php';

$id = $_GET['id'];

$query = "SELECT * FROM appointments
          WHERE appointment_id = '$id'";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])) {

    $appointment_date = $_POST['appointment_date'];
    $purpose = $_POST['purpose'];
    $status = $_POST['status'];

    $update = "

        UPDATE appointments

        SET

            appointment_date = '$appointment_date',
            purpose = '$purpose',
            status = '$status'

        WHERE appointment_id = '$id'

    ";

    mysqli_query($conn, $update);

    header("Location: index.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Appointment</title>

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
    padding:40px;
    color:#334155;
}

.container{
    max-width:900px;
    margin:auto;
}

.card{
    background:#fff;
    border-radius:20px;
    padding:30px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.header{
    margin-bottom:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
}

.header h2{
    font-size:30px;
    color:#0f172a;
    display:flex;
    align-items:center;
    gap:10px;
}

.header p{
    color:#64748b;
    margin-top:5px;
    font-size:14px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

.full{
    grid-column:span 2;
}

.field{
    display:flex;
    flex-direction:column;
}

label{
    font-size:14px;
    font-weight:500;
    margin-bottom:6px;
    color:#334155;
}

input,
select,
textarea{
    width:100%;
    padding:13px 14px;
    border:1px solid #e2e8f0;
    border-radius:12px;
    outline:none;
    font-size:14px;
    transition:0.3s ease;
    background:#fff;
}

input:focus,
select:focus,
textarea:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,0.15);
}

textarea{
    resize:none;
    min-height:120px;
}

.actions{
    margin-top:25px;
    display:flex;
    justify-content:flex-end;
    gap:12px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    border:none;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:0.3s ease;
}

.back-btn{
    background:#e2e8f0;
    color:#0f172a;
}

.back-btn:hover{
    background:#cbd5e1;
    transform:translateY(-2px);
}

.save-btn{
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
    box-shadow:0 5px 15px rgba(22,163,74,0.25);
}

.save-btn:hover{
    transform:translateY(-2px);
}

.badge{
    display:inline-block;
    padding:8px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.scheduled{
    background:#fef3c7;
    color:#92400e;
}

.completed{
    background:#dcfce7;
    color:#166534;
}

.cancelled{
    background:#fee2e2;
    color:#991b1b;
}

.logged-user{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:12px;
    font-size:14px;
    color:#64748b;
    background:#f8fafc;
    padding:8px 14px;
    border-radius:10px;
    border:1px solid #e2e8f0;
}

.logged-user strong{
    color:#0f172a;
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
        flex-direction:column;
    }

    .btn{
        width:100%;
        justify-content:center;
    }

}

</style>

</head>

<body>

<div class="container">

    <div class="card">

        <!-- HEADER -->

        <div class="header">

    <div>

        <h2>

            <i class="fa-solid fa-pen-to-square"></i>
            Edit Appointment

        </h2>

        <!-- <p>
            Update appointment details and status.
        </p> -->

        <span class="logged-user">

            <i class="fa-solid fa-user-circle"></i>

            Logged in as:
            <strong>
                <?= $_SESSION['full_name']; ?>
            </strong>

            (<?= $_SESSION['role']; ?>)

        </span>

    </div>

    <span class="badge scheduled">

        Appointment ID:
        #<?= $row['appointment_id']; ?>

    </span>

</div>

        <!-- FORM -->

        <form method="POST">

            <div class="form-grid">

                <!-- DATE -->

                <div class="field">

                    <label>Appointment Date</label>

                    <input type="date"
                           name="appointment_date"
                           value="<?= $row['appointment_date']; ?>"
                           required>

                </div>

                <!-- STATUS -->

                <div class="field">

                    <label>Status</label>

                    <select name="status" required>

                        <option value="Scheduled"
                        <?= ($row['status'] == 'Scheduled') ? 'selected' : ''; ?>>

                            Scheduled

                        </option>

                        <option value="Completed"
                        <?= ($row['status'] == 'Completed') ? 'selected' : ''; ?>>

                            Completed

                        </option>

                        <option value="Cancelled"
                        <?= ($row['status'] == 'Cancelled') ? 'selected' : ''; ?>>

                            Cancelled

                        </option>

                    </select>

                </div>

                <!-- PURPOSE -->

                <div class="field full">

                    <label>Purpose</label>

                    <textarea name="purpose"
                              required><?= $row['purpose']; ?></textarea>

                </div>

            </div>

            <!-- ACTIONS -->

            <div class="actions">

                <a href="index.php" class="btn back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>

                <button type="submit"
                        name="update"
                        class="btn save-btn">

                    <i class="fa-solid fa-floppy-disk"></i>
                    Update Appointment

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>