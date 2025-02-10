<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("config.php");

    $liniennummer = $_POST['liniennummer'];
    $start_haltestelle = $_POST['start_haltestelle'];
    $end_haltestelle = $_POST['end_haltestelle'];
    $betriebszeit = $_POST['betriebszeit'];

    $stmt = $conn->prepare("INSERT INTO linien (liniennummer, start_haltestelle, end_haltestelle, betriebszeit) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $liniennummer, $start_haltestelle, $end_haltestelle, $betriebszeit);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }

    $stmt->close();
    closeConnection($conn);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Line</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <form id="addForm" class="mb-5">
            <div class="mb-3">
                <label class="form-label">Line Nummer</label>
                <input type="text" name="liniennummer" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Start Haltestelle</label>
                <input type="text" name="start_haltestelle" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">End Haltestelle</label>
                <input type="text" name="end_haltestelle" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Betriebszeit</label>
                <input type="text" name="betriebszeit" class="form-control" placeholder="05:30-02:30" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Line</button>
        </form>
    </div>

    <script>
        document.getElementById('addForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('add_linie.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Added Successfully!");
                    location.reload();
                } else {
                    alert("Error: " + data.error);
                }
            });
        });
    </script>
</body>
</html>