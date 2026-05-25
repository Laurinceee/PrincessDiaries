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

/*
|--------------------------------------------------------------------------
| FETCH RESIDENTS
|--------------------------------------------------------------------------
*/

$residents = mysqli_query(

    $conn,

    "SELECT * FROM residents
     ORDER BY last_name ASC"

);

/*
|--------------------------------------------------------------------------
| ADD HOUSEHOLD
|--------------------------------------------------------------------------
*/

if(isset($_POST['add'])) {

    $resident_id = $_POST['resident_id'];
    $house_no   = $_POST['house_no'];
    $street     = $_POST['street'];
    $barangay   = $_POST['barangay'];
    $city       = $_POST['city'];

    $query = "

        INSERT INTO households(

            resident_id,
            house_no,
            street,
            barangay,
            city

        )

        VALUES(

            '$resident_id',
            '$house_no',
            '$street',
            '$barangay',
            '$city'

        )

    ";

    mysqli_query($conn, $query);

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

<title>Add Household</title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">

<!-- FONT AWESOME -->
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
    max-width:900px;
    margin:auto;
}

.card{
    background:#fff;
    border-radius:20px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.header{
    margin-bottom:30px;
}

.header h2{
    font-size:32px;
    color:#0f172a;
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:8px;
}

.header p{
    color:#64748b;
    font-size:14px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.full{
    grid-column:span 2;
}

.field{
    display:flex;
    flex-direction:column;
}

label{
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
    color:#334155;
}

input,
select{
    width:100%;
    padding:14px 15px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    font-size:14px;
    outline:none;
    transition:0.3s ease;
    background:#fff;
}

input:focus,
select:focus{
    border-color:#14b8a6;
    box-shadow:0 0 0 4px rgba(20,184,166,0.15);
}

input::placeholder{
    color:#94a3b8;
}

.actions{
    margin-top:30px;
    display:flex;
    justify-content:flex-end;
    gap:12px;
    flex-wrap:wrap;
}

.back-btn{
    background:#e2e8f0;
    color:#0f172a;
    text-decoration:none;
    padding:13px 22px;
    border-radius:12px;
    font-size:14px;
    font-weight:500;
    display:flex;
    align-items:center;
    gap:8px;
    transition:0.3s ease;
}

.back-btn:hover{
    background:#cbd5e1;
    transform:translateY(-2px);
}

.save-btn{
    border:none;
    background:linear-gradient(135deg,#14b8a6,#0f766e);
    color:#fff;
    padding:13px 24px;
    border-radius:12px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:8px;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(15,118,110,0.3);
}

.save-btn:hover{
    transform:translateY(-2px);
    opacity:0.95;
}

.note-box{
    background:#ecfeff;
    border:1px solid #a5f3fc;
    color:#0f766e;
    padding:14px 16px;
    border-radius:12px;
    font-size:13px;
    margin-bottom:25px;
    display:flex;
    align-items:flex-start;
    gap:10px;
}

.logged-user{
                margin-top:10px;
                display:inline-flex;
                align-items:center;
                gap:8px;
                background:#f1f5f9;
                padding:8px 14px;
                border-radius:10px;
                font-size:13px;
                color:#334155;
}

@media(max-width:768px){

    body{
        padding:20px;
    }

    .card{
        padding:25px;
    }

    .header h2{
        font-size:26px;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:span 1;
    }

    .actions{
        justify-content:stretch;
    }

    .actions a,
    .actions button{
        width:100%;
        justify-content:center;
    }

}

</style>

</head>

<body>

<div class="container">

    <div class="card">

        <!-- HEADER -->

        <div class="header">

            <h2>
                <i class="fa-solid fa-house"></i>
                Add Household
            </h2>

            <!-- <p>
                Create and assign household information to a resident.
            </p> -->

            <span class="logged-user">
        
                <i class="fa-solid fa-user-circle"></i>

                Logged in as:
                <strong>
                    <?= $_SESSION['full_name'] ?? 'Admin'; ?>
                </strong>

                (<?= $_SESSION['role']; ?>)
                </span>
            </div>

    

        <!-- NOTE -->

        <!-- <div class="note-box">

            <i class="fa-solid fa-circle-info"></i>

            <div>

                Select a resident and fill out the household
                address information below.

            </div>

        </div> -->

        <!-- FORM -->

        <form method="POST">

            <div class="form-grid">

                <!-- RESIDENT -->

                <div class="field full">

                    <label>

                        Resident

                    </label>

                    <select name="resident_id"
                            required>

                        <option value="">
                            Select Resident
                        </option>

                        <?php while($r = mysqli_fetch_assoc($residents)) { ?>

                            <option value="<?= $r['resident_id']; ?>">

                                #<?= $r['resident_id']; ?> —
                                <?= $r['last_name']; ?>,
                                <?= $r['first_name']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- HOUSE NO -->

                <div class="field">

                    <label>
                        House No
                    </label>

                    <input type="text"
                           name="house_no"
                           placeholder="Enter house number">

                </div>

                <!-- STREET -->

                <div class="field">

                    <label>
                        Street
                    </label>

                    <input type="text"
                           name="street"
                           placeholder="Enter street name">

                </div>

                <!-- BARANGAY -->

                <div class="field">

                    <label>
                        Barangay
                    </label>

                    <input type="text"
                           name="barangay"
                           value="Barangay Sample">

                </div>

                <!-- CITY -->

                <div class="field">

                    <label>
                        City / Municipality
                    </label>

                    <input type="text"
                           name="city"
                           placeholder="Enter city">

                </div>

            </div>

            <!-- ACTIONS -->

            <div class="actions">

                <a href="index.php"
                   class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>

                <button type="submit"
                        name="add"
                        class="save-btn">

                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Household

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>