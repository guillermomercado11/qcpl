<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Styles -->
    <link rel="shortcut icon" type="image/x-icon" href="imgs/logo.png">
    <link rel="stylesheet" href="style.css">
</head>

<body>
         <!-- =============== Navigation ================ -->
  <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="img">
                            <img src="imgs/logo.png" >
                        </span>
                        <span class="title">Quezon City Public Library</span>
                    </a>
                </li>
                
                <li>
                    <a href="dash.php" class="dropdown-toggle">
                    <span class="icon">
                    <ion-icon name="apps"></ion-icon>
                    </span>
                    <span class="title">Dashboard<ion-icon id="dash_down_btn" name="caret-down-outline"></ion-icon></span>
                    </a>
                    

                         <li class="sub_dash"><a href="incoming.php">Incoming</a></li>
                         <li class="sub_dash"><a href="outgoing.php">Outgoing</a></li>
                         <li class="sub_dash"><a href="approved.php">Approved</a></li>
                
                </li>
         
                <li>
                    <a href="user.php">
                        <span class="icon"><ion-icon name="people"></ion-icon></span>
                        <span class="title">Accounts<ion-icon id="acct_down_btn" name="caret-down-outline"></ion-icon></span>
                    </a>
                </li>


                <li>
                    <a href="doc.html">
                        <span class="icon">
                            <ion-icon name="add-circle"></ion-icon>
                        </span>
                        <span class="title">Upload Document</span>
                    </a>
                </li>

                <li>
                    <a href="adduser.html">
                        <span class="icon">
                            <ion-icon name="person-add"></ion-icon>
                        </span>
                        <span class="title" >Add Account</span>
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

        <!-- Main Content -->
        <div class="main">
            <div class="topbar">
                <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>

                <div class="user"><span class="icon"><ion-icon name="person"></ion-icon></span></div>
            </div>

            <!-- Document Summary -->
            <div class="details">
                <div class="upload">
                    <div class="cardHeader">
                        <h2>KUNG ANO DIVISION</h2>

                    <div class ="outgoing">
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

$sql = "SELECT * FROM fileupload WHERE status = 'Approved' LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("ii", $rowsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {                    
    echo "<table>";
    echo "<tr><th>Locator Number</th><th>Division</th><th>Section</th><th>Subject</th><th>Description</th><th>Receive From</th><th>Receive Date</th><th>Status</th><th>Action</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>" . $row["locator_num"] . "</center></td>";
        echo "<td><center>" . $row["division"] . "</center></td>";
        echo "<td><center>" . $row["section"] . "</center></td>";
        echo "<td><center>" . $row["subject"] . "</center></td>";
        echo "<td><center>" . $row["description"] . "</center></td>";
        echo "<td><center>" . $row["received_from"] . "</center></td>";
        echo "<td><center>" . $row["received_date"] . "</center></td>";
        echo "<td id='status'><center>" . $row["status"] . "</center></td>";
        echo "<td>" ."<center>". "<a href='adminlocator.php?locator_num=" . htmlspecialchars($row["locator_num"]) . "' target='_self'>View</a></td>";
        echo "</tr>";
    }
    echo "</table>";

    $prevPage = $page - 1;
    if ($prevPage > 0) {
        echo "<a href='?page=$prevPage' id='prev'><ion-icon name='arrow-back-circle'></ion-icon></a>";
    }
    $nextPage = $page + 1;
    echo "<a href='?page=$nextPage' id='next'><ion-icon name='arrow-forward-circle-sharp'></ion-icon></a>";
} else {
    echo "<p>No documents found.</p>";
}

$stmt->close();
$conn->close();
?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="main.js"></script>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
    