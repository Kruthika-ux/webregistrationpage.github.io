<?php
session_start();
require_once '../connection.php';





// Escape user inputs for security
$UMID = $_POST['UMID'];
$FirstName = $_POST['FirstName'];
$LastName = $_POST['LastName'];
$ProjectTitle = $_POST['ProjectTitle'];
$Email = $_POST['Email'];
$PhoneNumber = $_POST['PhoneNumber'];
$TimeSlot = $_POST['TimeSlot'];

// Get the time slot ID and available seats
$seatsQuery = "SELECT id, seats_available FROM time_slots WHERE id = ?";
$stmt = $conn->prepare($seatsQuery);
$stmt->bind_param("i", $TimeSlot);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $timeSlotID = $row['id'];
    $seatsAvailable = $row['seats_available'];

    if ($seatsAvailable > 0) {
        // Check if the student is already registered
        $check_query = "SELECT * FROM registrations WHERE student_umid = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $UMID);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            if (isset($_POST['change_registration'])) {
                // Delete the student's existing registration
                $deleteRegistrationQuery = "DELETE FROM registrations WHERE student_umid = ?";
                $stmt = $conn->prepare($deleteRegistrationQuery);
                $stmt->bind_param("s", $UMID);
                $stmt->execute();

                // Insert the student's new registration
                $insertRegistrationQuery = "INSERT INTO registrations (student_umid, time_slot_id) VALUES (?,?)";
                $stmt = $conn->prepare($insertRegistrationQuery);
                $stmt->bind_param("si", $UMID, $timeSlotID);
                $stmt->execute();

                // Decrement available seats
                $seatsAvailable--;
                $updateSeatsQuery = "UPDATE time_slots SET seats_available = ? WHERE id = ?";
                $stmt = $conn->prepare($updateSeatsQuery);
                $stmt->bind_param("ii", $seatsAvailable, $TimeSlot);
                $stmt->execute();

                echo "Your registration has been changed successfully.";
            } else {
                echo "You are already registered for a different time slot. Do you want to change your registration to the new section?";
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="change_registration" value="1">';
                echo '<input type="hidden" name="UMID" value="' . $UMID . '">';
                echo '<input type="hidden" name="FirstName" value="' . $FirstName . '">';
                echo '<input type="hidden" name="LastName" value="' . $LastName . '">';
                echo '<input type="hidden" name="ProjectTitle" value="' . $ProjectTitle . '">';
                echo '<input type="hidden" name="Email" value="' . $Email . '">';
                echo '<input type="hidden" name="TimeSlot" value="' . $TimeSlot . '">';
                echo '<input type="hidden" name="PhoneNumber" value="' . $PhoneNumber . '">';
                echo '<input type="submit" value="Yes">';
                echo '</form>';
            }
        } else {
            // Attempt insert query execution
            $insertQuery = "INSERT INTO students (umid, first_name, last_name, project_title, email, phone_number) VALUES (?,?,?,?,?,?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssssss", $UMID, $FirstName, $LastName, $ProjectTitle, $Email, $PhoneNumber);

            if ($stmt->execute()) {
                // Insert into registrations table
                $registrationQuery = "INSERT INTO registrations (student_umid, time_slot_id) VALUES (?,?)";
                $stmt = $conn->prepare($registrationQuery);
                $stmt->bind_param("si", $UMID, $timeSlotID);

                if ($stmt->execute()) {
                    // Decrement available seats
                    $seatsAvailable--;
                    $updateSeatsQuery = "UPDATE time_slots SET seats_available = ? WHERE id = ?";
                    $stmt = $conn->prepare($updateSeatsQuery);
                    $stmt->bind_param("ii", $seatsAvailable, $TimeSlot);

                    if ($stmt->execute()) {
                        echo "New record created successfully";
                        // Commit the transaction
                        $conn->commit();
                        header("Location: ../Modules/viewregistration.php");
exit();
                    } else {
                        echo "Error updating seats: " . $stmt->error;
                        error_log("Error updating seats: " . $stmt->error);
                    }
                } else {
                    echo "Error: " . $stmt->error;
                    error_log("Error: " . $stmt->error);
                }
            } else {
                echo "Error: " . $stmt->error;
                error_log("Error: " . $stmt->error);
            }
        }
    } else {
        echo "No available seats for this time slot.";
    }
} else {
    echo "Invalid time slot ID";
}

$conn->close();
?>
