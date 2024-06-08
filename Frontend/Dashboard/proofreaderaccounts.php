<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "qcpl";

$conn = new mysqli($server, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_boss2 = "SELECT * FROM boss2";
$result_boss2 = $conn->query($sql_boss2);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>

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
                </li>
         
                <li>
                    <a href="user.php">
                        <span class="icon"><ion-icon name="people"></ion-icon></span>
                        <span class="title">Accounts<ion-icon id="acct_down_btn" name="caret-down-outline"></ion-icon></span>
                        
                    </a>

                         <li class="sub_dash"><a href="usersaccounts.php">Users</a></li>
                         <li class="sub_dash"><a href="adminsaccounts.php">Admins</a></li>
                         <li class="sub_dash"><a href="boss1accounts.php">Boss 1</a></li>
                         <li class="sub_dash"><a href="boss2accounts.php">Boss 2</a></li>
                         <li class="sub_dash"><a href="receivingaccounts.php">Receiving</a></li>
                         <li class="sub_dash"><a href="proofreaderaccounts.php">Proof Reader</a></li>
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
                        <h2>PROOF READER</h2>

                    <div class ="accts_boss2">
                    <?php
                    $rowsPerPage = 4;
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $offset = ($page - 1) * $rowsPerPage;

                    $sql = "SELECT id, name, username, password FROM proofreader LIMIT ? OFFSET ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $rowsPerPage, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<table aria-describedby='boss2-table'>";
                        echo "<tr><th>ID</th><th>Name</th><th>Username</th><th>Password</th><th colspan='2'>Action</th></tr>";
                        echo "<tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><center>" . htmlspecialchars($row["id"]) . "</td>";
                            echo "<td><center>" . htmlspecialchars($row["name"]) . "</td>";
                            echo "<td><center>" . htmlspecialchars($row["username"]) . "</td>";
                            echo "<td><center>" . str_repeat("*", strlen($row["password"])) . "</td>";
                            echo "<td id='boss2_edit'><center><a href='/qcpl/Backend/updateboss2accounts.php?id=" . htmlspecialchars($row["id"]) . "'>Edit</a></td>";
                            echo "<td id='boss2_delete'><center><a href='#' onclick='confirmDeleteBoss2(" . htmlspecialchars($row["id"]) . ")'>Delete</a></td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";

                        $prevPage = $page - 1;
                        if ($prevPage > 0) {
                            echo "<a href='?page=$prevPage' id='prev'><ion-icon name='arrow-back-circle'></ion-icon></a>";
                        }
                        $nextPage = $page + 1;
                        echo "<a href='?page=$nextPage' id='next' > <ion-icon name='arrow-forward-circle-sharp'></ion-icon></a>";
                    } else {
                        echo "<script>alert('No Boss 2 Account found!'); window.location.href = '?page=1';</script>";
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
function confirmDeleteBoss2(boss2Id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/qcpl/Backend/deleteaccount.php?id=' + boss2Id;
        }
    });
}
</script>


    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
    