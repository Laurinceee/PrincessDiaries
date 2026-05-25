<?php
session_start();

if($_SESSION['role'] != 'Admin') {
    die("Access Denied");
}

include '../config/database.php';

$residents = mysqli_query($conn, "SELECT * FROM residents");

if(isset($_POST['add'])) {

    $resident_id = $_POST['resident_id'];
    $appointment_date = $_POST['appointment_date'];
    $purpose = $_POST['purpose'];

    $query = "INSERT INTO appointments (
        resident_id,
        appointment_date,
        purpose,
        status
    ) VALUES (
        '$resident_id',
        '$appointment_date',
        '$purpose',
        'Scheduled'
    )";

    mysqli_query($conn, $query);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Appointment</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.full{
    grid-column:span 2;
}

label{
    font-size:13px;
    margin-bottom:5px;
    display:block;
    color:#334155;
}

.field{
    display:flex;
    flex-direction:column;
}

input, select{
    width:100%;
    padding:12px 14px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    outline:none;
    font-size:14px;
    transition:0.3s;
    background:#fff;
}

input:focus, select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,0.15);
}

.actions{
    margin-top:20px;
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

button{
    padding:12px 20px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:500;
    font-size:14px;
}

.save-btn{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;

    display:flex;
    align-items:center;
    gap:8px;

    box-shadow:0 4px 10px rgba(37,99,235,0.3);

    transition:0.3s ease;
}

.save-btn:hover{
    transform:translateY(-2px);
    opacity:0.95;
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

.save-btn:hover{
    transform:translateY(-2px);
    transition:0.3s;
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
    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:span 1;
    }
}

</style>
</head>

<body>

<div class="container">

    <div class="card">

        <div class="header">

    <div>

        <h2>
            <i class="fa-solid fa-calendar-plus"></i>
            Add Appointment
        </h2>

        <!-- <p>
            Create new appointment schedule.
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

</div>

        <form method="POST">

            <div class="form-grid">

                <!-- RESIDENT -->
                <div class="field full">
                    <label>Select Resident</label>
                    <select name="resident_id" required>
                        <option value="">Choose Resident</option>
                        <?php while($r = mysqli_fetch_assoc($residents)) { ?>
                            <option value="<?= $r['resident_id']; ?>">
                                #<?= $r['resident_id']; ?> —
                                <?= $r['first_name']; ?>
                                <?= $r['last_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- DATE -->
                <div class="field">
                    <label>Appointment Date</label>
                    <input type="date" name="appointment_date" required>
                </div>

                <!-- PURPOSE -->
                <div class="field">
                    <label>Purpose</label>
                    <input type="text" name="purpose" placeholder="e.g. Clearance, Consultation" required>
                </div>

            </div>

            <div class="actions">

                <!-- BACK BUTTON -->
                <a href="index.php" class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>

                <!-- SAVE BUTTON -->
                <button type="submit"
                    name="add"
                    class="save-btn">

                <i class="fa-solid fa-floppy-disk"></i>
                Save Appointment

            </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>