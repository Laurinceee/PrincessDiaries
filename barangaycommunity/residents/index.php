<?php

session_start();

if(!isset($_SESSION['official_id'])) {

    header("Location: ../auth/login.php");

    exit();
}

include '../config/database.php';


// $query = "SELECT * FROM residents ORDER BY resident_id DESC";
$query = "SELECT * FROM residents";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Management</title>

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
        }

        .header h2{
            font-size:32px;
            color:#1e293b;
            font-weight:700;
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

        .actions{
            display:flex;
            gap:10px;
        }

        .btn{
            padding:8px 14px;
            border-radius:8px;
            text-decoration:none;
            font-size:13px;
            font-weight:500;
            transition:0.3s ease;
        }

        .view-btn{
            background:#6366f1;
            color:#fff;
        }

        .view-btn:hover{
            background:#4f46e5;
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

        .empty{
            text-align:center;
            padding:40px;
            color:#64748b;
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
        }
        .dashboard-btn{
                background:linear-gradient(135deg,#2563eb,#1d4ed8);
                color:#fff;
                text-decoration:none;
                padding:12px 20px;
                border-radius:10px;
                font-size:15px;
                font-weight: 500 ;
                display:flex;
                align-items:center;
                gap:8px;
                transition:0.3s ease;
                box-shadow:0 4px 10px rgba(0,0,0,0.04);
            }

            .dashboard-btn:hover{
                border-color:#cbd5e1;
                transform:translateY(-2px);
                box-shadow:0 6px 14px rgba(0,0,0,0.08);
            }
            .header-actions{
                display:flex;
                gap:12px;
                align-items:center;
                justify-content:flex-end;
                flex-shrink:0;
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

        @media(max-width:768px){

            body{
                padding:20px;
            }

            .header{
                flex-direction:column;
                align-items:flex-start;
                gap:15px;
            }

            .header h2{
                font-size:24px;
            }
            
            .header-actions{
                display:flex;
                gap:12px;
                align-items:center;
                flex-wrap:wrap;
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
            <i class="fa-solid fa-users"></i>
            Resident Management
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

        <!-- BACK TO DASHBOARD -->

        <a href="../dashboard/index.php"
           class="dashboard-btn">

            <i class="fa-solid fa-arrow-left"></i>
            Dashboard

        </a>

        <!-- ADD BUTTON -->

        <?php if($_SESSION['role'] == 'Admin') { ?>

        <a href="add.php" class="add-btn">

            <i class="fa-solid fa-plus"></i>
            Add Resident

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
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Civil Status</th>
                        <th>Occupation</th>
                        <th>Contact</th>
                        <th>Purok</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php if(mysqli_num_rows($result) > 0) { ?>

                    <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <tr>

                        <td data-label="ID">
                            <?= $row['resident_id']; ?>
                        </td>

                        <td data-label="Full Name" class="name">
                            <?= $row['first_name']; ?>
                            <?= $row['middle_name']; ?>
                            <?= $row['last_name']; ?>
                        </td>

                        <td data-label="Gender">

                            <?php
                                $genderClass =
                                strtolower($row['gender']) == 'male'
                                ? 'male'
                                : 'female';
                            ?>

                            <span class="badge <?= $genderClass; ?>">
                                <?= $row['gender']; ?>
                            </span>

                        </td>

                        <td data-label="Civil Status">

                            <?php
                                $statusClass =
                                strtolower($row['civil_status']) == 'married'
                                ? 'married'
                                : 'single';
                            ?>

                            <span class="badge <?= $statusClass; ?>">
                                <?= $row['civil_status']; ?>
                            </span>

                        </td>

                        <td data-label="Occupation">
                            <?= $row['occupation']; ?>
                        </td>

                        <td data-label="Contact">
                            <?= $row['contact_no']; ?>
                        </td>

                        <td data-label="Purok">
                            <?= $row['purok']; ?>
                        </td>

                        <td data-label="Action">

                            <div class="actions">

                                <a href="view.php?id=<?= $row['resident_id']; ?>"
                                    class="btn view-btn">
                                <i class="fa-solid fa-eye"></i> View
                                </a>

                            <?php if($_SESSION['role'] == 'Admin') { ?>

                                <a href="edit.php?id=<?= $row['resident_id']; ?>"
                                   class="btn edit-btn">

                                   <i class="fa-solid fa-pen"></i> Edit
                                </a>

                                <a href="delete.php?id=<?= $row['resident_id']; ?>"
                                   class="btn delete-btn"
                                   onclick="return confirm('Delete this resident?')">

                                   <i class="fa-solid fa-trash"></i> Delete
                                </a>
                                <?php } ?>

                            </div>

                        </td>

                    </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>
                        <td colspan="8" class="empty">
                            No residents found.
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