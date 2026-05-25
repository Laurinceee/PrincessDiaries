<?php

session_start();

if(!isset($_SESSION['official_id'])) {

    header("Location: ../auth/login.php");
    exit();

}

include '../config/database.php';

$query = "

    SELECT

        clearances.*,
        residents.first_name,
        residents.last_name

    FROM clearances

    INNER JOIN residents

    ON clearances.resident_id =
    residents.resident_id

";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clearance Management</title>

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
            align-items:center;
            flex-wrap:wrap;
        }

        .dashboard-btn{
            background:linear-gradient(135deg,#2563eb,#1d4ed8);
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

        .resident-id{
            background:#dbeafe;
            color:#1d4ed8;
        }

        .approved{
            background:#dcfce7;
            color:#166534;
        }

        .pending{
            background:#fef3c7;
            color:#92400e;
        }

        .released{
            background:#dbeafe;
            color:#1d4ed8;
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
        .print-btn{
        background:#8b5cf6;
        color:#fff;
        }

        .print-btn:hover{
            background:#7c3aed;
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
                <i class="fa-solid fa-file-circle-check"></i>
                Clearance Management
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
                    Issue Clearance

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
                        <th>Clearance Type</th>
                        <th>Purpose</th>
                        <th>Issue Date</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                <?php if(mysqli_num_rows($result) > 0) { ?>

                    <?php while($row = mysqli_fetch_assoc($result)) { ?>

                        <tr>

                            <td data-label="ID">
                                <?= $row['clearance_id']; ?>
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

                            <td data-label="Clearance Type">
                                <?= $row['clearance_type']; ?>
                            </td>

                            <td data-label="Purpose">
                                <?= $row['purpose']; ?>
                            </td>

                            <td data-label="Issue Date">
                                <?= $row['issue_date']; ?>
                            </td>

                            <td data-label="Status">
                                <?php

                                    $statusClass = '';

                                    if($row['status'] == 'Approved') {
                                        $statusClass = 'approved';
                                    } elseif($row['status'] == 'Pending') {
                                        $statusClass = 'pending';
                                    } else {
                                        $statusClass = 'released';
                                    }

                                ?>

                                <span class="badge <?= $statusClass; ?>">
                                    <?= $row['status']; ?>
                                </span>

                            </td>

                            <td data-label="Action">

                                <div class="actions">

                                <?php if($_SESSION['role'] == 'Admin') { ?>

    <a href="edit.php?id=<?= $row['clearance_id']; ?>"
       class="btn edit-btn">

        <i class="fa-solid fa-pen"></i>
        Edit

    </a>

    <a href="delete.php?id=<?= $row['clearance_id']; ?>"
       class="btn delete-btn"
       onclick="return confirm('Delete clearance?')">

        <i class="fa-solid fa-trash"></i>
        Delete

    </a>

<?php } ?>

<?php if(
    $_SESSION['role'] == 'Admin'
    || $_SESSION['role'] == 'Staff'
) { ?>

    <?php if($row['status'] != 'Pending') { ?>

        <a href="print.php?id=<?= $row['clearance_id']; ?>"
           class="btn print-btn"
           target="_blank">

            <i class="fa-solid fa-print"></i>
            Print

        </a>

    <?php } ?>

<?php } ?>

<?php if($_SESSION['role'] == 'Staff') { ?>

    <span class="btn view-only">

        <i class="fa-solid fa-eye"></i>
        Staff Access

    </span>

<?php } ?>

                                </div>

                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>

                        <td colspan="8" class="empty">
                            No clearance records found.
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