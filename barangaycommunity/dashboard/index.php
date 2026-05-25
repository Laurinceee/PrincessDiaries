<?php

include '../config/database.php';


session_start();

if(!isset($_SESSION['official_id'])) {
    header("Location: ../auth/login.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| TOTAL RESIDENTS
|--------------------------------------------------------------------------
*/

$residents_query = "SELECT COUNT(*) AS total_residents
                    FROM residents";

$residents_result = mysqli_query($conn, $residents_query);

$residents = mysqli_fetch_assoc($residents_result);

/*
|--------------------------------------------------------------------------
| TOTAL MALE
|--------------------------------------------------------------------------
*/

$male_query = "SELECT COUNT(*) AS total_male
               FROM residents
               WHERE gender = 'Male'";

$male_result = mysqli_query($conn, $male_query);

$male = mysqli_fetch_assoc($male_result);

/*
|--------------------------------------------------------------------------
| TOTAL FEMALE
|--------------------------------------------------------------------------
*/

$female_query = "SELECT COUNT(*) AS total_female
                 FROM residents
                 WHERE gender = 'Female'";

$female_result = mysqli_query($conn, $female_query);

$female = mysqli_fetch_assoc($female_result);

/*
|--------------------------------------------------------------------------
| TOTAL HEALTH RECORDS
|--------------------------------------------------------------------------
*/

$health_query = "SELECT COUNT(*) AS total_health
                 FROM health_records";

$health_result = mysqli_query($conn, $health_query);

$health = mysqli_fetch_assoc($health_result);

/*
|--------------------------------------------------------------------------
| TOTAL CLEARANCES
|--------------------------------------------------------------------------
*/

$clearance_query = "SELECT COUNT(*) AS total_clearances
                    FROM clearances";

$clearance_result = mysqli_query($conn, $clearance_query);

$clearance = mysqli_fetch_assoc($clearance_result);

/*
|--------------------------------------------------------------------------
| TOTAL APPOINTMENTS
|--------------------------------------------------------------------------
*/

$appointment_query = "SELECT COUNT(*) AS total_appointments FROM appointments";
$appointment_result = mysqli_query($conn, $appointment_query);
$appointment = mysqli_fetch_assoc($appointment_result);

/*
|--------------------------------------------------------------------------
| TOTAL HOUSEHOLDS
|--------------------------------------------------------------------------
*/
$household_query = "SELECT COUNT(*) AS total_households FROM households";
$household_result = mysqli_query($conn, $household_query);
$households = mysqli_fetch_assoc($household_result);

/*
|--------------------------------------------------------------------------
| TOTAL LOGS
|--------------------------------------------------------------------------
*/
$audit_query = "
    SELECT COUNT(*) AS total_logs
    FROM audit_logs
";

$audit_result = mysqli_query($conn, $audit_query);

$audit = mysqli_fetch_assoc($audit_result);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Dashboard</title>



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
    color:#334155;
    padding:40px;
}

.container{
    max-width:1400px;
    margin:auto;
}
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:30px;
    flex-wrap:wrap;
}

.welcome-section h1{
    font-size:34px;
    font-weight:700;
    color:#0f172a;
}

.welcome-section p{
    color:#64748b;
    margin-top:5px;
    margin-bottom:15px;
}

.user-info{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.user-badge{
    background:#e2e8f0;
    color:#0f172a;
    padding:8px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:500;
    display:flex;
    align-items:center;
    gap:8px;
}

.user-badge.role{
    background:#dbeafe;
    color:#1d4ed8;
}

.logout-btn{
    background:linear-gradient(135deg,#ef4444,#dc2626);
    color:#fff;
    text-decoration:none;
    padding:14px 20px;
    border-radius:12px;
    font-size:14px;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:10px;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(239,68,68,0.3);
}

.logout-btn:hover{
    transform:translateY(-3px);
}

.header{
    margin-bottom:30px;
}

.header h1{
    font-size:34px;
    font-weight:700;
    color:#0f172a;
}

.header p{
    color:#64748b;
    margin-top:5px;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));
    gap:20px;
    margin-bottom:30px;
}

.card{
    background:#fff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
    transition:0.3s ease;
    position:relative;
    overflow:hidden;
}

.card:hover{
    transform:translateY(-5px);
}

.card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:6px;
    height:100%;
}

.card.blue::before{
    background:#2563eb;
}

.card.green::before{
    background:#16a34a;
}

.card.pink::before{
    background:#db2777;
}

.card-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.info h5{
    font-size:15px;
    color:#64748b;
    margin-bottom:10px;
}

.info h2{
    font-size:38px;
    color:#0f172a;
}

.icon{
    width:65px;
    height:65px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    color:#fff;
}

.blue .icon{
    background:#2563eb;
}

.green .icon{
    background:#16a34a;
}

.pink .icon{
    background:#db2777;
}

.navigation-card{
    background:#fff;
    border-radius:20px;
    padding:30px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
}

.navigation-card h3{
    margin-bottom:10px;
    color:#0f172a;
}

.navigation-card p{
    color:#64748b;
    margin-bottom:20px;
}

.nav-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    text-decoration:none;
    padding:14px 22px;
    border-radius:12px;
    font-size:15px;
    font-weight:500;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(37,99,235,0.3);
}

.nav-btn:hover{
    transform:translateY(-3px);
}

.footer{
    text-align:center;
    color:#94a3b8;
    font-size:14px;
    padding-top:30px;
    padding-bottom:10px;
}
.card.orange::before{
    background:#f97316;
}

.orange .icon{
    background:#f97316;
}
.orange-btn{
    padding: 14px 22px;
    border-radius: 12px;
    font-size: 15px;
    background:linear-gradient(135deg,#f97316,#ea580c);
    box-shadow:0 5px 15px rgba(249,115,22,0.3);
}

.orange-btn:hover{
    transform:translateY(-3px);
}

.card.purple::before{
    background:#7c3aed;
}

.purple .icon{
    background:#7c3aed;
}

.purple-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    background:linear-gradient(135deg,#7c3aed,#6d28d9);
    color:#fff;
    text-decoration:none;
    padding:14px 22px;
    border-radius:12px;
    font-size:15px;
    font-weight:500;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(124,58,237,0.3);
}

.purple-btn:hover{
    transform:translateY(-3px);
}

.blue-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    background:linear-gradient(135deg,#0ea5e9,#0284c7);
    color:#fff;
    text-decoration:none;
    padding:14px 22px;
    border-radius:12px;
    font-size:15px;
    font-weight:500;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(14,165,233,0.3);
    margin-top:10px;
}

.blue-btn:hover{
    transform:translateY(-3px);
}
.dark-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    background:linear-gradient(135deg,#111827,#1f2937);
    color:#fff;
    text-decoration:none;
    padding:14px 22px;
    border-radius:12px;
    font-size:15px;
    font-weight:500;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(17,24,39,0.3);
    margin-top:10px;
}

.dark-btn:hover{
    transform:translateY(-3px);
}
.card.dark::before{
    background:#111827;
}

.dark .icon{
    background:#111827;
}

.audit-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    background:linear-gradient(135deg,#111827,#374151);
    color:#fff;
    text-decoration:none;
    padding:14px 22px;
    border-radius:12px;
    font-size:15px;
    font-weight:500;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(17,24,39,0.35);
    margin-top:10px;
    position:relative;
    overflow:hidden;
}

.audit-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 20px rgba(17,24,39,0.45);
}

/* .audit-btn::after{
    content:'';
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background:rgba(255,255,255,0.15);
    transition:0.5s;
}

.audit-btn:hover::after{
    left:100%;
} */

    .household-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    background:linear-gradient(135deg,#14b8a6,#0f766e);
    color:#fff;
    text-decoration:none;
    padding:14px 22px;
    border-radius:12px;
    font-size:15px;
    font-weight:500;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(15,118,110,0.35);
    margin-top:10px;
}

.household-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 20px rgba(15,118,110,0.45);
}
.card.teal {
    --accent: #14b8a6;
}

.card.teal::before {
    background: var(--accent);
}

.card.teal .icon {
    background: var(--accent);
}

@media(max-width:768px){

    body{
        padding:20px;
    }

    .header h1{
        font-size:26px;
    }

    .info h2{
        font-size:30px;
    }

}

</style>

</head>

<body>

<div class="container">

    <!-- HEADER -->

<div class="topbar">

    <div class="welcome-section">

        <h1>
            <i class="fa-solid fa-building-user"></i>
            Barangay Community Management System
        </h1>

        <p>
            Monitor and manage barangay resident records efficiently.
        </p>

        <div class="user-info">

            <span class="user-badge">
                <i class="fa-solid fa-user"></i>
                <?= $_SESSION['full_name']; ?>
            </span>

            <span class="user-badge">
                <i class="fa-solid fa-briefcase"></i>
                <?= $_SESSION['position']; ?>
            </span>

            <span class="user-badge role">
                <i class="fa-solid fa-user-shield"></i>
                <?= $_SESSION['role']; ?>
            </span>

        </div>

    </div>

    <a href="../auth/logout.php" class="logout-btn">

        <i class="fa-solid fa-right-from-bracket"></i>
        Logout

    </a>

</div>

    <!-- STATISTICS -->

    <div class="stats-grid">

        <!-- TOTAL RESIDENTS -->

        <div class="card blue">

            <div class="card-content">

                <div class="info">
                    <h5>Total Residents</h5>

                    <h2>
                        <?= $residents['total_residents']; ?>
                    </h2>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-users"></i>
                </div>

            </div>

        </div>

        <!-- TOTAL MALE -->

        <div class="card green">

            <div class="card-content">

                <div class="info">
                    <h5>Total Male</h5>

                    <h2>
                        <?= $male['total_male']; ?>
                    </h2>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-mars"></i>
                </div>

            </div>

        </div>

        <!-- TOTAL FEMALE -->

        <div class="card pink">

            <div class="card-content">

                <div class="info">
                    <h5>Total Female</h5>

                    <h2>
                        <?= $female['total_female']; ?>
                    </h2>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-venus"></i>
                </div>

            </div>

        </div>

        <!-- TOTAL HEALTH RECORDS -->

<div class="card orange">

    <div class="card-content">

        <div class="info">

            <h5>Total Health Records</h5>

            <h2>
                <?= $health['total_health']; ?>
            </h2>

        </div>

        <div class="icon">
            <i class="fa-solid fa-heart-pulse"></i>
        </div>

    </div>

</div>

<!-- TOTAL CLEARANCES -->

<div class="card purple">

    <div class="card-content">

        <div class="info">

            <h5>Total Clearances</h5>

            <h2>
                <?= $clearance['total_clearances']; ?>
            </h2>

        </div>

        <div class="icon">
            <i class="fa-solid fa-file-circle-check"></i>
        </div>

    </div>

</div>
<div class="card blue">
    <div class="card-content">

        <div class="info">
            <h5>Total Appointments</h5>
            <h2><?= $appointment['total_appointments']; ?></h2>
        </div>

        <div class="icon">
            <i class="fa-solid fa-calendar-check"></i>
        </div>

    </div>
</div>
<!-- TOTAL HOUSEHOLDS -->

<div class="card teal">

    <div class="card-content">

        <div class="info">
            <h5>Total Households</h5>

            <h2>
                <?= $households['total_households']; ?>
            </h2>
        </div>

        <div class="icon">
            <i class="fa-solid fa-house"></i>
        </div>

    </div>

</div>
<div class="card dark">

    <div class="card-content">

        <div class="info">

            <h5>Total Audit Logs</h5>

            <h2>
                <?= $audit['total_logs']; ?>
            </h2>

        </div>

        <div class="icon">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>

    </div>

</div>
</div>

    <!-- QUICK NAVIGATION -->

    <div class="navigation-card">

        <h3>
            Quick Navigation
        </h3>

        <p>
            Access resident records and manage barangay information.
        </p>

        <a href="../residents/index.php"
           class="nav-btn">

           <i class="fa-solid fa-address-book"></i>
           Residents Module

        </a>
       <a href="../health_records/index.php"
   class="nav-btn orange-btn">

    <i class="fa-solid fa-heart-pulse"></i>
    Health Records Module

</a>
        <a href="../clearances/index.php"
        class="nav-btn purple-btn">

            <i class="fa-solid fa-file-circle-check"></i>
            Clearance Module

        </a>
       <a href="../appointments/index.php"
            class="nav-btn blue-btn">

            <i class="fa-solid fa-calendar-check"></i>
            Appointments Module

            </a>

    

        <a href="../households/index.php"
   class="household-btn">

    <i class="fa-solid fa-house"></i>
    Household Module

</a>
       <?php if($_SESSION['role'] == 'Admin') { ?>

<a href="../audit_logs/index.php"
   class="audit-btn">

    <i class="fa-solid fa-clock-rotate-left"></i>
    Audit Logs

</a>



<?php } ?>

<a href="../reports/index.php"
        class="dark-btn">

        <i class="fa-solid fa-chart-line"></i>
        Reports Module

        </a>
    </div>

    <!-- FOOTER -->

    <div class="footer">

        Barangay Community Management System © <?= date('Y'); ?>

    </div>

</div>

</body>
</html>