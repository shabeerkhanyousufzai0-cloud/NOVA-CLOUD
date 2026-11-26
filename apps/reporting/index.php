
<?php
$dataFile = __DIR__ . "/../student-system/students.json";

$students = [];

if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
    if (is_array($data)) {
        $students = $data;
    }
}

$totalStudents = count($students);
$courseCounts = [];

foreach ($students as $student) {
    $course = $student["course"] ?? "Unknown";

    if (!isset($courseCounts[$course])) {
        $courseCounts[$course] = 0;
    }

    $courseCounts[$course]++;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NOVA CLOUD - Reports</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f5f9;
            margin: 40px;
        }

        h1, h2 { color: #173b65; }

        .box {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .number {
            font-size: 32px;
            color: #173b65;
            font-weight: bold;
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

        th {
            background: #173b65;
            color: white;
        }
    </style>
</head>

<body>

<h1>NOVA CLOUD</h1>
<h2>Student Reporting System</h2>

<div class="box">
    <h3>Total Students</h3>
    <div class="number">
        <?= $totalStudents ?>
    </div>
</div>

<div class="box">
    <h3>Course-wise Student Report</h3>

    <table>
        <tr>
            <th>Course</th>
            <th>Total Students</th>
        </tr>

        <?php foreach ($courseCounts as $course => $count): ?>
        <tr>
            <td><?= htmlspecialchars($course) ?></td>
            <td><?= $count ?></td>
        </tr>
        <?php endforeach; ?>

        <?php if (empty($courseCounts)): ?>
        <tr>
            <td colspan="2">No student records available.</td>
        </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
