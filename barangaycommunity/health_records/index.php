<?php

session_start();

if(!isset($_SESSION['official_id'])) {

    header("Location: ../auth/login.php");
    exit();

}

include '../config/database.php';

$query = "

    SELECT
        health_records.*,
        residents.first_name,
        residents.last_name

    FROM health_records

    INNER JOIN residents
    ON health_records.resident_id = residents.resident_id

";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Records</title>

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
            max-width:1400px;
            margin:auto;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            gap:20px;
            flex-wrap:wrap;
        }

        .header h2{
            font-size:32px;
            color:#1e293b;
            font-weight:700;
        }

        .logged-user{
                display:inline-flex;
                align-items:center;
                gap:8px;
                margin-top:8px;
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
            align-items:center;
            flex-wrap:wrap;
        }

        .dashboard-btn{
            background:linear-gradient(135deg,#2563eb,#1d4ed8);
            border:1px solid #e2e8f0;
            color:#fff;
            text-decoration:none;
            padding:12px 20px;
            border-radius:10px;
            font-size:15px;
            font-weight:500;
            display:flex;
            align-items:center;
            gap:8px;
            transition:0.3s ease;
            box-shadow:0 4px 10px rgba(0,0,0,0.04);
        }

        .dashboard-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 6px 14px rgba(0,0,0,0.08);
        }

        .add-btn{
            background:linear-gradient(135deg,#16a34a,#15803d);
            color:#fff;
            text-decoration:none;
            padding:12px 20px;
            border-radius:10px;
            font-size:15px;
            font-weight:500;
            transition:0.3s ease;
            box-shadow:0 4px 10px rgba(37,99,235,0.3);
        }

        .add-btn:hover{
            transform:translateY(-2px);
            opacity:0.95;
        }

        .card{
            background:#fff;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,0.08);
        }

        .table-wrapper{
            overflow-x:auto;
        }

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
            text-align:left;
            font-size:14px;
            font-weight:600;
            letter-spacing:0.5px;
        }

        tbody tr{
            transition:0.2s ease;
            border-bottom:1px solid #e2e8f0;
        }

        tbody tr:hover{
            background:#f8fafc;
        }

        tbody td{
            padding:16px 18px;
            font-size:14px;
            color:#334155;
        }

        .name{
            font-weight:600;
            color:#0f172a;
        }

        .badge{
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
            display:inline-block;
        }

        .vaccinated{
            background:#dcfce7;
            color:#166534;
        }

        .not-vaccinated{
            background:#fee2e2;
            color:#991b1b;
        }

        .actions{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
        }

        .btn{
            display:flex;
            align-items:center;
            gap:6px;
            padding:8px 14px;
            border-radius:8px;
            text-decoration:none;
            font-size:13px;
            font-weight:500;
            transition:0.3s ease;
        }

        .edit-btn{
            background:#0ea5e9;
            color:#fff;
        }

        .edit-btn:hover{
            background:#0284c7;
        }

        .delete-btn{
            background:#ef4444;
            color:#fff;
        }

        .delete-btn:hover{
            background:#dc2626;
        }

        .view-only{
            background:#e2e8f0;
            color:#475569;
        }

        .empty{
            text-align:center;
            padding:40px;
            color:#64748b;
        }
        .resident-id{
            background:#dbeafe;
            color:#1d4ed8;
        }

        @media(max-width:768px){

            body{
                padding:20px;
            }

            .header{
                flex-direction:column;
                align-items:flex-start;
            }

            .header h2{
                font-size:24px;
            }

            thead{
                display:none;
            }

            table,
            tbody,
            tr,
            td{
                display:block;
                width:100%;
            }

            tr{
                margin-bottom:15px;
                background:#fff;
                border-radius:12px;
                overflow:hidden;
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

            .actions{
                justify-content:flex-end;
            }
        }

    </style>
</head>
<body>

<div class="container">

    <div class="header">

        <div>

            <h2>
                <i class="fa-solid fa-heart-pulse"></i>
                Health Records
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

        <div class="header-actions">

            <a href="../dashboard/index.php"
               class="dashboard-btn">

                <i class="fa-solid fa-arrow-left"></i>
                Dashboard

            </a>

            <?php if($_SESSION['role'] == 'Admin') { ?>

                <a href="add.php"
                   class="add-btn">

                    <i class="fa-solid fa-plus"></i>
                    Add Record

                </a>

            <?php } ?>

        </div>

    </div>

    <div class="card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Resident ID</th>
                        <th>Resident</th>
                        <th>Blood Type</th>
                        <th>Medical Condition</th>
                        <th>Vaccination</th>
                        <th>Last Checkup</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                <?php if(mysqli_num_rows($result) > 0) { ?>

                    <?php while($row = mysqli_fetch_assoc($result)) { ?>

                        <tr>

                            <td data-label="ID">
                                <?= $row['record_id']; ?>
                            </td>

                            <td data-label="Resident ID">

                            <span class="badge resident-id">
                                #<?= $row['resident_id']; ?>
                            </span>

                        </td>

                        <td data-label="Resident" class="name">

                            <?= $row['first_name']; ?>
                            <?= $row['last_name']; ?>

                        </td>

                            <td data-label="Blood Type">
                                <?= $row['blood_type']; ?>
                            </td>

                            <td data-label="Medical Condition">
                                <?= $row['medical_condition']; ?>
                            </td>

                            <td data-label="Vaccination">

                                <?php
                                    $vaccineClass =
                                    strtolower($row['vaccination_status']) == 'vaccinated'
                                    ? 'vaccinated'
                                    : 'not-vaccinated';
                                ?>

                                <span class="badge <?= $vaccineClass; ?>">

                                    <?= $row['vaccination_status']; ?>

                                </span>

                            </td>

                            <td data-label="Last Checkup">
                                <?= $row['last_checkup']; ?>
                            </td>

                            <td data-label="Action">

                                <div class="actions">

                                <?php if($_SESSION['role'] == 'Admin') { ?>

                                    <a href="edit.php?id=<?= $row['record_id']; ?>"
                                       class="btn edit-btn">

                                        <i class="fa-solid fa-pen"></i>
                                        Edit

                                    </a>

                                    <a href="delete.php?id=<?= $row['record_id']; ?>"
                                       class="btn delete-btn"
                                       onclick="return confirm('Delete this record?')">

                                        <i class="fa-solid fa-trash"></i>
                                        Delete

                                    </a>

                                <?php } else { ?>

                                    <span class="btn view-only">

                                        <i class="fa-solid fa-eye"></i>
                                        View Only

                                    </span>

                                <?php } ?>

                                </div>

                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>

                        <td colspan="7" class="empty">
                            No health records found.
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>