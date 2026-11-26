
<?php
$file = "students.json";

$students = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

if (!is_array($students)) {
    $students = [];
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course = trim($_POST["course"] ?? "");

    if ($name !== "" && filter_var($email, FILTER_VALIDATE_EMAIL) && $course !== "") {
        $students[] = [
            "id" => count($students) + 1,
            "name" => $name,
            "email" => $email,
            "course" => $course
        ];

        file_put_contents(
            $file,
            json_encode($students, JSON_PRETTY_PRINT),
            LOCK_EX
        );

        header("Location: index.php");
        exit;
    } else {
        $message = "Please enter valid student details.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NOVA CLOUD - Student System</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            background: #f2f5f9;
        }
        h1, h2 { color: #173b65; }
        .box {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        input, select, button {
            padding: 10px;
            margin: 7px 0;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background: #173b65;
            color: white;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th { background: #173b65; color: white; }
    </style>
</head>
<body>

<h1>NOVA CLOUD</h1>
<h2>Student Management System</h2>

<div class="box">
    <h3>Add New Student</h3>

    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>

    <form method="POST">
        <input type="text" name="name" placeholder="Student Name" required>

        <input type="email" name="email" placeholder="Student Email" required>

        <select name="course" required>
            <option value="">Select Course</option>
            <option>Cloud Computing</option>
            <option>Web Development</option>
            <option>Networking</option>
            <option>Cybersecurity</option>
        </select>

        <button type="submit">Add Student</button>
    </form>
</div>

<div class="box">
    <h3>View Students</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
        </tr>

        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= htmlspecialchars((string)$student["id"]) ?></td>
            <td><?= htmlspecialchars($student["name"]) ?></td>
            <td><?= htmlspecialchars($student["email"]) ?></td>
            <td><?= htmlspecialchars($student["course"]) ?></td>
        </tr>
        <?php endforeach; ?>

        <?php if (empty($students)): ?>
        <tr>
            <td colspan="4">No students added yet.</td>
        </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>

