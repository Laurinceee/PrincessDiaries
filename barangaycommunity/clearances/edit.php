<?php

session_start();

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

include '../config/database.php';

$id = $_GET['id'];

$query = "

    SELECT
        clearances.*,
        residents.first_name,
        residents.last_name

    FROM clearances

    INNER JOIN residents
    ON clearances.resident_id = residents.resident_id

    WHERE clearances.clearance_id = '$id'

";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])) {

    $status = $_POST['status'];

    $update = "

        UPDATE clearances

        SET status = '$status'

        WHERE clearance_id = '$id'

    ";

    mysqli_query($conn, $update);

    header("Location: index.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Clearance</title>

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
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.header h2{
    font-size:28px;
    color:#0f172a;
    display:flex;
    align-items:center;
    gap:10px;
}

.badge{
    background:#dbeafe;
    color:#1d4ed8;
    padding:8px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.logged-user{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:10px;
    font-size:14px;
    color:#64748b;
    background:#f8fafc;
    padding:8px 14px;
    border-radius:10px;
}

.logged-user strong{
    color:#0f172a;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.full{
    grid-column:span 2;
}

.field{
    display:flex;
    flex-direction:column;
}

label{
    font-size:13px;
    margin-bottom:6px;
    color:#334155;
    font-weight:500;
}

input,
select,
textarea{
    width:100%;
    padding:12px 14px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    outline:none;
    font-size:14px;
    transition:0.3s ease;
    background:#fff;
    resize:none;
}

input:focus,
select:focus,
textarea:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,0.15);
}

.readonly{
    background:#f1f5f9;
    cursor:not-allowed;
}

.actions{
    margin-top:25px;
    display:flex;
    justify-content:flex-end;
    gap:12px;
    flex-wrap:wrap;
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

.update-btn{
    background:linear-gradient(135deg,#0ea5e9,#2563eb);
    color:#fff;
    border:none;
    padding:12px 20px;
    border-radius:10px;
    cursor:pointer;
    font-size:14px;
    font-weight:500;
    transition:0.3s ease;
    box-shadow:0 4px 10px rgba(37,99,235,0.3);
}

.update-btn:hover{
    transform:translateY(-2px);
    opacity:0.95;
}

@media(max-width:768px){

    body{
        padding:20px;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:span 1;
    }

    .header h2{
        font-size:24px;
    }

    .actions{
        justify-content:stretch;
    }

    .actions a,
    .actions button{
        width:100%;
        text-align:center;
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
                <i class="fa-solid fa-pen-to-square"></i>
                Edit Clearance
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

        <span class="badge">
            Clearance ID: <?= $row['clearance_id']; ?>
        </span>

    </div>

    <form method="POST">

        <div class="form-grid">

            <div class="field">

                <label>Resident ID</label>

                <input type="text"
                       value="<?= $row['resident_id']; ?>"
                       readonly
                       class="readonly">

            </div>

            <div class="field">

                <label>Resident Name</label>

                <input type="text"
                       value="<?= $row['first_name']; ?> <?= $row['last_name']; ?>"
                       readonly
                       class="readonly">

            </div>

            <div class="field full">

                <label>Clearance Type</label>

                <input type="text"
                       value="<?= $row['clearance_type']; ?>"
                       readonly
                       class="readonly">

            </div>

            <div class="field full">

                <label>Purpose</label>

                <textarea rows="4"
                          readonly
                          class="readonly"><?= $row['purpose']; ?></textarea>

            </div>

            <div class="field full">

                <label>Status</label>

                <select name="status">

                    <option value="Pending"
                        <?= ($row['status'] == 'Pending') ? 'selected' : ''; ?>>

                        Pending

                    </option>

                    <option value="Approved"
                        <?= ($row['status'] == 'Approved') ? 'selected' : ''; ?>>

                        Approved

                    </option>

                    <option value="Released"
                        <?= ($row['status'] == 'Released') ? 'selected' : ''; ?>>

                        Released

                    </option>

                </select>

            </div>

        </div>

        <div class="actions">

            <a href="index.php" class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>
                Back

            </a>

            <button type="submit"
                    name="update"
                    class="update-btn">

                <i class="fa-solid fa-floppy-disk"></i>
                Update Status

            </button>

        </div>

    </form>

</div>

</div>

</body>
</html>