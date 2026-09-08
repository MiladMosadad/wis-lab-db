<?php
$message = "";
$messageType = "";

$conn = new mysqli("localhost", "root", "", "wis_lab");

if ($conn->connect_error) {
    $message = "Connection failed: " . $conn->connect_error;
    $messageType = "danger";
} else {
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(120) NOT NULL,
        department VARCHAR(80) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        $message = "Students table created successfully.";
        $messageType = "success";
    } else {
        $message = "Error creating table: " . $conn->error;
        $messageType = "danger";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Students Table - WIS Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h2 class="mb-4 text-center">Create Students Table</h2>

            <div class="alert alert-<?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

            <a href="insert_student.php" class="btn btn-primary">Go to Student Form</a>
            <a href="create_database.php" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
</body>
</html>
