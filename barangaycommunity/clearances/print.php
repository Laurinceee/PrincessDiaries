<?php

include '../config/database.php';

$id = $_GET['id'];

$query = "

    SELECT

        clearances.*,
        residents.first_name,
        residents.middle_name,
        residents.last_name,
        residents.purok,
        residents.civil_status,
        residents.citizenship

    FROM clearances

    INNER JOIN residents

    ON clearances.resident_id =
    residents.resident_id

    WHERE clearance_id = '$id'

";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Print Clearance</title>

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
    background:#f1f5f9;
    padding:40px;
    color:#0f172a;
}

.print-container{
    max-width:900px;
    margin:auto;
}

.print-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-bottom:20px;
}

.btn{
    border:none;
    padding:12px 20px;
    border-radius:10px;
    font-size:14px;
    font-weight:500;
    cursor:pointer;
    text-decoration:none;
    transition:0.3s ease;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.back-btn{
    background:#e2e8f0;
    color:#0f172a;
}

.back-btn:hover{
    background:#cbd5e1;
}

.print-btn{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    box-shadow:0 5px 15px rgba(37,99,235,0.3);
}

.print-btn:hover{
    transform:translateY(-2px);
}

.document{
    background:#fff;
    border-radius:18px;
    padding:50px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    border-top:8px solid #2563eb;
}

.header{
    text-align:center;
    border-bottom:2px solid #e2e8f0;
    padding-bottom:25px;
    margin-bottom:35px;
}

.header h1{
    font-size:34px;
    color:#0f172a;
    margin-bottom:8px;
}

.header h3{
    color:#2563eb;
    font-weight:600;
    margin-bottom:8px;
}

.header p{
    color:#64748b;
    font-size:14px;
}

.clearance-title{
    text-align:center;
    margin-bottom:35px;
}

.clearance-title h2{
    font-size:30px;
    color:#1e293b;
    letter-spacing:2px;
}

.reference{
    margin-top:10px;
    color:#64748b;
    font-size:14px;
}

.content{
    font-size:17px;
    line-height:2;
    color:#334155;
    text-align:justify;
}

.content strong{
    color:#0f172a;
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-top:30px;
}

.info-box{
    background:#f8fafc;
    padding:18px;
    border-radius:12px;
    border-left:5px solid #2563eb;
}

.info-box h5{
    font-size:13px;
    color:#64748b;
    margin-bottom:8px;
}

.info-box p{
    font-size:15px;
    font-weight:600;
    color:#0f172a;
}

.signature-section{
    margin-top:90px;
    display:flex;
    justify-content:flex-end;
}

.signature-box{
    text-align:center;
    width:280px;
}

.signature-line{
    border-top:2px solid #0f172a;
    margin-bottom:8px;
    padding-top:8px;
    font-weight:600;
}

.signature-title{
    color:#64748b;
    font-size:14px;
}

.footer-note{
    margin-top:50px;
    text-align:center;
    color:#94a3b8;
    font-size:13px;
}

@media print{

    body{
        background:#fff;
        padding:0;
    }

    .print-actions{
        display:none;
    }

    .document{
        box-shadow:none;
        border:none;
        border-radius:0;
    }

}

@media(max-width:768px){

    body{
        padding:20px;
    }

    .document{
        padding:30px 20px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .header h1{
        font-size:26px;
    }

    .clearance-title h2{
        font-size:24px;
    }

}

</style>

</head>

<body>

<div class="print-container">

    <div class="print-actions">

        <a href="index.php" class="btn back-btn">

            <i class="fa-solid fa-arrow-left"></i>
            Back

        </a>

        <button onclick="window.print()" class="btn print-btn">

            <i class="fa-solid fa-print"></i>
            Print Clearance

        </button>

    </div>

    <div class="document">

        <div class="header">

            <h3>
                Republic of the Philippines
            </h3>

            <h1>
                BARANGAY CLEARANCE
            </h1>

            <p>
                Barangay Community Management System
            </p>

        </div>

        <div class="clearance-title">

            <h2>
                CERTIFICATE OF CLEARANCE
            </h2>

            <div class="reference">

                Clearance No:
                <strong>
                    CLR-<?= str_pad($row['clearance_id'], 5, '0', STR_PAD_LEFT); ?>
                </strong>

            </div>

        </div>

        <div class="content">

            <p>

                TO WHOM IT MAY CONCERN:

            </p>

            <br>

            <p>

                This is to certify that

                <strong>

                    <?= $row['first_name']; ?>
                    <?= $row['middle_name']; ?>
                    <?= $row['last_name']; ?>

                </strong>

                is a bonafide resident of

                <strong>
                    <?= $row['purok']; ?>
                </strong>

                and is known to be a person of good moral character
                and law-abiding citizen in this barangay.

            </p>

            <br>

            <p>

                This clearance is being issued upon the request of
                the above-named person for the purpose of

                <strong>
                    <?= $row['purpose']; ?>
                </strong>.

            </p>

        </div>

        <div class="info-grid">

            <div class="info-box">

                <h5>Clearance Type</h5>

                <p>
                    <?= $row['clearance_type']; ?>
                </p>

            </div>

            <div class="info-box">

                <h5>Resident ID</h5>

                <p>
                    #<?= $row['resident_id']; ?>
                </p>

            </div>

            <div class="info-box">

                <h5>Civil Status</h5>

                <p>
                    <?= $row['civil_status']; ?>
                </p>

            </div>

            <div class="info-box">

                <h5>Citizenship</h5>

                <p>
                    <?= $row['citizenship']; ?>
                </p>

            </div>

            <div class="info-box">

                <h5>Issue Date</h5>

                <p>
                    <?= date("F d, Y", strtotime($row['issue_date'])); ?>
                </p>

            </div>

            <div class="info-box">

                <h5>Status</h5>

                <p>
                    <?= $row['status']; ?>
                </p>

            </div>

        </div>

        <div class="signature-section">

            <div class="signature-box">

                <div class="signature-line">

                    Barangay Captain

                </div>

                <div class="signature-title">

                    Authorized Signature

                </div>

            </div>

        </div>

        <div class="footer-note">

            This document was generated electronically from the
            Barangay Community Management System.

        </div>

    </div>

</div>

</body>
</html>