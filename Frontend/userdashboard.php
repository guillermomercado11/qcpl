<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>

    <!-- ======= Styles ====== -->
    <link rel="shortcut icon" type="image/x-icon" href="img/Logo.png">
    <link rel="stylesheet" href="userdashboard.css">
</head>
<body>

     <!-- =============== Navigation ================ -->
     <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="img">
                            <img src="img/Logo.png" >
                        </span>
                        <span class="title">Quezon City Public Library</span>
                    </a>
                </li>
                
                <li>
                    <a href="userdashboard.php" class="dropdown-toggle">
                    <span class="icon">
                    <ion-icon name="apps"></ion-icon>
                    </span>
                    <span class="title">Dashboard<ion-icon id="dash_down_btn" name="caret-down-outline"></ion-icon></span>
                    </a>
                    

                         <li class="sub_dash"><a href="userincomingdash.php">Incoming</a></li>
                         <li class="sub_dash"><a href="useroutgoingdash.php">Outgoing</a></li>
                
                <li>
                    <a href="useroutgoing.php" class="dropdown-toggle">
                    <span class="icon">
                    <ion-icon name="add-circle"></ion-icon>
                    </span>
                    <span class="title">Upload Document</span>
                    </a>
                </li>

                <li>
                    <a href="/qcpl/Backend/logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                
                
            <form action="/qcpl/Backend/locator.php" method="GET">
                <div class="search">
                    <label>
                        <input type="number" name="locator" placeholder="Search here">
                        <input type="submit" id="sub_hide" name="find">
                        <ion-icon name="search-outline" name="locate"></ion-icon>
                    </label>
                </div>
            </form>
               

                <div class="user">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                </div>
            </div>

            <div class="details">
                <div class="upload">
                    <div class="cardHeader">
                        <h2>DOCUMENTS</h2>   
                        </div>
                    <div class="sum_tb">
                        <table aria-describedby="tableDescription">
                        <?php
$server = "localhost";
$username = "root";
$password = "";
$db = "qcpl";

$conn = new mysqli($server, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rowsPerPage = 4;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$offset = ($page - 1) * $rowsPerPage;

$sql = "SELECT division, section, category, locator_num, received_date, received_from, status FROM fileupload LIMIT $rowsPerPage OFFSET $offset";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Locator Number</th><th>Division</th><th>Section</th><th>Received From</th><th>Received Date</th><th>Category</th><th>Status</th><th>Action</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["locator_num"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["division"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["section"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["received_from"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["received_date"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["category"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
        echo "<td id='table_th'><center><a href='useraccountlocator.php?locator_num=" . htmlspecialchars($row["locator_num"]) . "' target='_self aria-label='View details for " . htmlspecialchars($row["locator_num"]) . "'>View</a></td>";
        echo "</tr>";
    }

    echo "</table>";

    $sql_count = "SELECT COUNT(*) AS total_count FROM fileupload";
    $result_count = $conn->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $total_records = $row_count['total_count'];
    $total_pages = ceil($total_records / $rowsPerPage);

    echo "<div style='text-align: center; margin-top: 20px;'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=$i'>" . $i . "</a> ";
    }
    echo "</div>";
} else {
    echo "<script>alert('No documents found!');</script>";
}

$conn->close();
?>

                    </div> 
                    
                </div>
               
    <!-- =========== Scripts =========  -->
    <script src="main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>