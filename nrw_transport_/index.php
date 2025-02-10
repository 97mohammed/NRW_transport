<?php
include("config.php");

$sql = "SELECT * FROM linien";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NRW Transport Linien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Public transport links in NRW</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Linien Nummer</th>
                    <th>Start Haltestelle</th>
                    <th>End Haltestelle</th>
                    <th>Betriebszeit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['liniennummer']}</td>
                            <td>{$row['start_haltestelle']}</td>
                            <td>{$row['end_haltestelle']}</td>
                            <td>{$row['betriebszeit']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>NO DATA!</td></tr>";
                }
                closeConnection($conn);
                ?>
            </tbody>
        </table>
    </div>
    <?php include("add_linie.php"); ?>
</body>
</html>