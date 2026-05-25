<?php

include '../config/database.php';
session_start();

$id = $_GET['id'];

$query = "SELECT * FROM residents
          WHERE resident_id = '$id'";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Resident Profile</title>

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
    font-size:28px;
    margin-bottom:5px;
}

.profile-header p{
    opacity:0.9;
    font-size:14px;
}

.profile-body{
    padding:30px;
}

.section-title{
    font-size:18px;
    font-weight:600;
    margin-bottom:20px;
    color:#0f172a;
}

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
    transition:0.3s;
}

.info-card:hover{
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.label{
    font-size:13px;
    color:#64748b;
    margin-bottom:6px;
    display:block;
}

.value{
    font-size:16px;
    font-weight:600;
    color:#0f172a;
}

.badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.male{
    background:#dbeafe;
    color:#1d4ed8;
}

.female{
    background:#fce7f3;
    color:#be185d;
}

.single{
    background:#fef3c7;
    color:#92400e;
}

.married{
    background:#dcfce7;
    color:#166534;
}

.widowed{
    background:#ede9fe;
    color:#6d28d9;
}

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

.edit-btn{
    background:linear-gradient(135deg,#0ea5e9,#2563eb);
    color:white;
    box-shadow:0 4px 10px rgba(37,99,235,0.3);
}

.btn:hover{
    transform:translateY(-2px);
}

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

    .profile-header h2{
        font-size:22px;
    }

}

</style>

</head>
<body>

<div class="container">

<div class="profile-card">

    <div class="profile-header">

        <div class="avatar">
            <?= strtoupper(substr($row['first_name'],0,1)); ?>
        </div>

        <h2>
            <?= $row['first_name']; ?>
            <?= $row['middle_name']; ?>
            <?= $row['last_name']; ?>
        </h2>

        <p>Resident ID: <?= $row['resident_id']; ?></p>

    </div>

    <div class="profile-body">

        <div class="section-title">
            Resident Information
        </div>

        <div class="info-grid">

            <div class="info-card">
                <span class="label">Birth Date</span>
                <div class="value">
                    <?= $row['birth_date']; ?>
                </div>
            </div>

            <div class="info-card">
                <span class="label">Gender</span>

                <?php
                    $genderClass =
                    strtolower($row['gender']) == 'male'
                    ? 'male'
                    : 'female';
                ?>

                <span class="badge <?= $genderClass; ?>">
                    <?= $row['gender']; ?>
                </span>
            </div>

            <div class="info-card">
                <span class="label">Civil Status</span>

                <?php

                $status = strtolower($row['civil_status']);

                $statusClass = 'single';

                if($status == 'married'){
                    $statusClass = 'married';
                }

                if($status == 'widowed'){
                    $statusClass = 'widowed';
                }

                ?>

                <span class="badge <?= $statusClass; ?>">
                    <?= $row['civil_status']; ?>
                </span>
            </div>

            <div class="info-card">
                <span class="label">Contact Number</span>
                <div class="value">
                    <?= $row['contact_no']; ?>
                </div>
            </div>

            <div class="info-card">
                <span class="label">Purok</span>
                <div class="value">
                    <?= $row['purok']; ?>
                </div>
            </div>

            <div class="info-card">
                <span class="label">Occupation</span>
                <div class="value">
                    <?= $row['occupation']; ?>
                </div>
            </div>

            <div class="info-card">
                <span class="label">Citizenship</span>
                <div class="value">
                    <?= $row['citizenship']; ?>
                </div>
            </div>

            <div class="info-card">
                <span class="label">Date Registered</span>
                <div class="value">
                    <?= $row['date_registered']; ?>
                </div>
            </div>

        </div>

        <div class="actions">

            <a href="index.php" class="back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </a>

        <?php if($_SESSION['role'] == 'Admin') { ?>
            <a href="edit.php?id=<?= $row['resident_id']; ?>"
               class="btn edit-btn">

               Edit Resident
            </a>
            <?php } ?>

        </div>

    </div>

</div>

</div>

</body>
</html>