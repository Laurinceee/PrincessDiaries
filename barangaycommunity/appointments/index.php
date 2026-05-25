<?php

session_start();

if(!isset($_SESSION['official_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/database.php';

$query = "

    SELECT
        appointments.*,
        residents.resident_id,
        residents.first_name,
        residents.last_name

    FROM appointments

    LEFT JOIN residents
    ON appointments.resident_id = residents.resident_id

";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Appointment Management</title>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- ICONS -->
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
    max-width:1400px;
    margin:auto;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.header h2{
    font-size:32px;
    color:#0f172a;
    font-weight:700;
}

.logged-user{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:10px;
    font-size:14px;
    color:#64748b;
    background:#fff;
    padding:8px 14px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
}

.logged-user strong{
    color:#0f172a;
}

.header-actions{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 18px;
    border-radius:10px;
    font-size:14px;
    text-decoration:none;
    font-weight:500;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:0.3s ease;
}

.dashboard-btn{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
}

.dashboard-btn:hover{
    transform:translateY(-2px);
}

.add-btn{
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
}

.add-btn:hover{
    transform:translateY(-2px);
}

/* CARD */
.card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#0f172a;
}

thead th{
    color:#fff;
    padding:18px;
    font-size:14px;
    text-align:left;
}

tbody tr{
    border-bottom:1px solid #e2e8f0;
    transition:0.2s;
}

tbody tr:hover{
    background:#f8fafc;
}

tbody td{
    padding:16px 18px;
    font-size:14px;
}

/* BADGES */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
}

.resident-id{
    background:#dbeafe;
    color:#1d4ed8;
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
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.edit-btn{
    background:#0ea5e9;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
}

.edit-btn:hover{
    background:#0284c7;
}

.delete-btn{
    background:#ef4444;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
}

.delete-btn:hover{
    background:#dc2626;
}

.view-only{
    background:#e2e8f0;
    color:#475569;
    padding:8px 12px;
    border-radius:8px;
    font-size:13px;
}
.name {
    font-weight: 600;
    color: #0f172a;
}
td {
    white-space: normal;
    word-break: break-word;
}

.view-btn {
    background:#6366f1;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    display:inline-block;
}

.view-btn:hover {
    background:#4f46e5;
}

/* MOBILE */
@media(max-width:768px){

    body{
        padding:20px;
    }

    thead{
        display:none;
    }

    table, tbody, tr, td{
        display:block;
        width:100%;
    }

    tr{
        margin-bottom:15px;
        background:#fff;
        border-radius:12px;
        box-shadow:0 4px 10px rgba(0,0,0,0.05);
    }

    td{
        padding:12px 15px;
        text-align:right;
        position:relative;
        border-bottom:1px solid #eee;
    }

    td::before{
        content:attr(data-label);
        position:absolute;
        left:15px;
        font-weight:600;
        color:#0f172a;
    }
    

}

</style>

</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">

        <div>

            <h2>
                <i class="fa-solid fa-calendar-check"></i>
                Appointment Management
            </h2>

            <span class="logged-user">

                <i class="fa-solid fa-user-circle"></i>

                Logged in as:
                <strong><?= $_SESSION['full_name']; ?></strong>

                (<?= $_SESSION['role']; ?>)

            </span>

        </div>

        <div class="header-actions">

            <a href="../dashboard/index.php" class="btn dashboard-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Dashboard
            </a>

            <?php if($_SESSION['role'] == 'Admin') { ?>

                <a href="add.php" class="btn add-btn">
                    <i class="fa-solid fa-plus"></i>
                    Add Appointment
                </a>

            <?php } ?>

        </div>

    </div>

    <!-- TABLE -->
    <div class="card">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Resident ID</th>
                    <th>Resident</th>
                    <th>Date</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td data-label="ID">
                        <?= $row['appointment_id']; ?>
                    </td>

                    <td data-label="Resident ID">
                        <span class="badge resident-id">
                            #<?= $row['resident_id']; ?>
                        </span>
                    </td>

                    <td data-label="Resident" class="name">

    <?php if($row['first_name']) { ?>

        <?= $row['first_name']; ?> <?= $row['last_name']; ?>

    <?php } elseif($row['full_name']) { ?>

        <?= $row['full_name']; ?>

    <?php } else { ?>

        <span style="color:#94a3b8;">
            Unknown / Walk-in
        </span>

    <?php } ?>

</td>

                    <td data-label="Date">
                        <?= $row['appointment_date']; ?>
                    </td>

                    <td data-label="Purpose">
                         <a href="view.php?id=<?= $row['appointment_id']; ?>"
                                    class="btn view-btn">
                                <i class="fa-solid fa-eye"></i> View 
                                </a>
                    </td>

                    <td data-label="Status">

                        <?php
                            $class = strtolower($row['status']);
                        ?>

                        <span class="badge <?= $class; ?>">
                            <?= $row['status']; ?>
                        </span>

                    </td>

                    <td data-label="Action">

                        <div class="actions">

                        <?php if($_SESSION['role'] == 'Admin') { ?>

                            <a href="edit.php?id=<?= $row['appointment_id']; ?>"
                                   class="btn edit-btn">

                                   <i class="fa-solid fa-pen"></i> Edit
                                </a>

                            <a href="delete.php?id=<?= $row['appointment_id']; ?>"
                                   class="btn delete-btn"
                                   onclick="return confirm('Delete this resident?')">

                                   <i class="fa-solid fa-trash"></i> Delete
                                </a>

                        <?php } else { ?>

                            <span class="view-only">
                                View Only
                            </span>

                        <?php } ?>

                        </div>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>