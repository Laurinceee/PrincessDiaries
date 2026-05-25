<?php

session_start();

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

include '../config/database.php';

$id = $_GET['id'];

$query = "

    SELECT
        households.*,
        residents.first_name,
        residents.last_name

    FROM households

    INNER JOIN residents
    ON households.resident_id = residents.resident_id

    WHERE household_id = '$id'

";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])) {

    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];

    $update = "

        UPDATE households

        SET

            house_no = '$house_no',
            street = '$street',
            barangay = '$barangay',
            city = '$city'

        WHERE household_id = '$id'

    ";

    mysqli_query($conn, $update);

    header("Location: index.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Edit Household</title>

<!-- FONT AWESOME -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
      rel="stylesheet">

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
    flex-wrap:wrap;
    gap:10px;
}

.header h2{
    font-size:28px;
    color:#0f172a;
    display:flex;
    align-items:center;
    gap:10px;
}

.header p{
    margin-top:8px;
    color:#64748b;
    font-size:14px;
}

.badge{
    background:#ccfbf1;
    color:#0f766e;
    padding:8px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
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

input{
    width:100%;
    padding:12px 14px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    outline:none;
    font-size:14px;
    transition:0.3s;
    background:#fff;
}

input:focus{
    border-color:#14b8a6;
    box-shadow:0 0 0 3px rgba(20,184,166,0.15);
}

.resident-box{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    padding:14px 16px;
    border-radius:12px;
}

.resident-box strong{
    color:#0f172a;
    font-size:15px;
}

.resident-box p{
    margin-top:4px;
    color:#64748b;
    font-size:13px;
}

.actions{
    margin-top:25px;
    display:flex;
    justify-content:flex-end;
    gap:10px;
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
    display:flex;
    align-items:center;
    gap:8px;
}

.back-btn:hover{
    background:#cbd5e1;
}

.update-btn{
    border:none;
    padding:12px 22px;
    border-radius:10px;
    background:linear-gradient(135deg,#14b8a6,#0f766e);
    color:#fff;
    font-size:14px;
    font-weight:500;
    cursor:pointer;
    transition:0.3s ease;
    display:flex;
    align-items:center;
    gap:8px;
    box-shadow:0 4px 10px rgba(15,118,110,0.3);
}

.update-btn:hover{
    transform:translateY(-2px);
}
.logged-user{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:12px;
    font-size:14px;
    color:#64748b;
    background:#f8fafc;
    padding:8px 14px;
    border-radius:10px;
    border:1px solid #e2e8f0;
}

.logged-user strong{
    color:#0f172a;
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

    .header{
        flex-direction:column;
        align-items:flex-start;
    }

    .header h2{
        font-size:24px;
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

        <i class="fa-solid fa-house"></i>
        Edit Household

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

                Household ID:
                #<?= $row['household_id']; ?>

            </span>

        </div>

        <form method="POST">

            <div class="form-grid">

                <!-- RESIDENT INFO -->

                <div class="field full">

                    <label>Assigned Resident</label>

                    <div class="resident-box">

                        <strong>

                            #<?= $row['resident_id']; ?> -
                            <?= $row['first_name']; ?>
                            <?= $row['last_name']; ?>

                        </strong>

                        <p>
                            Resident linked to this household.
                        </p>

                    </div>

                </div>

                <!-- HOUSE NO -->

                <div class="field">

                    <label>House No</label>

                    <input type="text"
                           name="house_no"
                           value="<?= $row['house_no']; ?>"
                           placeholder="Enter house number">

                </div>

                <!-- STREET -->

                <div class="field">

                    <label>Street</label>

                    <input type="text"
                           name="street"
                           value="<?= $row['street']; ?>"
                           placeholder="Enter street name">

                </div>

                <!-- BARANGAY -->

                <div class="field">

                    <label>Barangay</label>

                    <input type="text"
                           name="barangay"
                           value="<?= $row['barangay']; ?>">

                </div>

                <!-- CITY -->

                <div class="field">

                    <label>City</label>

                    <input type="text"
                           name="city"
                           value="<?= $row['city']; ?>"
                           placeholder="Enter city">

                </div>

            </div>

            <div class="actions">

                <a href="index.php"
                   class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>

                <button type="submit"
                        name="update"
                        class="update-btn">

                    <i class="fa-solid fa-pen-to-square"></i>
                    Update Household

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>