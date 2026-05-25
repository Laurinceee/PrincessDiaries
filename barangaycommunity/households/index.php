<?php

session_start();

if(!isset($_SESSION['official_id'])) {

    header("Location: ../auth/login.php");
    exit();

}

include '../config/database.php';

$query = "

    SELECT

        households.*,
        residents.first_name,
        residents.last_name

    FROM households

    INNER JOIN residents

    ON households.resident_id =
    residents.resident_id

";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Household Management</title>

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
    box-shadow:0 4px 10px rgba(37,99,235,0.3);
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
    display:flex;
    align-items:center;
    gap:8px;
    box-shadow:0 4px 10px rgba(22,163,74,0.3);
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

/* .household-id{
    font-weight:700;
    color:#0f172a;
} */

.resident-name{
    font-weight:600;
    color:#0f172a;
}

.address-badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    background:#dbeafe;
    color:#1d4ed8;
    display:inline-block;
}

.actions{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.btn{
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:500;
    transition:0.3s ease;
    display:flex;
    align-items:center;
    gap:6px;
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
    color:#64748b;
    font-weight:500;
}

.empty{
    text-align:center;
    padding:40px;
    color:#64748b;
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

                <i class="fa-solid fa-house"></i>
                Household Management

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
                Add Household

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
                        <th>House No</th>
                        <th>Street</th>
                        <th>Barangay</th>
                        <th>City</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                <?php if(mysqli_num_rows($result) > 0) { ?>

                    <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <tr>

                        <td data-label="ID"
                                class="household-id">

                                <!--#--><?= $row['household_id']; ?>

                    </td>

                    <td data-label="Resident ID">

                        <span class="address-badge">

                            #<?= $row['resident_id']; ?>

                        </span>

                    </td>

                    <td data-label="Resident"
                        class="resident-name">

                        <?= $row['first_name']; ?>
                        <?= $row['last_name']; ?>

                    </td>

                        <td data-label="House No">

                            <span class="address-badge">

                                <?= $row['house_no']; ?>

                            </span>

                        </td>

                        <td data-label="Street">

                            <?= $row['street']; ?>

                        </td>

                        <td data-label="Barangay">

                            <?= $row['barangay']; ?>

                        </td>

                        <td data-label="City">

                            <?= $row['city']; ?>

                        </td>

                        <td data-label="Action">

                            <div class="actions">

                            <?php if($_SESSION['role'] == 'Admin') { ?>

                                <a href="edit.php?id=<?= $row['household_id']; ?>"
                                   class="btn edit-btn">

                                    <i class="fa-solid fa-pen"></i>
                                    Edit

                                </a>

                                <a href="delete.php?id=<?= $row['household_id']; ?>"
                                   class="btn delete-btn"
                                   onclick="return confirm('Delete household?')">

                                    <i class="fa-solid fa-trash"></i>
                                    Delete

                                </a>

                            <?php } else { ?>

                                <span class="view-only">

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

                        <td colspan="8"
                            class="empty">

                            <i class="fa-solid fa-circle-info"></i>
                            No household records found.

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