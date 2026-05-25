<?php

include '../config/database.php';

if(isset($_POST['request'])) {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $appointment_date = $_POST['appointment_date'];

    $purpose_select = $_POST['purpose_select'];

    // FINAL PURPOSE LOGIC
    if($purpose_select === "others") {

        $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);

        if(empty($purpose)) {
            die("Please specify your purpose.");
        }

    } else {

        $purpose = mysqli_real_escape_string($conn, $purpose_select);

    }

    $query = "
        INSERT INTO appointments(
            full_name,
            contact_number,
            appointment_date,
            purpose,
            status
        )
        VALUES(
            '$full_name',
            '$contact_number',
            '$appointment_date',
            '$purpose',
            'Scheduled'
        )
    ";

    mysqli_query($conn, $query);

    $success = "Your appointment request has been submitted successfully.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Barangay Appointment Request</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:25px;
}

.container{
    width:100%;
    max-width:550px;
}

.card{
    background:#fff;
    border-radius:22px;
    padding:35px;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
}

.header{
    text-align:center;
    margin-bottom:25px;
}

.logo{
    width:75px;
    height:75px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    border-radius:20px;
    margin:auto;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:32px;
    margin-bottom:15px;
}

.header h1{
    font-size:28px;
    color:#0f172a;
    margin-bottom:8px;
}

.header p{
    color:#64748b;
    font-size:14px;
    line-height:1.6;
}

.alert{
    background:#dcfce7;
    color:#166534;
    padding:14px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:14px;
    text-align:center;
}

.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
    color:#334155;
}

.input-box{
    position:relative;
}

.input-box i{
    position:absolute;
    left:14px;
    top:15px;
    color:#94a3b8;
    font-size:14px;
}

input, select, textarea{
    width:100%;
    padding:13px 14px 13px 42px;
    border:1px solid #e2e8f0;
    border-radius:12px;
    font-size:14px;
    outline:none;
    transition:0.3s ease;
}

textarea{
    min-height:110px;
    resize:none;
}

input:focus, select:focus, textarea:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,0.12);
}

.submit-btn{
    width:100%;
    border:none;
    padding:14px;
    border-radius:14px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
}

.submit-btn:hover{
    transform:translateY(-2px);
}

.note{
    margin-top:18px;
    background:#eff6ff;
    padding:14px;
    border-radius:12px;
    color:#1e40af;
    font-size:13px;
}

.footer{
    text-align:center;
    margin-top:20px;
    font-size:13px;
}

.footer a{
    color:#2563eb;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

    <div class="header">

        <div class="logo">
            <i class="fa-solid fa-calendar-check"></i>
        </div>

        <h1>Appointment Request</h1>

        <p>Submit your barangay appointment request online.</p>

    </div>

    <?php if(isset($success)) { ?>
        <div class="alert">
            <i class="fa-solid fa-circle-check"></i>
            <?= $success; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="form-group">

            <label>Full Name</label>

            <div class="input-box">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="full_name" 
                placeholder="Enter your full name"
                required>
            </div>

        </div>

        <div class="form-group">

            <label>Contact Number</label>

            <div class="input-box">
                <i class="fa-solid fa-phone"></i>
                <input type="text" name="contact_number" 
                placeholder="09XXXXXXXXX"
                           required>
            </div>

        </div>

        <div class="form-group">

            <label>Appointment Date</label>

            <div class="input-box">
                <i class="fa-solid fa-calendar"></i>
                <input type="date" name="appointment_date" required>
            </div>

        </div>

        <div class="form-group">

            <label>Select Purpose</label>

            <div class="input-box">
                <i class="fa-solid fa-list"></i>

                <select name="purpose_select" id="purpose_select" required>
                    <option value="">Select Purpose</option>
                    <option value="Resident Registration">Resident Registration</option>
                    <option value="Barangay Clearance">Barangay Clearance</option>
                    <option value="Health Checkup">Health Checkup</option>
                    <option value="Document Verification">Document Verification</option>
                    <option value="others">Others</option>
                </select>

            </div>

        </div>

        <!-- OTHERS FIELD -->
        <div class="form-group" id="otherBox" style="display:none;">

            <label>Specify Purpose</label>

            <div class="input-box">
                <i class="fa-solid fa-pen"></i>

                <textarea name="purpose" id="purpose_text"></textarea>

            </div>

        </div>

        <button type="submit" name="request" class="submit-btn">
            <i class="fa-solid fa-paper-plane"></i>
            Submit Appointment
        </button>

    </form>

    <div class="note">
        Appointment requests are reviewed by barangay staff.
    </div>

    <div class="footer">
        <a href="../index.php">← Back to Homepage</a>
    </div>

</div>

</div>

<script>

document.getElementById("purpose_select").addEventListener("change", function() {

    let otherBox = document.getElementById("otherBox");
    let text = document.getElementById("purpose_text");

    if(this.value === "others") {
        otherBox.style.display = "block";
        text.setAttribute("required", "required");
    } else {
        otherBox.style.display = "none";
        text.removeAttribute("required");
    }

});

</script>

</body>
</html>