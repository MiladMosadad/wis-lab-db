<?php
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $databaseName = trim($_POST["database_name"] ?? "");

    $conn = new mysqli("localhost", "root", "");

    if ($conn->connect_error) {
        $message = "Connection failed: " . $conn->connect_error;
        $messageType = "danger";
    } elseif ($databaseName === "") {
        $message = "Please enter a database name.";
        $messageType = "warning";
    } elseif (!preg_match("/^[A-Za-z0-9_]+$/", $databaseName)) {
        $message = "Invalid database name. Use only letters, numbers, and underscores.";
        $messageType = "danger";
    } else {
        $sql = "CREATE DATABASE `$databaseName`";

        if ($conn->query($sql) === TRUE) {
            $message = "Database '$databaseName' created successfully.";
            $messageType = "success";
        } else {
            $message = "Error creating database: " . $conn->error;
            $messageType = "danger";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Database - WIS Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <h2 class="mb-4 text-center">Create Database</h2>

            <?php if ($message !== ""): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="database_name" class="form-label">Database Name</label>
                    <input type="text" id="database_name" name="database_name"
                           class="form-control" placeholder="Example: wis_lab"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">Create Database</button>
                <button type="reset" class="btn btn-secondary">Clear</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
