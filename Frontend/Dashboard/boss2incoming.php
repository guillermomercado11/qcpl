<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home</title>


     <!-- ======= Styles ====== -->
    <link rel="shortcut icon" type="image/x-icon" href="imgs/logo.png">
    <link rel="stylesheet" href="boss2account.css">

    <!-- ======= Boxiocns ====== -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>

     <!-- =============== Navigation ================ -->
     <div class="sidebar close">
        <div class="logo-details">
            <span class="img">
                <img src="imgs/logo.png" >
            </span>
          <span class="logo_name">Quezon City Public Library</span>
        </div>
        
        <ul class="nav-links">
    
          
          <li>
            <div class="iocn-link">
              <a href="boss2account.php">
              <i class='bx bx-file-blank' ></i>
                <span class="link_name">Document</span>
              </a>
              <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
              <li><a href="boss2incoming.php">Incoming</a></li>
              <li><a href="boss2outgoing.php">Outgoing</li>
            </ul>
          </li>

          <li>
            <a href="/qcpl/Backend/logout.php">
              <i class='bx bxs-log-out' ></i>
              <span class="link_name">Sign Out</span>
            </a>
          </li>
    

      </li>
      </ul>
      </div>

        <!-- ========================= Main ==================== -->
        <section class="home-section">
            <div class="home-content">
              <i class='bx bx-menu' ></i>
        
            </div>

         <!-- ========================= Boss Incoming ==================== -->
             <div class="details">
                <div class="upload">
                    <div class="cardHeader">
                    <h2>INCOMING</h2> 
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

                            $sql = "SELECT subject, description, locator_num, received_date, received_from, proofreader_comment, boss2_comment, status 
                                    FROM fileupload 
                                    WHERE category = 'Incoming' AND status = 'First Review' 
                                    ORDER BY received_date DESC 
                                    LIMIT $rowsPerPage OFFSET $offset";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) { 
                                echo "<table>";
                                echo "<tr>
                                        <th>Locator Number</th>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Received Date</th>
                                        <th>Received From</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>";
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><center>" . $row["locator_num"] . "</td>";
                                    echo "<td><center>" . $row["subject"] . "</td>";
                                    echo "<td><center>" . $row["description"] . "</td>";
                                    echo "<td><center>" . $row["received_date"] . "</td>";
                                    echo "<td><center>" . $row["received_from"] . "</td>";
                                    echo "<td><center>" . $row["status"] . "</td>";
                                    echo "<td><center><a href='boss2accountlocator.php?locator_num=" . htmlspecialchars($row["locator_num"]) . "' target='_self'>View</a></td>";
                                    echo "</tr>";
                                }
                                echo "</table>";

                                $sqlCount = "SELECT COUNT(*) AS total FROM fileupload WHERE category = 'Incoming' AND status = 'First Review'";
                                $resultCount = $conn->query($sqlCount);
                                $rowCount = $resultCount->fetch_assoc()['total'];
                                $totalPages = ceil($rowCount / $rowsPerPage);

                                echo "<div class='pagination'>";
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo "<a href='boss2incoming.php?page=$i'>$i</a>";
                                }
                                echo "</div>";
                            } else {
                                echo "<p>No records found.</p>";
                            }

                            $conn->close();
                            ?>
                    </div> 
                </div>
        </section>
               
<!-- ========================= Script ==================== -->
<script src="main.js"></script>

<!-- ========================= Ionicons ==================== -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>