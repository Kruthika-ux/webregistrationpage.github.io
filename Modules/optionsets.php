<?php
require_once '../connection.php';

// Retrieve time slot data from the database
$timeSlotQuery = "SELECT id, date, time, seats_available FROM time_slots";
$result = $conn->query($timeSlotQuery);
$options = '';

if ($result->num_rows > 0) {
    // Generate options for each time slot
    while ($row = $result->fetch_assoc()) {
        $optionValue = $row['id'];
        $optionText = $row['date'] . ', ' . $row['time'] . ', ' . $row['seats_available'] . ' seats remaining';
        $options .= "<option value=\"$optionValue\">$optionText</option>";
    }
} else {
    $options = "<option value=\"\">No time slots available</option>";
}

$conn->close();
?>
