// Wait for the DOM to be fully loaded before executing the script
document.addEventListener('DOMContentLoaded', function () {
    // Fetch user appointment data from the server
    fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_appointment.php', {
        credentials: 'include'
    })
        .then(response => response.json())
        .then(data => {
            // Check if the user is logged in
            if (data.loggedIn) {
                // Check if the user has an appointment
                if (data.user_info && data.user_info.date_appointment) {
                    // Display user information if an appointment exists
                    showUserInfo(data.user_info);
                    hideFormAppointment();
                } else {
                    // Show appointment form if no appointment exists
                    showForm();
                }
                // Set up form submission functionality
                setupFormSubmission();
                // Update available appointment times based on user information
                updateAvailableTimes(data.user_info);
            } else {
                // Hide appointment form and show registration text for logged-out users
                hideFormAppointment();
                showRegistrationText();
            }
        })
        .catch(error => console.error('Error:', error));
});

// Function to set up form submission logic
function setupFormSubmission() {
    let form = document.getElementById('appointment-form');
    let registrationText = document.getElementById('registration-text');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        let date = document.getElementById('date_app').value;
        let time = document.getElementById('time_app').value;
        let doctor = document.getElementById('doctor').value;

        let data = new FormData();
        data.append('date_app', date);
        data.append('time_app', time);
        data.append('doctor', doctor);

        // Send a request to the server to create an appointment
        fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_loadappointment.php', {
            method: 'POST',
            body: data
        })
            .then(response => response.json())
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    // Hide form and display success message or updated user information
                    hideFormAppointment();
                    registrationText.textContent = 'Appointment successfully created. You can change it by clicking the button below.';
                    if (data.user_info) {
                        showUserInfo(data.user_info);
                    }
                    location.reload();
                } else {
                    // Display error message if appointment creation fails
                    registrationText.textContent = 'Error: ' + data.error;
                }
            })
            .catch(error => console.error('Error:', error));
    });
}

// Function to display user information and related buttons
function showUserInfo(user) {
    let content = document.getElementById('content');
    // Remove existing user info and buttons
    removeExistingUserInfoAndButtons();

    // Create a new element to display the user's info
    let userInfo = document.createElement('div');
    userInfo.id = 'user-info';
    userInfo.className = 'user-info';
    userInfo.innerHTML = `
        <h2 class="appointment-title">Information about your appointment</h2>
        <p>First Name: ${user.fname}</p>
        <p>Last Name: ${user.sname}</p>
        <p>Email: ${user.email}</p>
        <p>Appointment Date: ${user.date_appointment}</p>
        <p>Appointment Time: ${user.time_appointment}</p>
        <p>Doctor: ${user.doctor}</p>
    `;

    content.appendChild(userInfo);

    // Create a button to change the appointment
    let changeButton = document.createElement('button');
    changeButton.id = 'change-button';
    changeButton.textContent = 'Change appointment';
    changeButton.className = 'change-button';
    changeButton.addEventListener('click', function () {
        showForm();
        removeExistingUserInfoAndButtons();
    });
    content.appendChild(changeButton);

    // Create a button to delete the appointment
    let deleteButton = document.createElement('button');
    deleteButton.id = 'delete-button';
    deleteButton.textContent = 'Delete appointment';
    deleteButton.className = 'delete-button';
    deleteButton.addEventListener('click', function () {
        if (!confirm('Are you sure you want to delete your appointment? You will be able to create new')) {
            return;
        }
        // Send a request to the server to delete the appointment
        fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_deleteappointment.php', {
            method: 'POST',
            credentials: 'include'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show form and remove existing user info and buttons
                    showForm();
                    removeExistingUserInfoAndButtons();
                    // Update the displayed user info if available
                    if (data.user_info && data.user_info.date_appointment) {
                        showUserInfo(data.user_info);
                    }
                } else {
                    console.error('Error:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    });
    content.appendChild(deleteButton);
}

// Function to remove existing user info and buttons
function removeExistingUserInfoAndButtons() {
    let userInfo = document.getElementById('user-info');
    let changeButton = document.getElementById('change-button');
    let deleteButton = document.getElementById('delete-button');

    if (userInfo) userInfo.remove();
    if (changeButton) changeButton.remove();
    if (deleteButton) deleteButton.remove();
}

// Function to display the appointment form
function showForm() {
    document.getElementById('appointment-form').style.display = 'flex';
}

// Function to hide the appointment form
function hideFormAppointment() {
    document.getElementById('appointment-form').style.display = 'none';
}

// Function to display the registration text
function showRegistrationText() {
    document.getElementById('registration-text').style.display = 'block';
}

// Function to update available appointment times based on server data
function updateAvailableTimes() {
    fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/get_appointments.php', {
        credentials: 'include'
    })
        .then(response => response.json())
        .then(appointments => {
            const dateInput = document.querySelector('#date_app');
            const doctorInput = document.querySelector('#doctor');
            const timeInput = document.querySelector('#time_app');

            function update() {
                const selectedDate = dateInput.value;
                const selectedDoctor = doctorInput.value;

                // Enable all time options
                Array.from(timeInput.options).forEach(option => {
                    option.disabled = false;
                });

                // Disable the time options that are already booked
                appointments.forEach(appointment => {
                    if (appointment.date === selectedDate && appointment.doctor === selectedDoctor) {
                        const option = document.querySelector(`#time_app option[value="${appointment.time}"]`);
                        if (option) {
                            option.disabled = true;
                        }
                    }
                });

                // If the currently selected time is disabled, clear the selection
                if (timeInput.selectedOptions[0] && timeInput.selectedOptions[0].disabled) {
                    timeInput.value = '';
                }
            }

            // Update the available times whenever the date or doctor changes
            dateInput.addEventListener('change', update);
            doctorInput.addEventListener('change', update);

            // Update the available times initially
            update();
        })
        .catch(error => console.error('Error:', error));
}
