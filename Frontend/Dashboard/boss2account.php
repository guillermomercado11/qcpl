<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boss 2 Account</title>

    <!-- ======= Styles ====== -->
    <link rel="shortcut icon" type="image/x-icon" href="imgs/logo.png">
    <link rel="stylesheet" href="boss2account.css">
</head>

<body>

    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="img">
                            <img src="imgs/logo.png">
                        </span>
                        <span class="title">Quezon City Public Library</span>
                    </a>
                </li>
                
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="documents-outline"></ion-icon>
                        </span>
                        <span class="title">Document<ion-icon id="dash_down_btn" name="caret-down-outline"></ion-icon</span>
                        <li class="sub_dash"><a href="boss2incoming.php">Incoming</a></li>
                         <li class="sub_dash"><a href="boss2outgoing.php">Outgoing</a></li>
                    </a>
                </li>

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
        

                <div class="user">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>

                </div>
            </div>

            <div class="details">
                <div class="upload">
                    <div class="cardHeader">
                    <h2> SUMMARY </h2>
                     </div>
                        <div class="sum_tb">
                        <table aria-describedby="tableDescription">
    <?php
session_start(); 
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

$sql = "SELECT * FROM fileupload WHERE status ='First Review' LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("ii", $rowsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {                    
    echo "<table>";
    echo "<tr><th>Locator Number</th><th>Subject</th><th>Description</th><th>Division</th><th>Section</th><th>Receive From</th><th>Receive Date</th><th>Category</th><th>Status</th><th>Action</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>" . $row["locator_num"] . "</td>";
        echo "<td><center>" . $row["subject"] . "</td>";
        echo "<td><center>" . $row["description"] . "</td>";
        echo "<td><center>" . $row["division"] . "</td>";
        echo "<td><center>" . $row["section"] . "</td>";
        echo "<td><center>" . $row["received_from"] . "</td>";
        echo "<td><center>" . $row["received_date"] . "</td>";
        echo "<td><center>" . $row["category"] . "</td>";
        echo "<td><center>" . $row["status"] . "</td>";
        echo "<td>" ."<center>". "<a href='boss2accountlocator.php?locator_num=" . htmlspecialchars($row["locator_num"]) . "' target='_self'>View</a></td>";
        echo "</tr>";
    }
    echo "</table>";

    $prevPage = $page - 1;
    if ($prevPage > 0) {
        echo "<a href='?page=$prevPage' id='prev'><ion-icon name='arrow-back-circle'></ion-icon></a>";
    }
    $nextPage = $page + 1;
    echo "<a href='?page=$nextPage' id='next' ><ion-icon name='arrow-forward-circle-sharp'></ion-icon></a>";
} else {
    echo "<p>No Approved Document.</p>";
}

$stmt->close();
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