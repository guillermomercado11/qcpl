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

if ($result_boss2->num_rows > 0) {
    echo "<h2>BOSS 2</h2>";
    echo "<table aria-describedby='boss2-table'>";
    echo "<tr><th>ID</th><th>Name</th><th>Division</th><th>Username</th><th>Password</th><th colspan='2'>Action</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($row = $result_boss2->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>" .  htmlspecialchars($row["id"]) . "</td>";
        echo "<td><center>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td><center>" . htmlspecialchars($row["division"]) . "</td>";
        echo "<td><center>" . htmlspecialchars($row["username"]) . "</td>";
        echo "<td><center>" . str_repeat("*", strlen($row["password"])) . "</td>";
        echo "<td><center><a href='updateuseradmin.php?id=" . htmlspecialchars($row["id"]) . "'>Edit</a></td>";
        echo "<td><center><a href='deleteuseradmin.php?id=" . htmlspecialchars($row["id"]) . "'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No Boss 2 found.</p>";
}
$conn->close();
?>