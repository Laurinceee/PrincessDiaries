<?php

include '../config/database.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

if(isset($_POST['add'])) {

    mysqli_begin_transaction($conn);

    try {

        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $birth_date = $_POST['birth_date'];
        $gender = $_POST['gender'];
        $civil_status = $_POST['civil_status'];
        $contact_no = $_POST['contact_no'];
        $purok = $_POST['purok'];
        $occupation = $_POST['occupation'];

        $residentQuery = "

            INSERT INTO residents(

                first_name,
                middle_name,
                last_name,
                birth_date,
                gender,
                civil_status,
                contact_no,
                purok,
                occupation

            )

            VALUES(

                '$first_name',
                '$middle_name',
                '$last_name',
                '$birth_date',
                '$gender',
                '$civil_status',
                '$contact_no',
                '$purok',
                '$occupation'

            )

        ";

        mysqli_query($conn, $residentQuery);

        $resident_id = mysqli_insert_id($conn);

        $healthQuery = "

            INSERT INTO health_records(

                resident_id

            )

            VALUES(

                '$resident_id'

            )

        ";

        mysqli_query($conn, $healthQuery);

        mysqli_commit($conn);

        header("Location: index.php");

    } catch(Exception $e) {

        mysqli_rollback($conn);

        echo "Transaction Failed: "
             . $e->getMessage();

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<title>Add Resident</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
}

.header h2{
    font-size:28px;
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

input,
select{
    width:100%;
    padding:12px 14px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    outline:none;
    font-size:14px;
    transition:0.3s;
}

input:focus,
select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,0.15);
}

label{
    font-size:13px;
    margin-bottom:5px;
    display:block;
    color:#334155;
}

.field{
    display:flex;
    flex-direction:column;
}

.actions{
    margin-top:20px;
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

button{
    padding:12px 20px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:500;
    font-size:14px;
}

.save-btn{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    box-shadow:0 4px 10px rgba(37,99,235,0.3);
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

.save-btn{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    box-shadow:0 4px 10px rgba(37,99,235,0.3);

    display:flex;
    align-items:center;
    gap:8px;

    transition:0.3s ease;
}

.save-btn:hover{
    transform:translateY(-2px);
    opacity:0.95;
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

    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:span 1;
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
            <i class="fa-solid fa-user-plus"></i>
            Add Resident
        </h2>

        <!-- <p>
            Create new resident record.
        </p> -->

        <span class="logged-user">

            <i class="fa-solid fa-user-circle"></i>

            Logged in as:
            <strong>
                <?= $_SESSION['full_name']; ?>
            </strong>

            (<?= $_SESSION['role']; ?>)

        </span>

    </div>

</div>

        <form method="POST">

            <div class="form-grid">

                <div class="field">

                    <label>First Name</label>

                    <input type="text"
                           name="first_name"
                           required placeholder="Enter first name">

                </div>

                <div class="field">

                    <label>Middle Name</label>

                    <input type="text"
                           name="middle_name"
                           placeholder="Enter middle name">

                </div>

                <div class="field full">

                    <label>Last Name</label>

                    <input type="text"
                           name="last_name"
                           required placeholder="Enter last name">

                </div>

                <div class="field">

                    <label>Birth Date</label>

                    <input type="date"
                           name="birth_date"
                           required>

                </div>

                <div class="field">

                    <label>Gender</label>

                    <select name="gender"
                            required>

                        <option value="">
                            Select Gender
                        </option>

                        <option>
                            Male
                        </option>

                        <option>
                            Female
                        </option>

                    </select>

                </div>

                <div class="field">

                    <label>Civil Status</label>

                    <select name="civil_status"
                            required>

                        <option value="">
                            Civil Status
                        </option>

                        <option>
                            Single
                        </option>

                        <option>
                            Married
                        </option>

                        <option>
                            Widowed
                        </option>

                    </select>

                </div>

                <div class="field">

                    <label>Contact No</label>

                    <input type="text"
                           name="contact_no" placeholder="09XXXXXXXXXX">

                </div>

                <div class="field">

                    <label>Purok</label>

                    <input type="text"
                           name="purok" placeholder="Enter purok">

                </div>

                <div class="field full">

                    <label>Occupation</label>

                    <input type="text"
                           name="occupation" placeholder="Enter occupation">

                </div>

            </div>

            <div class="actions">

                <a href="index.php" class="back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </a>

                <button type="submit"
                    name="add"
                    class="save-btn">

                <i class="fa-solid fa-floppy-disk"></i>
                Save Resident

            </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>