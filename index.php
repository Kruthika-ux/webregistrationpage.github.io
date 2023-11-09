

<!DOCTYPE html>
<html>

<head>
    <title>Web Technology Class Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container mt-5">
        <h2>Web Technology Class Registration</h2>
        <a href="Modules/viewregistration.php" class="btn btn-secondary mt-3">View Registered Students</a>
        <form action="Modules/registration.php" method="post">
            <div class="form-group">
                <label for="UMID">UMID:</label>
                <input type="text" class="form-control" id="UMID" name="UMID" required>
            </div>
            <div class="form-group">
                <label for="FirstName">First Name:</label>
                <input type="text" class="form-control" id="FirstName" name="FirstName" required>
            </div>
            <div class="form-group">
                <label for="LastName">Last Name:</label>
                <input type="text" class="form-control" id="LastName" name="LastName" required>
            </div>
            <div class="form-group">
                <label for="ProjectTitle">Project Title:</label>
                <input type="text" class="form-control" id="ProjectTitle" name="ProjectTitle">
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="PhoneNumber">Phone Number:</label>
                <input type="tel" class="form-control" id="PhoneNumber" name="PhoneNumber" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                <small>Format: 999-999-9999</small>
            </div>
            <div class="form-group">
                <label for="TimeSlot">Time Slot:</label>
                <select class="form-control" id="TimeSlot" name="TimeSlot" required>
                <?php
    // Replace with your database credentials
    $servername = "kg-gopinathan-cis252.ctj4hvirfb3t.us-east-2.rds.amazonaws.com";
    $username = "admin";
    $password = "Placement17";
    $dbname = "StudentRegistration";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch time slot options from the database
    $sql = "SELECT id, date, time, seats_available FROM time_slots  WHERE seats_available > 0";
    $result = $conn->query($sql);

   // Generate <option> tags based on the fetched data

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["id"] . "'>" . $row["date"] . ", " . $row["time"] . ", " . $row["seats_available"] . " seats remaining</option>";
    }
} else {
    echo "<option value=''>No available slots</option>";
}

$conn->close();
?>
          </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
       
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        // Client-side validation example for the phone number
        const phoneNumberInput = document.getElementById('PhoneNumber');
        phoneNumberInput.addEventListener('input', function (e) {
            const inputValue = e.target.value;
            if (!/^\d{3}-\d{3}-\d{4}$/.test(inputValue)) {
                phoneNumberInput.setCustomValidity('Please enter a valid phone number in the format XXX-XXX-XXXX');
            } else {
                phoneNumberInput.setCustomValidity('');
            }
        });
    </script>
</body>

</html>
