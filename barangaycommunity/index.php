<?php

include 'config/database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Barangay Community Management System</title>

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
}

/* HERO SECTION */

.hero{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:50px 20px;
}

.container{
    max-width:1300px;
    width:100%;
}

/* MAIN PORTAL CARD */

.portal-card{
    background:#fff;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,0.08);
    display:grid;
    grid-template-columns:1.1fr 0.9fr;
}

/* LEFT SIDE */

.portal-left{
    padding:60px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    position:relative;
    overflow:hidden;
}

.portal-left::before{
    content:'';
    position:absolute;
    width:350px;
    height:350px;
    border-radius:50%;
    background:rgba(255,255,255,0.08);
    top:-100px;
    right:-100px;
}

.portal-left::after{
    content:'';
    position:absolute;
    width:250px;
    height:250px;
    border-radius:50%;
    background:rgba(255,255,255,0.05);
    bottom:-80px;
    left:-80px;
}

.logo-badge{
    width:85px;
    height:85px;
    border-radius:22px;
    background:rgba(255,255,255,0.15);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:38px;
    margin-bottom:25px;
    backdrop-filter:blur(10px);
}

.portal-left h1{
    font-size:42px;
    line-height:1.2;
    margin-bottom:18px;
    font-weight:700;
    position:relative;
    z-index:2;
}

.portal-left p{
    font-size:16px;
    line-height:1.8;
    color:#dbeafe;
    margin-bottom:35px;
    position:relative;
    z-index:2;
}

/* FEATURES */

.features{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
    position:relative;
    z-index:2;
}

.feature-box{
    background:rgba(255,255,255,0.12);
    border:1px solid rgba(255,255,255,0.15);
    padding:18px;
    border-radius:18px;
    backdrop-filter:blur(10px);
}

.feature-box i{
    font-size:22px;
    margin-bottom:12px;
}

.feature-box h4{
    font-size:15px;
    margin-bottom:8px;
}

.feature-box p{
    font-size:13px;
    margin:0;
    line-height:1.6;
    color:#e2e8f0;
}

/* RIGHT SIDE */

.portal-right{
    padding:60px 45px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.portal-title{
    margin-bottom:35px;
}

.portal-title h2{
    font-size:34px;
    color:#0f172a;
    margin-bottom:12px;
}

.portal-title p{
    color:#64748b;
    line-height:1.7;
}

/* ACTION BUTTONS */

.portal-actions{
    display:flex;
    flex-direction:column;
    gap:18px;
    margin-bottom:35px;
}

.portal-btn{
    text-decoration:none;
    padding:18px 22px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    transition:0.3s ease;
    font-weight:600;
}

.portal-btn:hover{
    transform:translateY(-4px);
}

.portal-btn .left{
    display:flex;
    align-items:center;
    gap:15px;
}

.portal-btn i{
    font-size:22px;
}

.portal-btn small{
    display:block;
    font-size:12px;
    font-weight:400;
    opacity:0.9;
    margin-top:2px;
}

/* BUTTON COLORS */

.admin-btn{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    box-shadow:0 10px 20px rgba(37,99,235,0.25);
}

.appointment-btn{
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
    box-shadow:0 10px 20px rgba(22,163,74,0.25);
}

.clearance-btn{
    background:linear-gradient(135deg,#7c3aed,#6d28d9);
    color:#fff;
    box-shadow:0 10px 20px rgba(124,58,237,0.25);
}

/* INFO CARD */

.info-card{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:25px;
}

.info-card h3{
    font-size:18px;
    color:#0f172a;
    margin-bottom:15px;
}

.info-list{
    display:flex;
    flex-direction:column;
    gap:14px;
}

.info-item{
    display:flex;
    align-items:flex-start;
    gap:12px;
    color:#475569;
    font-size:14px;
    line-height:1.6;
}

.info-item i{
    color:#2563eb;
    margin-top:3px;
}

/* FOOTER */

.footer{
    text-align:center;
    margin-top:25px;
    color:#94a3b8;
    font-size:14px;
}

/* MOBILE */

@media(max-width:1000px){

    .portal-card{
        grid-template-columns:1fr;
    }

    .portal-left,
    .portal-right{
        padding:40px 30px;
    }

}

@media(max-width:768px){

    .portal-left h1{
        font-size:32px;
    }

    .portal-title h2{
        font-size:28px;
    }

    .features{
        grid-template-columns:1fr;
    }

    .portal-btn{
        flex-direction:column;
        align-items:flex-start;
        gap:12px;
    }

}

</style>

</head>

<body>

<section class="hero">

    <div class="container">

        <div class="portal-card">

            <!-- LEFT SIDE -->

            <div class="portal-left">

                <div class="logo-badge">
                    <i class="fa-solid fa-building-user"></i>
                </div>

                <h1>
                    Barangay Community
                    Management System
                </h1>

                <p>
                    A modern digital portal designed to help residents and
                    barangay officials manage appointments, clearances,
                    resident records, and community services efficiently.
                </p>

                <div class="features">

                    <div class="feature-box">

                        <i class="fa-solid fa-address-book"></i>

                        <h4>Resident Profiling</h4>

                        <p>
                            Organized resident information and household records.
                        </p>

                    </div>

                    <div class="feature-box">

                        <i class="fa-solid fa-file-circle-check"></i>

                        <h4>Clearance Issuance</h4>

                        <p>
                            Fast processing and printing of barangay clearances.
                        </p>

                    </div>

                    <div class="feature-box">

                        <i class="fa-solid fa-heart-pulse"></i>

                        <h4>Health Records</h4>

                        <p>
                            Monitor and manage community health information.
                        </p>

                    </div>

                    <div class="feature-box">

                        <i class="fa-solid fa-calendar-check"></i>

                        <h4>Appointments</h4>

                        <p>
                            Residents can request and manage appointments online.
                        </p>

                    </div>

                </div>

            </div>

            <!-- RIGHT SIDE -->

            <div class="portal-right">

                <div class="portal-title">

                    <h2>
                        Resident Service Portal
                    </h2>

                    <p>
                        Welcome to the official barangay online portal.
                        Select a service below to continue.
                    </p>

                </div>

                <div class="portal-actions">

                    <!-- ADMIN LOGIN -->

                    <a href="auth/login.php"
                       class="portal-btn admin-btn">

                        <div class="left">

                            <i class="fa-solid fa-user-shield"></i>

                            <div>

                                Admin / Staff Login

                                <small>
                                    Secure access for barangay officials
                                </small>

                            </div>

                        </div>

                        <i class="fa-solid fa-arrow-right"></i>

                    </a>

                    <!-- APPOINTMENT -->

                    <a href="appointments/request.php"
                       class="portal-btn appointment-btn">

                        <div class="left">

                            <i class="fa-solid fa-calendar-plus"></i>

                            <div>

                                Request Appointment

                                <small>
                                    Schedule a barangay appointment online
                                </small>

                            </div>

                        </div>

                        <i class="fa-solid fa-arrow-right"></i>

                    </a>

                </div>
              <!-- BARANGAY INFORMATION -->

<div class="info-card">

    <h3>
        Barangay Information
    </h3>

    <div class="info-list">

        <div class="info-item">

            <i class="fa-solid fa-location-dot"></i>

            <span>
                Barangay Hall, Purok 1,
                Cavite City, Philippines
            </span>

        </div>

        <div class="info-item">

            <i class="fa-solid fa-phone"></i>

            <span>
                Contact Number:
                0912-345-6789
            </span>

        </div>

        <div class="info-item">

            <i class="fa-solid fa-clock"></i>

            <span>
                Office Hours:
                Monday - Friday
                8:00 AM - 5:00 PM
            </span>

        </div>

        <div class="info-item">

            <i class="fa-solid fa-envelope"></i>

            <span>
                Email:
                barangay@email.com
            </span>

        </div>

    </div>

</div>

            </div>

        </div>

        <!-- FOOTER -->

        <div class="footer">

            Barangay Community Management System © <?= date('Y'); ?>

        </div>

    </div>

</section>

</body>
</html>
