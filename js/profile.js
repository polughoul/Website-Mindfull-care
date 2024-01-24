// Function to load user information and populate fields on the page
function loadUserInfo() {
    fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/get_user_info.php', {
        method: 'GET',
        credentials: 'include'
    })
        .then(response => response.json())
        .then(user => {
            document.getElementById('fname').textContent = user.fname;
            document.getElementById('sname').textContent = user.sname;
            document.getElementById('date').textContent = user.date;
            document.getElementById('email').textContent = user.email;
            document.getElementById('tel').textContent = user.tel;
            document.getElementById('uname').textContent = user.uname;
            document.getElementById('password').value = user.password;
            document.getElementById('avatar-img').src = user.avatar;
        })
        .catch(error => console.error('Error:', error));
}

// Function to handle clicks on edit buttons
function setupEditButtons() {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const field = this.dataset.field;
            const value = document.getElementById(field).textContent;
            const newValue = prompt(`Enter new ${field}`, value);
            if (newValue && newValue !== value) {
                updateUserInfo(field, newValue);
            }
        });
    });
}

// Function to send a request to update user information
function updateUserInfo(field, value) {
    fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/update_user_info.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ field, value }),
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                document.getElementById(field).textContent = value;
                alert('Information updated successfully');
            } else {
                alert(result.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/// Function to handle submission of the avatar upload form
function setupAvatarUploadForm() {
    document.getElementById('upload-avatar-form').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData();
        formData.append('avatar', document.getElementById('avatar').files[0]);

        uploadAvatar(formData);
    });
}

// Function to send a request to upload a new avatar
function uploadAvatar(formData) {
    fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/upload_avatar.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Avatar uploaded successfully');
                document.getElementById('avatar-img').src = URL.createObjectURL(document.getElementById('avatar').files[0]);
                document.getElementById('error').textContent = '';
            } else {
                document.getElementById('error').textContent = result.error;
            }
        })
        .catch(error => {
            console.error('Error:', error)
            document.getElementById('error').textContent = 'An error occurred while uploading the avatar.';
        });
}

// Function to handle clicks on the delete account button
function setupDeleteAccountButton() {
    document.getElementById('delete-account').addEventListener('click', function() {
        if (confirm('Are you sure you want to delete your account? This cannot be undone.')) {
            deleteAccount();
        }
    });
}

// Function to send a request to delete the account
function deleteAccount() {
    fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/delete_account.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'login.php';
            } else {
                alert('Error: ' + data.error);
            }
        });
}

// Function to handle submission of the reset password form
function setupResetPasswordForm() {
    document.getElementById('reset-password-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        resetPassword(formData);
    });
}

// Function to send a request to reset the password
function resetPassword(formData) {
    fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/reset_password_profile.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (!confirm('Are you sure you want to reset your password?')) {
                    return;
                }
                alert('Password has been reset.');
            } else {
                alert('Error: ' + data.error);
            }
        });
}

// Event listener for the page load event
window.addEventListener('DOMContentLoaded', (event) => {

    loadUserInfo();

    setupEditButtons();

    setupAvatarUploadForm();

    setupDeleteAccountButton();

    setupResetPasswordForm();
});