<?php
include '../config/database.php';

$id = $_GET['id'];

$query = "
    SELECT appointments.*, residents.first_name, residents.last_name
    FROM appointments
    LEFT JOIN residents
    ON appointments.resident_id = residents.resident_id
    WHERE appointments.appointment_id = '$id'
";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Appointment Details</title>

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

.profile-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

/* HEADER */
.profile-header{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    padding:40px;
    color:white;
    text-align:center;
}

.avatar{
    width:100px;
    height:100px;
    border-radius:50%;
    background:white;
    color:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:40px;
    font-weight:700;
    margin:auto;
    margin-bottom:15px;
}

.profile-header h2{
    font-size:26px;
    margin-bottom:5px;
}

.profile-header p{
    opacity:0.9;
    font-size:14px;
}

/* BODY */
.profile-body{
    padding:30px;
}

.section-title{
    font-size:18px;
    font-weight:600;
    margin-bottom:20px;
    color:#0f172a;
}

/* GRID */
.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.info-card{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:18px;
}

.label{
    font-size:13px;
    color:#64748b;
    margin-bottom:6px;
    display:block;
}

.value{
    font-size:15px;
    font-weight:600;
    color:#0f172a;
}

/* BADGES */
.badge{
    display:inline-block;
    padding:6px 12px;
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

/* ACTIONS */
.actions{
    margin-top:30px;
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.btn{
    text-decoration:none;
    padding:12px 18px;
    border-radius:10px;
    font-size:14px;
    font-weight:500;
    transition:0.3s;
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

/* MOBILE */
@media(max-width:768px){
    body{
        padding:20px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .profile-header{
        padding:30px 20px;
    }
}

</style>

</head>
<body>

<div class="container">

<div class="profile-card">

    <!-- HEADER -->
    <div class="profile-header">

        <div class="avatar">
            <?= strtoupper(substr($row['first_name'] ?? $row['full_name'],0,1)); ?>
        </div>

        <h2>
            <?= $row['first_name'] ? $row['first_name'].' '.$row['last_name'] : $row['full_name']; ?>
        </h2>

        <p>Appointment ID: <?= $row['appointment_id']; ?></p>

    </div>

    <!-- BODY -->
    <div class="profile-body">

        <div class="section-title">
            Appointment Details
        </div>

        <div class="info-grid">

            <div class="info-card">
                <span class="label">Appointment Date</span>
                <div class="value">
                    <?= $row['appointment_date']; ?>
                </div>
            </div>

            <div class="info-card">
                <span class="label">Status</span>

                <?php $status = strtolower($row['status']); ?>

                <span class="badge <?= $status; ?>">
                    <?= $row['status']; ?>
                </span>
            </div>

            <div class="info-card" style="grid-column:span 2;">
                <span class="label">Purpose</span>
                <div class="value">
                    <?= $row['purpose']; ?>
                </div>
            </div>

        </div>

        <!-- BACK BUTTON -->
        <div class="actions">

            <a href="index.php" class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>

        </div>

    </div>

</div>

</div>

</body>
</html>