```php
<?php
/*
|--------------------------------------------------------------------------
| DEPARTMENT LIBRARY CHATBOT
| PROFESSIONAL ANALYTICS DASHBOARD
|--------------------------------------------------------------------------
|
| File:
| analytics.php
|
| Purpose:
| - Library performance analytics
| - Book circulation statistics
| - Student statistics
| - Issue / Return analysis
| - Overdue analysis
| - Popular books
| - Category distribution
| - Monthly activity
| - Recent library activity
|
| IMPORTANT:
| This version uses DEMO DATA.
| It is designed so that MySQL can be connected later.
|
|--------------------------------------------------------------------------
*/


// ==========================================================================
// SECURITY / PAGE CONFIGURATION
// ==========================================================================

$pageTitle = "Library Analytics";
$libraryName = "Department Library";
$systemName = "Digital Library Management System";


// ==========================================================================
// DEMO OVERVIEW STATISTICS
// ==========================================================================

$stats = [

    "total_books" => 12500,

    "available_books" => 9230,

    "issued_books" => 3270,

    "total_students" => 1840,

    "total_faculty" => 85,

    "overdue_books" => 126,

    "returned_books" => 892,

    "ebooks" => 640,

];


// ==========================================================================
// CALCULATED STATISTICS
// ==========================================================================

$totalBooks = $stats["total_books"];

$availablePercentage = $totalBooks > 0
    ? round(
        ($stats["available_books"] / $totalBooks) * 100
    )
    : 0;

$issuedPercentage = $totalBooks > 0
    ? round(
        ($stats["issued_books"] / $totalBooks) * 100
    )
    : 0;

$overduePercentage = $stats["issued_books"] > 0
    ? round(
        ($stats["overdue_books"] / $stats["issued_books"]) * 100,
        1
    )
    : 0;

$returnRate = ($stats["issued_books"] + $stats["returned_books"]) > 0
    ? round(
        (
            $stats["returned_books"] /
            (
                $stats["issued_books"] +
                $stats["returned_books"]
            )
        ) * 100
    )
    : 0;


// ==========================================================================
// MONTHLY BOOK ISSUE DATA
// ==========================================================================

$monthlyIssues = [

    "Jan" => 320,
    "Feb" => 410,
    "Mar" => 530,
    "Apr" => 470,
    "May" => 620,
    "Jun" => 580,
    "Jul" => 710,
    "Aug" => 680,
    "Sep" => 760,
    "Oct" => 640,
    "Nov" => 590,
    "Dec" => 720

];


// ==========================================================================
// MONTHLY RETURN DATA
// ==========================================================================

$monthlyReturns = [

    "Jan" => 280,
    "Feb" => 365,
    "Mar" => 480,
    "Apr" => 430,
    "May" => 550,
    "Jun" => 520,
    "Jul" => 630,
    "Aug" => 610,
    "Sep" => 690,
    "Oct" => 570,
    "Nov" => 540,
    "Dec" => 650

];


// ==========================================================================
// BOOK CATEGORY DATA
// ==========================================================================

$categories = [

    "Computer Science" => 3100,

    "Commerce" => 2100,

    "Management" => 1850,

    "Mathematics" => 1450,

    "Physics" => 1200,

    "English" => 980,

    "Other" => 1820

];


// ==========================================================================
// SEMESTER DATA
// ==========================================================================

$semesterData = [

    "Semester 1" => 285,

    "Semester 2" => 240,

    "Semester 3" => 330,

    "Semester 4" => 310,

    "Semester 5" => 385,

    "Semester 6" => 290

];


// ==========================================================================
// POPULAR BOOKS
// ==========================================================================

$popularBooks = [

    [
        "rank" => 1,
        "name" => "Database Management Systems",
        "author" => "Raghu Ramakrishnan",
        "category" => "Computer Science",
        "issues" => 186
    ],

    [
        "rank" => 2,
        "name" => "Computer Networks",
        "author" => "Andrew S. Tanenbaum",
        "category" => "Computer Science",
        "issues" => 172
    ],

    [
        "rank" => 3,
        "name" => "Operating System Concepts",
        "author" => "Abraham Silberschatz",
        "category" => "Computer Science",
        "issues" => 164
    ],

    [
        "rank" => 4,
        "name" => "Data Structures",
        "author" => "Seymour Lipschutz",
        "category" => "Computer Science",
        "issues" => 151
    ],

    [
        "rank" => 5,
        "name" => "Web Development",
        "author" => "Jon Duckett",
        "category" => "Computer Science",
        "issues" => 143
    ]

];


// ==========================================================================
// RECENT ACTIVITY
// ==========================================================================

$recentActivity = [

    [
        "type" => "issue",
        "icon" => "📚",
        "title" => "Book Issued",
        "description" => "Database Management Systems issued to DL2026012",
        "time" => "8 minutes ago"
    ],

    [
        "type" => "return",
        "icon" => "↩️",
        "title" => "Book Returned",
        "description" => "Computer Networks returned by DL2026045",
        "time" => "24 minutes ago"
    ],

    [
        "type" => "student",
        "icon" => "👨‍🎓",
        "title" => "New Student",
        "description" => "New library member registered",
        "time" => "1 hour ago"
    ],

    [
        "type" => "overdue",
        "icon" => "⚠️",
        "title" => "Overdue Alert",
        "description" => "Book overdue for more than 7 days",
        "time" => "2 hours ago"
    ],

    [
        "type" => "book",
        "icon" => "📖",
        "title" => "New Book Added",
        "description" => "5 new books added to library inventory",
        "time" => "3 hours ago"
    ],

    [
        "type" => "admin",
        "icon" => "🔐",
        "title" => "Admin Login",
        "description" => "Administrator logged into dashboard",
        "time" => "4 hours ago"
    ]

];


// ==========================================================================
// QUICK REPORT DATA
// ==========================================================================

$quickReports = [

    [
        "title" => "Issued Books",
        "value" => $stats["issued_books"],
        "icon" => "📚",
        "description" => "Currently issued"
    ],

    [
        "title" => "Returned Books",
        "value" => $stats["returned_books"],
        "icon" => "↩️",
        "description" => "Recently returned"
    ],

    [
        "title" => "Overdue Books",
        "value" => $stats["overdue_books"],
        "icon" => "⚠️",
        "description" => "Need attention"
    ],

    [
        "title" => "E-Books",
        "value" => $stats["ebooks"],
        "icon" => "💻",
        "description" => "Digital collection"
    ]

];


// ==========================================================================
// HELPER FUNCTION
// ==========================================================================

function safe($value)
{
    return htmlspecialchars(
        $value ?? "",
        ENT_QUOTES,
        "UTF-8"
    );
}


// ==========================================================================
// JSON DATA FOR JAVASCRIPT
// ==========================================================================

$monthsJson = json_encode(
    array_keys($monthlyIssues)
);

$issuesJson = json_encode(
    array_values($monthlyIssues)
);

$returnsJson = json_encode(
    array_values($monthlyReturns)
);

$categoryNamesJson = json_encode(
    array_keys($categories)
);

$categoryValuesJson = json_encode(
    array_values($categories)
);

$semesterNamesJson = json_encode(
    array_keys($semesterData)
);

$semesterValuesJson = json_encode(
    array_values($semesterData)
);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <!-- ======================================================
         BASIC META
    ======================================================= -->

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Professional Department Library Analytics Dashboard"
    >

    <meta
        name="author"
        content="Department Library"
    >

    <meta
        name="theme-color"
        content="#173f67"
    >

    <title>
        <?php echo safe($pageTitle); ?> |
        <?php echo safe($libraryName); ?>
    </title>


    <!-- ======================================================
         CHART.JS
    ======================================================= -->

    <script
        src="https://cdn.jsdelivr.net/npm/chart.js"
    ></script>


    <!-- ======================================================
         ICON FONT
    ======================================================= -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- ======================================================
         CSS
    ======================================================= -->

    <style>

        /* ==================================================
           GLOBAL RESET
        ================================================== */

        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

        }


        :root {

            --primary: #173f67;

            --primary-light: #256aa3;

            --primary-soft: #eef5fb;

            --text: #172b40;

            --text-light: #64748b;

            --border: #e2e8f0;

            --background: #f4f7fb;

            --white: #ffffff;

            --success: #15803d;

            --warning: #b45309;

            --danger: #be123c;

        }


        html {

            scroll-behavior: smooth;

        }


        body {

            font-family:
                "Inter",
                "Segoe UI",
                Arial,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #eef3f8,
                    #f8fafc
                );

            color: var(--text);

            min-height: 100vh;

        }


        button {

            font-family: inherit;

        }


        /* ==================================================
           LAYOUT
        ================================================== */

        .dashboard {

            min-height: 100vh;

        }


        .main-content {

            max-width: 1500px;

            margin: auto;

            padding: 25px;

        }


        /* ==================================================
           TOP HEADER
        ================================================== */

        .top-header {

            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 18px;

            padding: 18px 22px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 25px;

            box-shadow:
                0 8px 30px
                rgba(15, 23, 42, 0.06);

        }


        .brand {

            display: flex;

            align-items: center;

            gap: 14px;

        }


        .brand-logo {

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-light)
                );

            color: white;

            font-size: 25px;

            box-shadow:
                0 7px 18px
                rgba(23, 63, 103, 0.22);

        }


        .brand h1 {

            color: var(--primary);

            font-size: 20px;

            font-weight: 800;

            margin-bottom: 3px;

        }


        .brand p {

            color: var(--text-light);

            font-size: 11px;

        }


        .header-right {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .date-box {

            background: #f8fafc;

            border: 1px solid var(--border);

            padding: 10px 14px;

            border-radius: 10px;

            color: #475569;

            font-size: 12px;

            font-weight: 600;

        }


        .header-btn {

            border: none;

            border-radius: 10px;

            padding: 11px 16px;

            cursor: pointer;

            font-size: 12px;

            font-weight: 700;

            transition: 0.2s;

        }


        .header-btn:hover {

            transform: translateY(-2px);

        }


        .print-btn {

            background: var(--primary);

            color: white;

        }


        .refresh-btn {

            background: white;

            color: #475569;

            border: 1px solid var(--border);

        }


        /* ==================================================
           PAGE TITLE
        ================================================== */

        .page-title {

            margin-bottom: 22px;

        }


        .page-title h2 {

            color: var(--primary);

            font-size: 24px;

            font-weight: 800;

            margin-bottom: 6px;

        }


        .page-title p {

            color: var(--text-light);

            font-size: 13px;

        }


        /* ==================================================
           KPI CARDS
        ================================================== */

        .stats-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 17px;

            margin-bottom: 22px;

        }


        .stat-card {

            background: white;

            border: 1px solid var(--border);

            border-radius: 17px;

            padding: 20px;

            box-shadow:
                0 7px 22px
                rgba(15, 23, 42, 0.05);

            transition:
                transform 0.25s,
                box-shadow 0.25s;

        }


        .stat-card:hover {

            transform: translateY(-4px);

            box-shadow:
                0 14px 30px
                rgba(15, 23, 42, 0.09);

        }


        .stat-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 17px;

        }


        .stat-icon {

            width: 45px;

            height: 45px;

            border-radius: 12px;

            background: var(--primary-soft);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 21px;

        }


        .stat-label {

            color: var(--text-light);

            font-size: 11px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.6px;

        }


        .stat-value {

            font-size: 30px;

            font-weight: 800;

            color: var(--text);

            margin-bottom: 7px;

        }


        .stat-footer {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 10px;

        }


        .stat-description {

            color: #94a3b8;

            font-size: 10px;

        }


        .stat-percentage {

            color: var(--success);

            font-size: 11px;

            font-weight: 700;

        }


        /* ==================================================
           PANEL
        ================================================== */

        .panel {

            background: white;

            border: 1px solid var(--border);

            border-radius: 17px;

            padding: 21px;

            box-shadow:
                0 7px 22px
                rgba(15, 23, 42, 0.05);

        }


        .panel-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;

            margin-bottom: 20px;

        }


        .panel-title h3 {

            color: var(--primary);

            font-size: 15px;

            font-weight: 800;

            margin-bottom: 4px;

        }


        .panel-title p {

            color: var(--text-light);

            font-size: 10px;

        }


        .panel-badge {

            padding: 7px 10px;

            background: var(--primary-soft);

            color: var(--primary);

            border-radius: 8px;

            font-size: 10px;

            font-weight: 700;

        }


        /* ==================================================
           CHART GRID
        ================================================== */

        .chart-grid {

            display: grid;

            grid-template-columns:
                2fr 1fr;

            gap: 20px;

            margin-bottom: 20px;

        }


        .chart-container {

            position: relative;

            width: 100%;

            height: 310px;

        }


        .small-chart {

            height: 280px;

        }


        /* ==================================================
           SECOND CHART ROW
        ================================================== */

        .second-grid {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 20px;

            margin-bottom: 20px;

        }


        /* ==================================================
           CIRCULATION
        ================================================== */

        .circulation {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 15px;

        }


        .circulation-item {

            padding: 17px;

            border: 1px solid #edf1f5;

            border-radius: 13px;

            background: #fafcff;

        }


        .circulation-top {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 10px;

        }


        .circulation-label {

            color: #64748b;

            font-size: 11px;

            font-weight: 600;

        }


        .circulation-value {

            color: var(--text);

            font-size: 18px;

            font-weight: 800;

        }


        .progress {

            width: 100%;

            height: 7px;

            background: #e9eef4;

            border-radius: 10px;

            overflow: hidden;

        }


        .progress span {

            display: block;

            height: 100%;

            border-radius: 10px;

            background:
                linear-gradient(
                    90deg,
                    var(--primary),
                    #4f8fc1
                );

        }


        /* ==================================================
           QUICK REPORT
        ================================================== */

        .quick-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 14px;

        }


        .quick-card {

            border: 1px solid var(--border);

            border-radius: 13px;

            padding: 17px;

            background: #fcfdff;

        }


        .quick-icon {

            font-size: 21px;

            margin-bottom: 10px;

        }


        .quick-title {

            font-size: 11px;

            color: var(--text-light);

            margin-bottom: 5px;

        }


        .quick-value {

            font-size: 22px;

            font-weight: 800;

            color: var(--text);

            margin-bottom: 4px;

        }


        .quick-description {

            font-size: 9px;

            color: #94a3b8;

        }


        /* ==================================================
           POPULAR BOOKS
        ================================================== */

        .table-wrapper {

            width: 100%;

            overflow-x: auto;

        }


        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 650px;

        }


        th {

            text-align: left;

            color: #64748b;

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: 0.6px;

            padding: 12px;

            border-bottom: 1px solid var(--border);

            background: #f8fafc;

        }


        td {

            padding: 13px 12px;

            border-bottom: 1px solid #edf1f5;

            font-size: 12px;

            color: #334155;

        }


        tr:last-child td {

            border-bottom: none;

        }


        .book-rank {

            width: 30px;

            height: 30px;

            border-radius: 8px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: var(--primary-soft);

            color: var(--primary);

            font-weight: 800;

        }


        .book-name {

            color: #1e3a56;

            font-weight: 700;

        }


        .book-author {

            color: #94a3b8;

            font-size: 10px;

            margin-top: 3px;

        }


        .category-badge {

            background: #f1f5f9;

            color: #475569;

            border-radius: 7px;

            padding: 5px 8px;

            font-size: 9px;

            font-weight: 600;

        }


        .issue-count {

            font-weight: 800;

            color: var(--primary);

        }


        /* ==================================================
           ACTIVITY
        ================================================== */

        .activity-list {

            display: flex;

            flex-direction: column;

        }


        .activity-item {

            display: flex;

            align-items: flex-start;

            gap: 12px;

            padding: 14px 0;

            border-bottom: 1px solid #edf1f5;

        }


        .activity-item:last-child {

            border-bottom: none;

        }


        .activity-icon {

            width: 37px;

            height: 37px;

            border-radius: 10px;

            background: var(--primary-soft);

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            font-size: 16px;

        }


        .activity-content {

            flex: 1;

        }


        .activity-title {

            color: #253b52;

            font-size: 11px;

            font-weight: 800;

            margin-bottom: 4px;

        }


        .activity-description {

            color: #64748b;

            font-size: 10px;

            line-height: 1.5;

        }


        .activity-time {

            color: #94a3b8;

            font-size: 9px;

            margin-top: 4px;

        }


        /* ==================================================
           OVERVIEW FOOTER
        ================================================== */

        .footer-info {

            margin-top: 20px;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 15px;

        }


        .footer-card {

            background: white;

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 17px;

        }


        .footer-card h4 {

            color: var(--primary);

            font-size: 12px;

            margin-bottom: 8px;

        }


        .footer-card p {

            color: #64748b;

            font-size: 10px;

            line-height: 1.7;

        }


        /* ==================================================
           BOTTOM FOOTER
        ================================================== */

        .bottom-footer {

            text-align: center;

            color: #94a3b8;

            font-size: 10px;

            padding: 25px 0 10px;

        }


        /* ==================================================
           PRINT
        ================================================== */

        @media print {

            @page {

                size: A4 landscape;

                margin: 10mm;

            }


            body {

                background: white;

            }


            .top-header {

                box-shadow: none;

            }


            .header-actions,
            .date-box {

                display: none !important;

            }


            .panel,
            .stat-card {

                box-shadow: none;

                break-inside: avoid;

            }


            .chart-grid,
            .second-grid {

                break-inside: avoid;

            }


            .bottom-footer {

                display: none;

            }

        }


        /* ==================================================
           TABLET
        ================================================== */

        @media (max-width: 1100px) {

            .stats-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }


            .chart-grid {

                grid-template-columns: 1fr;

            }


            .quick-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

        }


        /* ==================================================
           MOBILE
        ================================================== */

        @media (max-width: 700px) {

            body {

                background: #f5f7fa;

            }


            .main-content {

                padding: 12px;

            }


            .top-header {

                border-radius: 13px;

                padding: 14px;

                align-items: flex-start;

            }


            .header-right {

                flex-direction: column;

                align-items: stretch;

            }


            .date-box {

                display: none;

            }


            .brand h1 {

                font-size: 16px;

            }


            .brand p {

                font-size: 9px;

            }


            .brand-logo {

                width: 43px;

                height: 43px;

                font-size: 20px;

            }


            .page-title h2 {

                font-size: 20px;

            }


            .stats-grid {

                grid-template-columns: 1fr;

            }


            .second-grid {

                grid-template-columns: 1fr;

            }


            .quick-grid {

                grid-template-columns: 1fr 1fr;

            }


            .circulation {

                grid-template-columns: 1fr;

            }


            .footer-info {

                grid-template-columns: 1fr;

            }


            .chart-container {

                height: 270px;

            }

        }


        /* ==================================================
           SMALL MOBILE
        ================================================== */

        @media (max-width: 430px) {

            .quick-grid {

                grid-template-columns: 1fr;

            }


            .header-btn {

                width: 100%;

            }


            .header-right {

                width: 110px;

            }

        }

    </style>

</head>


<body>


<div class="dashboard">


    <main class="main-content">


        <!-- =================================================
             TOP HEADER
        ================================================== -->

        <header class="top-header">


            <div class="brand">

                <div class="brand-logo">
                    📊
                </div>

                <div>

                    <h1>
                        <?php echo safe($libraryName); ?>
                    </h1>

                    <p>
                        <?php echo safe($systemName); ?>
                    </p>

                </div>

            </div>


            <div class="header-right">


                <div class="date-box">

                    📅

                    <?php
                    echo date("d M Y");
                    ?>

                </div>


                <button
                    type="button"
                    class="header-btn refresh-btn"
                    onclick="location.reload()"
                >
                    🔄 Refresh
                </button>


                <button
                    type="button"
                    class="header-btn print-btn"
                    onclick="window.print()"
                >
                    🖨️ Print Report
                </button>


            </div>


        </header>


        <!-- =================================================
             PAGE TITLE
        ================================================== -->

        <section class="page-title">

            <h2>
                Library Analytics
            </h2>

            <p>
                Monitor books, students, circulation and overall
                library performance from one dashboard.
            </p>

        </section>


        <!-- =================================================
             KPI STATISTICS
        ================================================== -->

        <section class="stats-grid">


            <!-- TOTAL BOOKS -->

            <div class="stat-card">

                <div class="stat-header">

                    <div class="stat-label">
                        Total Books
                    </div>

                    <div class="stat-icon">
                        📚
                    </div>

                </div>

                <div class="stat-value">
                    <?php
                    echo number_format(
                        $stats["total_books"]
                    );
                    ?>
                </div>

                <div class="stat-footer">

                    <span class="stat-description">
                        Complete collection
                    </span>

                    <span class="stat-percentage">
                        100%
                    </span>

                </div>

            </div>


            <!-- AVAILABLE -->

            <div class="stat-card">

                <div class="stat-header">

                    <div class="stat-label">
                        Available Books
                    </div>

                    <div class="stat-icon">
                        📗
                    </div>

                </div>

                <div class="stat-value">
                    <?php
                    echo number_format(
                        $stats["available_books"]
                    );
                    ?>
                </div>

                <div class="stat-footer">

                    <span class="stat-description">
                        Ready to issue
                    </span>

                    <span class="stat-percentage">
                        <?php
                        echo $availablePercentage;
                        ?>%
                    </span>

                </div>

            </div>


            <!-- ISSUED -->

            <div class="stat-card">

                <div class="stat-header">

                    <div class="stat-label">
                        Issued Books
                    </div>

                    <div class="stat-icon">
                        📕
                    </div>

                </div>

                <div class="stat-value">
                    <?php
                    echo number_format(
                        $stats["issued_books"]
                    );
                    ?>
                </div>

                <div class="stat-footer">

                    <span class="stat-description">
                        Currently borrowed
                    </span>

                    <span class="stat-percentage">
                        <?php
                        echo $issuedPercentage;
                        ?>%
                    </span>

                </div>

            </div>


            <!-- STUDENTS -->

            <div class="stat-card">

                <div class="stat-header">

                    <div class="stat-label">
                        Students
                    </div>

                    <div class="stat-icon">
                        👨‍🎓
                    </div>

                </div>

                <div class="stat-value">
                    <?php
                    echo number_format(
                        $stats["total_students"]
                    );
                    ?>
                </div>

                <div class="stat-footer">

                    <span class="stat-description">
                        Registered members
                    </span>

                    <span class="stat-percentage">
                        Active
                    </span>

                </div>

            </div>


        </section>


        <!-- =================================================
             MAIN CHARTS
        ================================================== -->

        <section class="chart-grid">


            <!-- MONTHLY TREND -->

            <div class="panel">

                <div class="panel-header">

                    <div class="panel-title">

                        <h3>
                            📈 Monthly Circulation Trend
                        </h3>

                        <p>
                            Books issued and returned throughout
                            the year.
                        </p>

                    </div>

                    <div class="panel-badge">
                        12 Months
                    </div>

                </div>


                <div class="chart-container">

                    <canvas
                        id="monthlyChart"
                    ></canvas>

                </div>

            </div>


            <!-- BOOK DISTRIBUTION -->

            <div class="panel">

                <div class="panel-header">

                    <div class="panel-title">

                        <h3>
                            📚 Book Collection
                        </h3>

                        <p>
                            Books by category
                        </p>

                    </div>

                </div>


                <div
                    class="chart-container small-chart"
                >

                    <canvas
                        id="categoryChart"
                    ></canvas>

                </div>

            </div>


        </section>


        <!-- =================================================
             SECOND CHART ROW
        ================================================== -->

        <section class="second-grid">


            <!-- SEMESTER ANALYSIS -->

            <div class="panel">

                <div class="panel-header">

                    <div class="panel-title">

                        <h3>
                            🎓 Student Activity by Semester
                        </h3>

                        <p>
                            Number of active students
                        </p>

                    </div>

                </div>


                <div class="chart-container">

                    <canvas
                        id="semesterChart"
                    ></canvas>

                </div>

            </div>


            <!-- CIRCULATION STATUS -->

            <div class="panel">

                <div class="panel-header">

                    <div class="panel-title">

                        <h3>
                            📊 Circulation Status
                        </h3>

                        <p>
                            Current library inventory status
                        </p>

                    </div>

                </div>


                <div class="circulation">


                    <!-- AVAILABLE -->

                    <div class="circulation-item">

                        <div class="circulation-top">

                            <span class="circulation-label">
                                Available
                            </span>

                            <span class="circulation-value">
                                <?php
                                echo number_format(
                                    $stats["available_books"]
                                );
                                ?>
                            </span>

                        </div>

                        <div class="progress">

                            <span
                                style="
                                width:
                                <?php
                                echo $availablePercentage;
                                ?>%;
                                "
                            ></span>

                        </div>

                    </div>


                    <!-- ISSUED -->

                    <div class="circulation-item">

                        <div class="circulation-top">

                            <span class="circulation-label">
                                Issued
                            </span>

                            <span class="circulation-value">
                                <?php
                                echo number_format(
                                    $stats["issued_books"]
                                );
                                ?>
                            </span>

                        </div>

                        <div class="progress">

                            <span
                                style="
                                width:
                                <?php
                                echo $issuedPercentage;
                                ?>%;
                                "
                            ></span>

                        </div>

                    </div>


                    <!-- OVERDUE -->

                    <div class="circulation-item">

                        <div class="circulation-top">

                            <span class="circulation-label">
                                Overdue
                            </span>

                            <span class="circulation-value">
                                <?php
                                echo number_format(
                                    $stats["overdue_books"]
                                );
                                ?>
                            </span>

                        </div>

                        <div class="progress">

                            <span
                                style="
                                width:
                                <?php
                                echo min(
                                    100,
                                    $overduePercentage * 5
                                );
                                ?>%;
                                "
                            ></span>

                        </div>

                    </div>


                    <!-- RETURN RATE -->

                    <div class="circulation-item">

                        <div class="circulation-top">

                            <span class="circulation-label">
                                Return Rate
                            </span>

                            <span class="circulation-value">
                                <?php
                                echo $returnRate;
                                ?>%
                            </span>

                        </div>

                        <div class="progress">

                            <span
                                style="
                                width:
                                <?php
                                echo $returnRate;
                                ?>%;
                                "
                            ></span>

                        </div>

                    </div>


                </div>


            </div>


        </section>


        <!-- =================================================
             QUICK STATISTICS
        ================================================== -->

        <div class="panel" style="margin-bottom:20px;">

            <div class="panel-header">

                <div class="panel-title">

                    <h3>
                        ⚡ Quick Statistics
                    </h3>

                    <p>
                        Additional library information
                    </p>

                </div>

            </div>


            <div class="quick-grid">


                <?php foreach (
                    $quickReports as $report
                ): ?>

                    <div class="quick-card">

                        <div class="quick-icon">
                            <?php
                            echo safe(
                                $report["icon"]
                            );
                            ?>
                        </div>

                        <div class="quick-title">
                            <?php
                            echo safe(
                                $report["title"]
                            );
                            ?>
                        </div>

                        <div class="quick-value">
                            <?php
                            echo number_format(
                                $report["value"]
                            );
                            ?>
                        </div>

                        <div class="quick-description">
                            <?php
                            echo safe(
                                $report["description"]
                            );
                            ?>
                        </div>

                    </div>

                <?php endforeach; ?>


            </div>

        </div>


        <!-- =================================================
             POPULAR BOOKS + ACTIVITY
        ================================================== -->

        <section class="second-grid">


            <!-- POPULAR BOOKS -->

            <div class="panel">

                <div class="panel-header">

                    <div class="panel-title">

                        <h3>
                            🔥 Most Issued Books
                        </h3>

                        <p>
                            Books with highest circulation
                        </p>

                    </div>

                    <div class="panel-badge">
                        Top 5
                    </div>

                </div>


                <div class="table-wrapper">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    Rank
                                </th>

                                <th>
                                    Book
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Issues
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php foreach (
                            $popularBooks as $book
                        ): ?>

                            <tr>

                                <td>

                                    <div class="book-rank">

                                        <?php
                                        echo safe(
                                            $book["rank"]
                                        );
                                        ?>

                                    </div>

                                </td>


                                <td>

                                    <div class="book-name">

                                        <?php
                                        echo safe(
                                            $book["name"]
                                        );
                                        ?>

                                    </div>

                                    <div class="book-author">

                                        <?php
                                        echo safe(
                                            $book["author"]
                                        );
                                        ?>

                                    </div>

                                </td>


                                <td>

                                    <span class="category-badge">

                                        <?php
                                        echo safe(
                                            $book["category"]
                                        );
                                        ?>

                                    </span>

                                </td>


                                <td>

                                    <span class="issue-count">

                                        <?php
                                        echo number_format(
                                            $book["issues"]
                                        );
                                        ?>

                                    </span>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>


            </div>


            <!-- RECENT ACTIVITY -->

            <div class="panel">

                <div class="panel-header">

                    <div class="panel-title">

                        <h3>
                            🕒 Recent Activity
                        </h3>

                        <p>
                            Latest library operations
                        </p>

                    </div>

                </div>


                <div class="activity-list">


                    <?php foreach (
                        $recentActivity as $activity
                    ): ?>

                        <div class="activity-item">


                            <div class="activity-icon">

                                <?php
                                echo safe(
                                    $activity["icon"]
                                );
                                ?>

                            </div>


                            <div class="activity-content">

                                <div class="activity-title">

                                    <?php
                                    echo safe(
                                        $activity["title"]
                                    );
                                    ?>

                                </div>


                                <div class="activity-description">

                                    <?php
                                    echo safe(
                                        $activity["description"]
                                    );
                                    ?>

                                </div>


                                <div class="activity-time">

                                    <?php
                                    echo safe(
                                        $activity["time"]
                                    );
                                    ?>

                                </div>

                            </div>


                        </div>

                    <?php endforeach; ?>


                </div>

            </div>


        </section>


        <!-- =================================================
             FOOTER INFORMATION
        ================================================== -->

        <section class="footer-info">


            <div class="footer-card">

                <h4>
                    👨‍🎓 Student Members
                </h4>

                <p>

                    Total registered students:
                    <strong>
                        <?php
                        echo number_format(
                            $stats["total_students"]
                        );
                        ?>
                    </strong>

                    <br>

                    Faculty members:
                    <strong>
                        <?php
                        echo number_format(
                            $stats["total_faculty"]
                        );
                        ?>
                    </strong>

                </p>

            </div>


            <div class="footer-card">

                <h4>
                    ⚠️ Attention Required
                </h4>

                <p>

                    There are currently
                    <strong>
                        <?php
                        echo number_format(
                            $stats["overdue_books"]
                        );
                        ?>
                    </strong>

                    overdue books that may require
                    follow-up with students.

                </p>

            </div>


            <div class="footer-card">

                <h4>
                    💻 Digital Collection
                </h4>

                <p>

                    The library currently contains
                    <strong>
                        <?php
                        echo number_format(
                            $stats["ebooks"]
                        );
                        ?>
                    </strong>

                    digital/e-book resources.

                </p>

            </div>


        </section>


        <!-- =================================================
             FOOTER
        ================================================== -->

        <footer class="bottom-footer">

            © <?php echo date("Y"); ?>

            <?php echo safe($libraryName); ?>

            ·

            <?php echo safe($systemName); ?>

            ·

            Analytics Dashboard

        </footer>


    </main>

</div>


<!-- ========================================================
     JAVASCRIPT
========================================================= -->

<script>


    // ======================================================
    // DATA FROM PHP
    // ======================================================

    const months =
        <?php echo $monthsJson; ?>;

    const issues =
        <?php echo $issuesJson; ?>;

    const returns =
        <?php echo $returnsJson; ?>;

    const categoryNames =
        <?php echo $categoryNamesJson; ?>;

    const categoryValues =
        <?php echo $categoryValuesJson; ?>;

    const semesterNames =
        <?php echo $semesterNamesJson; ?>;

    const semesterValues =
        <?php echo $semesterValuesJson; ?>;


    // ======================================================
    // COMMON CHART OPTIONS
    // ======================================================

    const commonOptions = {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {

                labels: {

                    font: {

                        family: "Inter",

                        size: 11

                    },

                    usePointStyle: true,

                    padding: 15

                }

            }

        },

        scales: {

            x: {

                grid: {

                    display: false

                },

                ticks: {

                    font: {

                        family: "Inter",

                        size: 10

                    }

                }

            },

            y: {

                beginAtZero: true,

                grid: {

                    color:
                        "rgba(148,163,184,0.15)"

                },

                ticks: {

                    font: {

                        family: "Inter",

                        size: 10

                    }

                }

            }

        }

    };


    // ======================================================
    // MONTHLY ISSUE / RETURN CHART
    // ======================================================

    const monthlyCanvas =
        document.getElementById(
            "monthlyChart"
        );


    if (monthlyCanvas) {

        new Chart(

            monthlyCanvas,

            {

                type: "line",

                data: {

                    labels: months,

                    datasets: [

                        {

                            label: "Books Issued",

                            data: issues,

                            borderWidth: 3,

                            tension: 0.35,

                            pointRadius: 3,

                            pointHoverRadius: 6,

                            fill: false

                        },

                        {

                            label: "Books Returned",

                            data: returns,

                            borderWidth: 3,

                            tension: 0.35,

                            pointRadius: 3,

                            pointHoverRadius: 6,

                            fill: false

                        }

                    ]

                },

                options: commonOptions

            }

        );

    }


    // ======================================================
    // CATEGORY DOUGHNUT CHART
    // ======================================================

    const categoryCanvas =
        document.getElementById(
            "categoryChart"
        );


    if (categoryCanvas) {

        new Chart(

            categoryCanvas,

            {

                type: "doughnut",

                data: {

                    labels: categoryNames,

                    datasets: [

                        {

                            data: categoryValues,

                            borderWidth: 2

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    cutout: "62%",

                    plugins: {

                        legend: {

                            position: "bottom",

                            labels: {

                                font: {

                                    family: "Inter",

                                    size: 9

                                },

                                usePointStyle: true,

                                padding: 10

                            }

                        }

                    }

                }

            }

        );

    }


    // ======================================================
    // SEMESTER BAR CHART
    // ======================================================

    const semesterCanvas =
        document.getElementById(
            "semesterChart"
        );


    if (semesterCanvas) {

        new Chart(

            semesterCanvas,

            {

                type: "bar",

                data: {

                    labels: semesterNames,

                    datasets: [

                        {

                            label: "Students",

                            data: semesterValues,

                            borderWidth: 1,

                            borderRadius: 7

                        }

                    ]

                },

                options: commonOptions

            }

        );

    }


</script>


</body>

</html>
```
