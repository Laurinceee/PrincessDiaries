<?php
include '../config/database.php';
session_start();

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

$id = $_GET['id'];

$query = "SELECT * FROM residents WHERE resident_id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])) {

    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $contact_no = $_POST['contact_no'];
    $purok = $_POST['purok'];
    $civil_status = $_POST['civil_status'];
    $occupation = $_POST['occupation'];

    $update_query = "UPDATE residents SET
        first_name = '$first_name',
        middle_name = '$middle_name',
        last_name = '$last_name',
        birth_date = '$birth_date',
        gender = '$gender',
        contact_no = '$contact_no',
        purok = '$purok',
        civil_status = '$civil_status',
        occupation = '$occupation'
        WHERE resident_id = '$id'";

    mysqli_query($conn, $update_query);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Resident</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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
}

.header h2{
    font-size:28px;
    color:#0f172a;
}

.badge{
    background:#e0f2fe;
    color:#0369a1;
    padding:6px 12px;
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
    margin-bottom:5px;
    color:#334155;
}

input, select{
    padding:12px 14px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    outline:none;
    font-size:14px;
    transition:0.3s;
}

input:focus, select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,0.15);
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

.update-btn{
    background:linear-gradient(135deg,#0ea5e9,#2563eb);
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
    margin-top:6px;
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
    background:#f8fafc;
    padding:8px 14px;
    border-radius:10px;
    border:1px solid #e2e8f0;
}

.logged-user strong{
    color:#0f172a;
}
.update-btn{
    transition:0.3s ease;
}

.update-btn:hover{
    transform:translateY(-2px);
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

            <i class="fa-solid fa-user-pen"></i>
            Edit Resident

        </h2>

        <p>
            Update resident information and personal details.
        </p>

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

        Resident ID:
        #<?= $row['resident_id']; ?>

    </span>

</div>

    <form method="POST">

        <div class="form-grid">

            <div class="field">
                <label>First Name</label>
                <input type="text" name="first_name" value="<?= $row['first_name']; ?>" required>
            </div>

            <div class="field">
                <label>Middle Name</label>
                <input type="text" name="middle_name" value="<?= $row['middle_name']; ?>">
            </div>

            <div class="field full">
                <label>Last Name</label>
                <input type="text" name="last_name" value="<?= $row['last_name']; ?>" required>
            </div>

            <div class="field">
                <label>Birth Date</label>
                <input type="date" name="birth_date" value="<?= $row['birth_date']; ?>" required>
            </div>

            <div class="field">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="Male" <?= ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?= ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <div class="field">
                <label>Civil Status</label>
                <select name="civil_status" required>
                    <option value="Single" <?= ($row['civil_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
                    <option value="Married" <?= ($row['civil_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                    <option value="Widowed" <?= ($row['civil_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                </select>
            </div>

            <div class="field">
                <label>Contact No</label>
                <input type="text" name="contact_no" value="<?= $row['contact_no']; ?>">
            </div>

            <div class="field">
                <label>Purok</label>
                <input type="text" name="purok" value="<?= $row['purok']; ?>">
            </div>

            <div class="field full">
                <label>Occupation</label>
                <input type="text" name="occupation" value="<?= $row['occupation']; ?>">
            </div>

        </div>

        <div class="actions">

            <a href="index.php" class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>

            <button type="submit" name="update" class="update-btn">

                <i class="fa-solid fa-floppy-disk"></i>
                Update Resident

            </button>

        </div>

    </form>

</div>

</div>

</body>
</html>