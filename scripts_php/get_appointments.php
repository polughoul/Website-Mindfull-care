<?php
/**
 * Retrieve appointments from user data.
 *
 * This function reads the users.json file, extracts appointment information
 * (date, time, and doctor) for users with appointments, and returns the
 * appointments as a JSON-encoded response.
 *
 * @return void This function outputs the JSON-encoded appointments.
 */
function getAppointments(): void
{
    // Load user data from the users.json file
    $usersData = json_decode(file_get_contents('users.json'), true);
    $appointments = [];

    // Extract appointment information for users with appointments
    foreach ($usersData as $user) {
        if (isset($user['date_appointment']) && isset($user['time_appointment']) && isset($user['doctor'])) {
            $appointments[] = [
                'date' => $user['date_appointment'],
                'time' => $user['time_appointment'],
                'doctor' => $user['doctor']
            ];
        }
    }

    // Output the JSON-encoded appointments
    echo json_encode($appointments);
}

getAppointments();
