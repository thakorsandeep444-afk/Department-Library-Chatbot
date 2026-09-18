```php
<?php
/*
|--------------------------------------------------------------------------
| Department Library - Student Library ID Card
|--------------------------------------------------------------------------
| File: student_card.php
|
| This version currently uses demo student data.
| Later, the $student array can be replaced with MySQL data.
|--------------------------------------------------------------------------
*/

// ---------------------------------------------------------
// DEMO STUDENT DATA
// ---------------------------------------------------------

$student = [
    "id"           => "DL2026001",
    "card_number"  => "LIB-BCA-2026-001",
    "name"         => "Student Name",
    "course"       => "Bachelor of Computer Applications",
    "short_course" => "BCA",
    "semester"     => "Semester 5",
    "department"   => "Computer Department",
    "email"        => "student@example.com",
    "phone"        => "+91 00000 00000",
    "academic_year"=> "2026 - 2027",
    "join_date"    => "01 July 2026",
    "valid_until"  => "30 June 2027",
    "status"       => "Active",
    "book_limit"   => "5 Books",
    "photo"        => "",
    "address"      => "Department Library",
    "blood_group"  => "N/A"
];

// ---------------------------------------------------------
// SAFE OUTPUT FUNCTION
// ---------------------------------------------------------

function safe($value)
{
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

// ---------------------------------------------------------
// INITIALS FOR PROFILE AVATAR
// ---------------------------------------------------------

$nameParts = preg_split('/\s+/', trim($student["name"]));

if (count($nameParts) >= 2) {
    $initials = strtoupper(
        substr($nameParts[0], 0, 1) .
        substr($nameParts[count($nameParts) - 1], 0, 1)
    );
} else {
    $initials = strtoupper(substr($student["name"], 0, 2));
}

// ---------------------------------------------------------
// QR DATA
// ---------------------------------------------------------

$qrData = urlencode(
    "Department Library\n" .
    "Student ID: " . $student["id"] . "\n" .
    "Card No: " . $student["card_number"] . "\n" .
    "Name: " . $student["name"]
);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Department Library Student Library ID Card"
    >

    <meta
        name="author"
        content="Department Library"
    >

    <title>
        Student Library ID Card | Department Library
    </title>

    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family:
                "Segoe UI",
                Arial,
                Helvetica,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #eef3f8 0%,
                    #f8fafc 50%,
                    #e9eef5 100%
                );

            min-height: 100vh;

            color: #1e293b;

            padding: 40px 20px;
        }

        button {
            font-family: inherit;
        }

        /* =====================================================
           MAIN WRAPPER
        ===================================================== */

        .page-wrapper {
            width: 100%;
            max-width: 1050px;
            margin: 0 auto;
        }

        /* =====================================================
           TOP NAVIGATION
        ===================================================== */

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            background: rgba(255, 255, 255, 0.95);

            border: 1px solid #e2e8f0;

            border-radius: 18px;

            padding: 16px 22px;

            margin-bottom: 28px;

            box-shadow:
                0 8px 30px rgba(15, 23, 42, 0.07);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-logo {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #173f67,
                    #2563a6
                );

            color: white;

            border-radius: 13px;

            font-size: 23px;

            box-shadow:
                0 5px 14px rgba(31, 78, 121, 0.25);
        }

        .brand-text h2 {
            font-size: 17px;
            color: #173f67;
            margin-bottom: 2px;
        }

        .brand-text p {
            font-size: 12px;
            color: #64748b;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            background: #ecfdf3;

            color: #15803d;

            border: 1px solid #bbf7d0;

            padding: 8px 13px;

            border-radius: 30px;

            font-size: 13px;

            font-weight: 700;
        }

        .status-dot {
            width: 8px;
            height: 8px;

            background: #22c55e;

            border-radius: 50%;

            box-shadow:
                0 0 0 4px rgba(34, 197, 94, 0.12);
        }

        /* =====================================================
           PAGE TITLE
        ===================================================== */

        .page-heading {
            text-align: center;

            margin-bottom: 28px;
        }

        .page-heading h1 {
            color: #173f67;

            font-size: 30px;

            font-weight: 800;

            margin-bottom: 8px;
        }

        .page-heading p {
            color: #64748b;

            font-size: 14px;
        }

        /* =====================================================
           CARD AREA
        ===================================================== */

        .card-section {
            display: flex;

            justify-content: center;

            margin-bottom: 30px;
        }

        /* =====================================================
           LIBRARY CARD
        ===================================================== */

        .library-card {
            width: 100%;
            max-width: 690px;

            background: #ffffff;

            border-radius: 24px;

            overflow: hidden;

            border: 1px solid #dbe3ec;

            box-shadow:
                0 25px 60px rgba(15, 23, 42, 0.13);

            position: relative;
        }

        /* Decorative circles */

        .library-card::before {
            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.06);

            top: -100px;
            right: -70px;

            pointer-events: none;
        }

        .library-card::after {
            content: "";

            position: absolute;

            width: 150px;
            height: 150px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.05);

            bottom: -80px;
            left: -55px;

            pointer-events: none;
        }

        /* =====================================================
           CARD HEADER
        ===================================================== */

        .card-header {
            position: relative;

            background:
                linear-gradient(
                    135deg,
                    #102f4e 0%,
                    #1f4e79 55%,
                    #256aa3 100%
                );

            color: white;

            padding: 25px 30px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;
        }

        .library-title {
            display: flex;

            align-items: center;

            gap: 15px;
        }

        .library-emblem {
            width: 58px;
            height: 58px;

            border-radius: 15px;

            background: rgba(255, 255, 255, 0.13);

            border: 1px solid rgba(255, 255, 255, 0.2);

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 29px;
        }

        .library-title h2 {
            font-size: 21px;

            font-weight: 800;

            letter-spacing: 0.3px;
        }

        .library-title p {
            font-size: 12px;

            margin-top: 4px;

            color: #dbeafe;
        }

        .card-type {
            text-align: right;
        }

        .card-type span {
            display: block;

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: 1.5px;

            color: #bfdbfe;

            margin-bottom: 4px;
        }

        .card-type strong {
            font-size: 15px;

            letter-spacing: 0.5px;
        }

        /* =====================================================
           CARD BODY
        ===================================================== */

        .card-body {
            padding: 30px;
        }

        .student-main {
            display: grid;

            grid-template-columns: 150px 1fr;

            gap: 28px;

            align-items: center;

            padding-bottom: 25px;

            border-bottom: 1px solid #e5e7eb;
        }

        /* =====================================================
           PHOTO
        ===================================================== */

        .photo-area {
            text-align: center;
        }

        .student-photo {
            width: 128px;
            height: 128px;

            margin: 0 auto;

            border-radius: 20px;

            background:
                linear-gradient(
                    135deg,
                    #e8eef5,
                    #f8fafc
                );

            border: 4px solid #ffffff;

            outline: 2px solid #2b6598;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;

            box-shadow:
                0 8px 20px rgba(15, 23, 42, 0.12);

            font-size: 38px;

            font-weight: 800;

            color: #1f4e79;
        }

        .student-photo img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        .photo-label {
            margin-top: 12px;

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: 1px;

            color: #64748b;

            font-weight: 700;
        }

        /* =====================================================
           STUDENT BASIC INFO
        ===================================================== */

        .student-info h2 {
            font-size: 28px;

            color: #0f2942;

            margin-bottom: 7px;

            line-height: 1.2;
        }

        .course-name {
            color: #526579;

            font-size: 14px;

            margin-bottom: 16px;
        }

        .student-id {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            background: #eff6ff;

            color: #1d4f7d;

            border: 1px solid #dbeafe;

            padding: 8px 13px;

            border-radius: 9px;

            font-size: 13px;

            font-weight: 700;
        }

        /* =====================================================
           INFORMATION GRID
        ===================================================== */

        .info-grid {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 0;

            margin-top: 24px;
        }

        .info-item {
            padding: 15px 14px;

            border-bottom: 1px solid #edf0f4;

            min-height: 72px;
        }

        .info-item:nth-child(odd) {
            border-right: 1px solid #edf0f4;

            padding-left: 0;
        }

        .info-item:nth-child(even) {
            padding-right: 0;
        }

        .info-label {
            display: flex;

            align-items: center;

            gap: 7px;

            font-size: 11px;

            color: #7a8796;

            text-transform: uppercase;

            letter-spacing: 0.8px;

            font-weight: 700;

            margin-bottom: 7px;
        }

        .info-value {
            font-size: 14px;

            color: #25364a;

            font-weight: 600;

            word-break: break-word;
        }

        /* =====================================================
           MEMBERSHIP DETAILS
        ===================================================== */

        .membership-box {
            margin-top: 25px;

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #f1f5f9
                );

            border: 1px solid #e2e8f0;

            border-radius: 15px;

            padding: 18px;
        }

        .membership-title {
            font-size: 13px;

            font-weight: 800;

            color: #173f67;

            margin-bottom: 14px;
        }

        .membership-grid {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 12px;
        }

        .membership-item {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 11px;

            padding: 13px;
        }

        .membership-item span {
            display: block;

            font-size: 10px;

            color: #7b8794;

            text-transform: uppercase;

            letter-spacing: 0.7px;

            margin-bottom: 5px;
        }

        .membership-item strong {
            font-size: 13px;

            color: #26384d;
        }

        /* =====================================================
           QR SECTION
        ===================================================== */

        .qr-section {
            margin-top: 25px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 18px;

            border: 1px dashed #cbd5e1;

            border-radius: 15px;

            background: #ffffff;
        }

        .qr-info h3 {
            color: #173f67;

            font-size: 15px;

            margin-bottom: 6px;
        }

        .qr-info p {
            color: #64748b;

            font-size: 12px;

            line-height: 1.6;

            max-width: 350px;
        }

        .qr-code {
            width: 95px;
            height: 95px;

            background: #ffffff;

            border: 6px solid #ffffff;

            box-shadow:
                0 3px 12px rgba(15, 23, 42, 0.13);

            flex-shrink: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;
        }

        .qr-code img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        /* =====================================================
           CARD FOOTER
        ===================================================== */

        .card-footer {
            background: #f8fafc;

            border-top: 1px solid #e5e7eb;

            padding: 20px 30px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;
        }

        .footer-note {
            font-size: 11px;

            line-height: 1.6;

            color: #64748b;

            max-width: 450px;
        }

        .footer-card-number {
            text-align: right;

            font-size: 10px;

            color: #94a3b8;

            text-transform: uppercase;

            letter-spacing: 0.8px;
        }

        .footer-card-number strong {
            display: block;

            color: #475569;

            font-size: 12px;

            margin-top: 3px;
        }

        /* =====================================================
           BUTTONS
        ===================================================== */

        .actions {
            display: flex;

            justify-content: center;

            gap: 12px;

            margin-top: 25px;

            flex-wrap: wrap;
        }

        .btn {
            border: none;

            padding: 13px 22px;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background:
                linear-gradient(
                    135deg,
                    #173f67,
                    #256aa3
                );

            color: white;

            box-shadow:
                0 7px 18px rgba(31, 78, 121, 0.25);
        }

        .btn-secondary {
            background: white;

            color: #334155;

            border: 1px solid #d7dee7;

            box-shadow:
                0 3px 10px rgba(15, 23, 42, 0.05);
        }

        .btn-danger {
            background: #fff1f2;

            color: #be123c;

            border: 1px solid #fecdd3;
        }

        /* =====================================================
           INFORMATION NOTICE
        ===================================================== */

        .notice {
            max-width: 690px;

            margin: 20px auto 0;

            background: #fffbeb;

            border: 1px solid #fde68a;

            border-radius: 13px;

            padding: 14px 17px;

            color: #854d0e;

            font-size: 12px;

            line-height: 1.6;
        }

        .notice strong {
            display: block;

            margin-bottom: 3px;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 720px) {

            body {
                padding: 20px 12px;
            }

            .top-bar {
                padding: 13px 15px;
            }

            .brand-text h2 {
                font-size: 14px;
            }

            .status-pill {
                font-size: 11px;
                padding: 7px 9px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .card-header {
                padding: 20px;
            }

            .library-title h2 {
                font-size: 17px;
            }

            .library-emblem {
                width: 48px;
                height: 48px;
                font-size: 23px;
            }

            .card-type {
                display: none;
            }

            .card-body {
                padding: 20px;
            }

            .student-main {
                grid-template-columns: 1fr;

                text-align: center;

                gap: 20px;
            }

            .student-info h2 {
                font-size: 24px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .info-item:nth-child(odd) {
                border-right: none;

                padding-left: 0;
            }

            .info-item:nth-child(even) {
                padding-right: 0;
            }

            .membership-grid {
                grid-template-columns: 1fr;
            }

            .qr-section {
                flex-direction: column;

                text-align: center;
            }

            .qr-info p {
                max-width: none;
            }

            .card-footer {
                flex-direction: column;

                text-align: center;
            }

            .footer-card-number {
                text-align: center;
            }

            .btn {
                width: 100%;
            }
        }

        /* =====================================================
           PRINT DESIGN
        ===================================================== */

        @media print {

            @page {
                size: A4;
                margin: 12mm;
            }

            body {
                background: white;

                padding: 0;
            }

            .top-bar,
            .page-heading,
            .actions,
            .notice {
                display: none !important;
            }

            .page-wrapper {
                max-width: 100%;
            }

            .card-section {
                margin: 0;

                display: block;
            }

            .library-card {
                max-width: 100%;

                width: 100%;

                box-shadow: none;

                border: 1px solid #bbb;

                border-radius: 10px;
            }

            .btn {
                display: none !important;
            }

            .library-card::before,
            .library-card::after {
                display: none;
            }
        }

    </style>

</head>

<body>

<div class="page-wrapper">

    <!-- =====================================================
         TOP BAR
    ====================================================== -->

    <div class="top-bar">

        <div class="brand">

            <div class="brand-logo">
                📚
            </div>

            <div class="brand-text">

                <h2>
                    Department Library
                </h2>

                <p>
                    Digital Library Management System
                </p>

            </div>

        </div>

        <div class="status-pill">

            <span class="status-dot"></span>

            <?php echo safe($student["status"]); ?>

        </div>

    </div>


    <!-- =====================================================
         PAGE HEADING
    ====================================================== -->

    <div class="page-heading">

        <h1>
            Student Library ID Card
        </h1>

        <p>
            Official identification card for Department Library members
        </p>

    </div>


    <!-- =====================================================
         LIBRARY CARD
    ====================================================== -->

    <div class="card-section">

        <div class="library-card">

            <!-- CARD HEADER -->

            <div class="card-header">

                <div class="library-title">

                    <div class="library-emblem">
                        📖
                    </div>

                    <div>

                        <h2>
                            DEPARTMENT LIBRARY
                        </h2>

                        <p>
                            Student Membership Card
                        </p>

                    </div>

                </div>

                <div class="card-type">

                    <span>
                        Card Type
                    </span>

                    <strong>
                        STUDENT
                    </strong>

                </div>

            </div>


            <!-- CARD BODY -->

            <div class="card-body">


                <!-- STUDENT MAIN -->

                <div class="student-main">

                    <div class="photo-area">

                        <div class="student-photo">

                            <?php if (!empty($student["photo"])): ?>

                                <img
                                    src="<?php echo safe($student["photo"]); ?>"
                                    alt="Student Photo"
                                >

                            <?php else: ?>

                                <?php echo safe($initials); ?>

                            <?php endif; ?>

                        </div>

                        <div class="photo-label">
                            Student Photo
                        </div>

                    </div>


                    <div class="student-info">

                        <h2>
                            <?php echo safe($student["name"]); ?>
                        </h2>

                        <div class="course-name">
                            <?php echo safe($student["course"]); ?>
                        </div>

                        <div class="student-id">
                            🪪

                            Student ID:
                            <?php echo safe($student["id"]); ?>

                        </div>

                    </div>

                </div>


                <!-- STUDENT INFORMATION -->

                <div class="info-grid">


                    <div class="info-item">

                        <div class="info-label">
                            🎓 Course
                        </div>

                        <div class="info-value">
                            <?php echo safe($student["short_course"]); ?>
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            📚 Semester
                        </div>

                        <div class="info-value">
                            <?php echo safe($student["semester"]); ?>
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            🏛️ Department
                        </div>

                        <div class="info-value">
                            <?php echo safe($student["department"]); ?>
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            📅 Academic Year
                        </div>

                        <div class="info-value">
                            <?php echo safe($student["academic_year"]); ?>
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            ✉️ Email
                        </div>

                        <div class="info-value">
                            <?php echo safe($student["email"]); ?>
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            📞 Phone
                        </div>

                        <div class="info-value">
                            <?php echo safe($student["phone"]); ?>
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            📍 Library
                        </div>

                        <div class="info-value">
                            <?php echo safe($student["address"]); ?>
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            🩸 Blood Group
                        </div>

                        <div class="info-value">
                            <?php echo safe($student["blood_group"]); ?>
                        </div>

                    </div>

                </div>


                <!-- MEMBERSHIP DETAILS -->

                <div class="membership-box">

                    <div class="membership-title">
                        📋 Membership Information
                    </div>

                    <div class="membership-grid">


                        <div class="membership-item">

                            <span>
                                Membership Status
                            </span>

                            <strong>
                                <?php echo safe($student["status"]); ?>
                            </strong>

                        </div>


                        <div class="membership-item">

                            <span>
                                Membership Start
                            </span>

                            <strong>
                                <?php echo safe($student["join_date"]); ?>
                            </strong>

                        </div>


                        <div class="membership-item">

                            <span>
                                Valid Until
                            </span>

                            <strong>
                                <?php echo safe($student["valid_until"]); ?>
                            </strong>

                        </div>


                        <div class="membership-item">

                            <span>
                                Book Borrowing Limit
                            </span>

                            <strong>
                                <?php echo safe($student["book_limit"]); ?>
                            </strong>

                        </div>


                        <div class="membership-item">

                            <span>
                                Card Number
                            </span>

                            <strong>
                                <?php echo safe($student["card_number"]); ?>
                            </strong>

                        </div>


                        <div class="membership-item">

                            <span>
                                Member Type
                            </span>

                            <strong>
                                Student
                            </strong>

                        </div>


                    </div>

                </div>


                <!-- QR SECTION -->

                <div class="qr-section">

                    <div class="qr-info">

                        <h3>
                            🔐 Digital Verification
                        </h3>

                        <p>
                            Scan the QR code to verify this library
                            membership. The QR section can later be
                            connected to the student's database profile.
                        </p>

                    </div>


                    <div class="qr-code">

                        <img
                            src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $qrData; ?>"
                            alt="Student Library QR Code"
                        >

                    </div>

                </div>

            </div>


            <!-- CARD FOOTER -->

            <div class="card-footer">

                <div class="footer-note">

                    This card is the property of the Department Library.
                    Please carry this card while using library services.
                    If found, please return it to the Department Library.

                </div>

                <div class="footer-card-number">

                    Card Number

                    <strong>
                        <?php echo safe($student["card_number"]); ?>
                    </strong>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         ACTION BUTTONS
    ====================================================== -->

    <div class="actions">

        <button
            type="button"
            class="btn btn-primary"
            onclick="window.print()"
        >
            🖨️ Print Library Card
        </button>

        <button
            type="button"
            class="btn btn-secondary"
            onclick="window.location.reload()"
        >
            🔄 Refresh Card
        </button>

        <button
            type="button"
            class="btn btn-danger"
            onclick="goBack()"
        >
            ← Back
        </button>

    </div>


    <!-- =====================================================
         NOTICE
    ====================================================== -->

    <div class="notice">

        <strong>
            ℹ️ Demo Mode
        </strong>

        This page currently displays demo student information.
        Once the MySQL student database is connected, the card can
        automatically load the logged-in student's real information.

    </div>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | Back Button
    |--------------------------------------------------------------------------
    */

    function goBack() {

        if (document.referrer) {

            window.history.back();

        } else {

            window.location.href = "index.php";

        }

    }

</script>

</body>

</html>
```
