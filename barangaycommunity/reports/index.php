<?php

session_start();

if(!isset($_SESSION['official_id'])) {

    header("Location: ../auth/login.php");
    exit();

}

include '../config/database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>System Reports</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:15px;
}

.header h2{
    font-size:32px;
    color:#0f172a;
    font-weight:700;
}

.btn{
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
    font-size:14px;
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

/* REPORT CARD */

.report-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    margin-bottom:30px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.report-header{
    padding:18px 25px;
    color:#fff;
    font-size:18px;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:10px;
}

.blue{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
}

.green{
    background:linear-gradient(135deg,#16a34a,#15803d);
}

.orange{
    background:linear-gradient(135deg,#f59e0b,#d97706);
}

.red{
    background:linear-gradient(135deg,#ef4444,#dc2626);
}

.dark{
    background:linear-gradient(135deg,#334155,#0f172a);
}

/* TABLE */

.table-container{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#f8fafc;
}

thead th{
    padding:16px;
    font-size:14px;
    text-align:left;
    color:#0f172a;
    border-bottom:1px solid #e2e8f0;
}

tbody td{
    padding:16px;
    border-bottom:1px solid #e2e8f0;
    font-size:14px;
}

tbody tr:hover{
    background:#f8fafc;
}

/* BADGES */

.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
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
.name{
            font-weight:600;
            color:#0f172a;
        }

/* MOBILE */

@media(max-width:768px){

    body{
        padding:20px;
    }

    .header{
        flex-direction:column;
        align-items:flex-start;
    }

    .header h2{
        font-size:26px;
    }

    table{
        min-width:700px;
    }

}

</style>

</head>

<body>

<div class="container">

    <!-- HEADER -->

    <div class="header">

        <h2>
            <i class="fa-solid fa-chart-line"></i>
            System Reports
        </h2>

        <a href="../dashboard/index.php"
           class="btn dashboard-btn">

            <i class="fa-solid fa-arrow-left"></i>
            Dashboard

        </a>

    </div>

    <!-- REPORT 1 -->

    <div class="report-card">

        <div class="report-header blue">
            <i class="fa-solid fa-heart-pulse"></i>
            Residents with Health Records
        </div>

        <div class="table-container">

            <?php

            $query1 = "

                SELECT
                    residents.first_name,
                    residents.last_name,
                    health_records.blood_type,
                    health_records.medical_condition

                FROM residents

                INNER JOIN health_records

                ON residents.resident_id =
                health_records.resident_id

            ";

            $result1 = mysqli_query($conn, $query1);

            ?>

            <table>

                <thead>

                    <tr>
                        <th>Name</th>
                        <th>Blood Type</th>
                        <th>Medical Condition</th>
                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result1)) { ?>

                    <tr>

                        <td data-label="Name" class="name">
                            <?= $row['first_name']; ?>
                            <?= $row['last_name']; ?>
                        </td>

                        <td><?= $row['blood_type']; ?></td>

                        <td><?= $row['medical_condition']; ?></td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- REPORT 2 -->

    <div class="report-card">

        <div class="report-header green">
            <i class="fa-solid fa-users"></i>
            Total Residents per Gender
        </div>

        <div class="table-container">

            <?php

            $query2 = "

                SELECT
                    gender,
                    COUNT(*) AS total

                FROM residents

                GROUP BY gender

            ";

            $result2 = mysqli_query($conn, $query2);

            ?>

            <table>

                <thead>

                    <tr>
                        <th>Gender</th>
                        <th>Total</th>
                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result2)) { ?>

                    <tr>

                        <td data-label="Gender" class="name"><?= $row['gender']; ?></td>

                        <td><?= $row['total']; ?></td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- REPORT 3 -->

    <div class="report-card">

        <div class="report-header orange">
            <i class="fa-solid fa-calendar-check"></i>
            Residents with Appointments
        </div>

        <div class="table-container">

            <?php

            $query3 = "

                SELECT
                    residents.first_name,
                    residents.last_name,
                    appointments.appointment_date,
                    appointments.status

                FROM appointments

                INNER JOIN residents

                ON appointments.resident_id =
                residents.resident_id

            ";

            $result3 = mysqli_query($conn, $query3);

            ?>

            <table>

                <thead>

                    <tr>
                        <th>Name</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result3)) { ?>

                    <tr>

                        <td data-label="Name" class="name">
                            <?= $row['first_name']; ?>
                            <?= $row['last_name']; ?>
                        </td>

                        <td><?= $row['appointment_date']; ?></td>

                        <td>

                            <?php
                            $status = strtolower($row['status']);
                            ?>

                            <span class="badge <?= $status; ?>">
                                <?= $row['status']; ?>
                            </span>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- REPORT 4 -->

    <div class="report-card">

        <div class="report-header red">
            <i class="fa-solid fa-circle-xmark"></i>
            Residents without Health Records
        </div>

        <div class="table-container">

            <?php

            $query4 = "

                SELECT
                    first_name,
                    last_name

                FROM residents

                WHERE resident_id NOT IN (

                    SELECT resident_id
                    FROM health_records

                )

            ";

            $result4 = mysqli_query($conn, $query4);

            ?>

            <table>

                <thead>

                    <tr>
                        <th>Name</th>
                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result4)) { ?>

                    <tr>

                        <td data-label="Name" class="name">
                            <?= $row['first_name']; ?>
                            <?= $row['last_name']; ?>
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- REPORT 5 -->

    <div class="report-card">

        <div class="report-header dark">
            <i class="fa-solid fa-file-circle-check"></i>
            Clearance Count per Resident
        </div>

        <div class="table-container">

            <?php

            $query5 = "

                SELECT

                    residents.first_name,
                    residents.last_name,

                    COUNT(clearances.clearance_id)
                    AS total_clearances

                FROM residents

                LEFT JOIN clearances

                ON residents.resident_id =
                clearances.resident_id

                GROUP BY residents.resident_id

            ";

            $result5 = mysqli_query($conn, $query5);

            ?>

            <table>

                <thead>

                    <tr>
                        <th>Name</th>
                        <th>Total Clearances</th>
                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result5)) { ?>

                    <tr>

                        <td data-label="Name" class="name">
                            <?= $row['first_name']; ?>
                            <?= $row['last_name']; ?>
                        </td>

                        <td><?= $row['total_clearances']; ?></td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>