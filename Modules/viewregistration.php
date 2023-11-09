<!DOCTYPE html>
<html>

<head>
    <title>Registered Students</title>
    <link rel="stylesheet" href="../styles/registration.css">
</head>

<body>
    <div class="container">
        <h2>Registered Students</h2>
        <table>
            <tr>
                <th>UMID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Project Title</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php
           require_once '../connection.php';

            $sql = "SELECT students.umid, students.first_name, students.last_name, students.project_title, students.email, students.phone_number, time_slots.date, time_slots.time
            FROM students
            INNER JOIN registrations ON students.umid = registrations.student_umid
            INNER JOIN time_slots ON registrations.time_slot_id = time_slots.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["umid"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] . "</td><td>" . $row["project_title"] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone_number"] . "</td><td>" . $row["date"] . "</td><td>" . $row["time"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No registered students found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>

</html>
