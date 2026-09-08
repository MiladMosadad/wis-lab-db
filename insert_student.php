<?php
$message = "";
$messageType = "";

$fullName = "";
$email = "";
$department = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $department = trim($_POST["department"] ?? "");

    if ($fullName === "" || $email === "" || $department === "") {
        $message = "All fields are required.";
        $messageType = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "danger";
    } else {
        $conn = new mysqli("localhost", "root", "", "wis_lab");

        if ($conn->connect_error) {
            $message = "Connection failed: " . $conn->connect_error;
            $messageType = "danger";
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO students (full_name, email, department) VALUES (?, ?, ?)"
            );

            if ($stmt) {
                $stmt->bind_param("sss", $fullName, $email, $department);

                if ($stmt->execute()) {
                    $message = "Student added successfully.";
                    $messageType = "success";

                    $fullName = "";
                    $email = "";
                    $department = "";
                } else {
                    $message = "Error inserting student: " . $stmt->error;
                    $messageType = "danger";
                }

                $stmt->close();
            } else {
                $message = "Error preparing statement: " . $conn->error;
                $messageType = "danger";
            }

            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System - WIS Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h2 class="mb-4 text-center">Add Student</h2>

            <?php if ($message !== ""): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" id="full_name" name="full_name"
                           class="form-control"
                           value="<?php echo htmlspecialchars($fullName); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email"
                           class="form-control"
                           value="<?php echo htmlspecialchars($email); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" id="department" name="department"
                           class="form-control"
                           value="<?php echo htmlspecialchars($department); ?>"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">Save Student</button>
                <button type="reset" class="btn btn-secondary">Clear</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
