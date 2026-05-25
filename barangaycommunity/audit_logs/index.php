<?php

session_start();

if(!isset($_SESSION['official_id'])) {

    header("Location: ../auth/login.php");
    exit();

}

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

include '../config/database.php';

$query = "
    SELECT *
    FROM audit_logs
    ORDER BY action_date DESC
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Audit Logs</title>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">

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

.header-left h2{
    font-size:32px;
    color:#0f172a;
    font-weight:700;
}

.header-left p{
    margin-top:8px;
    color:#64748b;
    font-size:14px;
}

.logged-user{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:12px;
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
    box-shadow:0 4px 10px rgba(37,99,235,0.3);
}

.dashboard-btn:hover{
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
    vertical-align:top;
}

.log-id{
    font-weight:700;
    color:#0f172a;
}

.audit-badge{
    padding:7px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:6px;
}

.insert{
    background:#dcfce7;
    color:#166534;
}

.update{
    background:#dbeafe;
    color:#1d4ed8;
}

.delete{
    background:#fee2e2;
    color:#b91c1c;
}

.table-name{
    font-weight:600;
    color:#0f172a;
}

.description{
    color:#475569;
    line-height:1.5;
}

.date{
    white-space:nowrap;
    color:#64748b;
}

.no-logs{
    text-align:center;
    padding:40px;
    color:#64748b;
    font-size:15px;
}

@media(max-width:768px){

    body{
        padding:20px;
    }

    .header{
        flex-direction:column;
        align-items:flex-start;
    }

    .header-left h2{
        font-size:26px;
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
        padding:14px 15px;
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

    <div class="header">

        <div class="header-left">

            <h2>
                <i class="fa-solid fa-clock-rotate-left"></i>
                Audit Logs
            </h2>

            <p>
                Monitor all system activities and database transactions
            </p>

            <span class="logged-user">

                <i class="fa-solid fa-user-shield"></i>

                Logged in as:

                <strong>
                    <?= htmlspecialchars($_SESSION['full_name']); ?>
                </strong>

                (<?= $_SESSION['role']; ?>)

            </span>

        </div>

        <a href="../dashboard/index.php"
           class="dashboard-btn">

            <i class="fa-solid fa-arrow-left"></i>
            Dashboard

        </a>

    </div>

    <div class="card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Log ID</th>
                        <th>Action</th>
                        <th>Table</th>
                        <th>Description</th>
                        <th>Date & Time</th>

                    </tr>

                </thead>

                <tbody>

                <?php if(mysqli_num_rows($result) > 0) { ?>

                    <?php while($row = mysqli_fetch_assoc($result)) { ?>

                        <?php

                            $badgeClass = '';
                            $icon = '';

                            if($row['action_type'] == 'INSERT') {

                                $badgeClass = 'insert';
                                $icon = 'fa-plus';

                            } elseif($row['action_type'] == 'UPDATE') {

                                $badgeClass = 'update';
                                $icon = 'fa-pen';

                            } else {

                                $badgeClass = 'delete';
                                $icon = 'fa-trash';

                            }

                        ?>

                        <tr>

                            <td data-label="Log ID"
                                class="log-id">

                                #<?= $row['log_id']; ?>

                            </td>

                            <td data-label="Action">

                                <span class="audit-badge <?= $badgeClass; ?>">

                                    <i class="fa-solid <?= $icon; ?>"></i>

                                    <?= htmlspecialchars($row['action_type']); ?>

                                </span>

                            </td>

                            <td data-label="Table"
                                class="table-name">

                                <?= htmlspecialchars($row['table_name']); ?>

                            </td>

                            <td data-label="Description"
                                class="description">

                                <?= htmlspecialchars($row['description']); ?>

                            </td>

                            <td data-label="Date"
                                class="date">

                                <?= date("F d, Y h:i A",
                                    strtotime($row['action_date'])); ?>

                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>

                        <td colspan="5"
                            class="no-logs">

                            <i class="fa-solid fa-circle-info"></i>
                            No audit logs found.

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