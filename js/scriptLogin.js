document.addEventListener('DOMContentLoaded', function () {
    // DOM elements
    const form = document.getElementById('form');
    const submitButton = document.getElementById('submit-button');
    const errorElement = document.getElementById('error');
    const forgotButton = document.getElementById('forgot-password-button');
    const resetPasswordFields = document.getElementById('reset-password-fields');
    const uname = document.getElementById('uname');
    const password = document.getElementById('password');
    const unameLabel = document.getElementById('uname-label');
    const passwordLabel = document.getElementById('password-label');

    // Event listener for "Forgot Password" button
    forgotButton.addEventListener('click', function (event) {
        event.preventDefault();
        hideElements([unameLabel, passwordLabel, submitButton, errorElement, forgotButton]);

        // Add field for entering username
        resetPasswordFields.innerHTML = `
            <label class="form_label" for="uname-reset" id="uname-reset-label">
                <span>Username:<span class="required">*</span></span>
                <input class="form_input" type="text" id="uname-reset" name="uname-reset">
            </label>
            <button class="form_submit_btn login_submit_btn" id="continue-button">Continue</button>
        `;

        // Show reset password fields
        showElement(resetPasswordFields);
        const continueButton = document.getElementById('continue-button');
        // Event listener for "Continue" button after entering username
        continueButton.addEventListener('click', function (event) {
            event.preventDefault();
            const unameReset = document.getElementById('uname-reset');
            const unameResetValue = unameReset.value;
            const unameResetLabel = document.getElementById('uname-reset-label');

            // Fetch secret question based on entered username
            fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/get_secret_question.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ uname: unameResetValue })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        hideElements([errorElement, continueButton, unameResetLabel]);

                        // Display secret question and input for the answer
                        resetPasswordFields.innerHTML += `
                        <p id="secret-question" class="secret-question">${data.question}?</p>
                            <label class="form_label" for="secret-answer" id="secret-answer-label">
                                <span>Answer:<span class="required">*</span></span>
                                <input class="form_input" type="text" id="secret-answer" name="secret-answer">
                            </label>
                            <button class="form_submit_btn login_submit_btn" id="continue-button2">Continue</button>`;
                        const continueButton2 = document.getElementById('continue-button2');

                        // Event listener for "Continue" button after entering secret answer
                        continueButton2.addEventListener('click', function (event) {
                            event.preventDefault();
                            const secretAnswer = document.getElementById('secret-answer');
                            const secretAnswerValue = secretAnswer.value;
                            const secretAnswerLabel = document.getElementById('secret-answer-label');
                            const secretQuestion = document.getElementById('secret-question');

                            // Check the secret answer
                            fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/check_secret_answer.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ uname: unameResetValue, answer: secretAnswerValue })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        hideElements([errorElement, continueButton2, secretAnswerLabel, secretQuestion]);

                                        // Display fields for entering new password
                                        resetPasswordFields.innerHTML += `
                                        <label class="form_label" for="new-password">
                                        <span>New password:<span class="required">*</span></span>
                                        <input class="form_input" type="password" id="new-password" name="new-password"></label>
                                        <label class="form_label" for="confirm-password">
                                        <span>Confirm new password:<span class="required">*</span></span>
                                        <input class="form_input" type="password" id="confirm-password" name="confirm-password">
                                        </label>
                                        <button class="form_submit_btn login_submit_btn" id="reset-password-button">Reset Password</button>`;
                                        const resetPasswordButton = document.getElementById('reset-password-button');

                                        // Event listener for "Reset Password" button
                                        resetPasswordButton.addEventListener('click', function (event) {
                                            event.preventDefault();
                                            const newPassword = document.getElementById('new-password');
                                            const confirmPassword = document.getElementById('confirm-password');
                                            // Check if the elements exist
                                            if (!newPassword || !confirmPassword) {
                                                console.error('newPassword or confirmPassword element not found');
                                                return;
                                            }

                                            const newPasswordValue = newPassword.value;
                                            const confirmPasswordValue = confirmPassword.value;

                                            // Check the password
                                            if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()-+]+$/.test(newPasswordValue)) {
                                                displayError(errorElement, 'Password should contain at least one letter, one number and no spaces.');
                                                markFieldAsInvalid(newPassword);
                                                return;
                                            } else {
                                                newPassword.classList.remove('invalidField');
                                                clearError(errorElement);
                                            }
                                            if (newPasswordValue.length < 6) {
                                                displayError(errorElement, 'Password should have at least 6 characters');
                                                markFieldAsInvalid(newPassword);
                                                return;
                                            } else {
                                                newPassword.classList.remove('invalidField');
                                                clearError(errorElement);
                                            }
                                            if (newPasswordValue !== confirmPasswordValue) {
                                                displayError(errorElement, 'Password dont match');
                                                markFieldAsInvalid(newPassword);
                                                markFieldAsInvalid(confirmPassword);
                                                return;
                                            } else {
                                                newPassword.classList.remove('invalidField');
                                                confirmPassword.classList.remove('invalidField');
                                                clearError(errorElement);
                                            }

                                            // If all checks passed, send the new password to the server
                                            resetPassword(unameResetValue, newPasswordValue);
                                        })
                                    } else {
                                        displayError(errorElement, data.message);
                                        markFieldAsInvalid(secretAnswer);
                                    }

                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        })
                    } else {
                        displayError(errorElement, data.message);
                        markFieldAsInvalid(unameReset);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        })
    })
    // Event listener for login form submission
    submitButton.addEventListener('click', function (event) {
        event.preventDefault();

        clearError(errorElement);

        const formData = new FormData(form);
        fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_login.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data.message);
                    window.location.href = 'home.php';
                } else {
                    displayError(errorElement, data.message);
                    markFieldAsInvalid(uname);
                    markFieldAsInvalid(password);
                }
            })
    });

    // Function to reset password
    function resetPassword(username, newPassword) {
        fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/reset_password_login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ uname: username, password: newPassword })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Password reset successful. You can now log in with your new password.');
                    location.reload();
                } else {
                    displayError(errorElement, data.message);
                    markFieldAsInvalid(newPassword);
                    markFieldAsInvalid(confirmPassword);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Function to clear error message
    function clearError(errorElement) {
        errorElement.textContent = '';
    }
    // Function to display error message
    function displayError(errorElement, message) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    // Function to mark field as invalid
    function markFieldAsInvalid(field) {
        field.classList.add('invalidField');
    }
    // Function to hide an element
    function hideElement(element) {
        element.style.display = 'none';
    }
    // Function to show an element
    function showElement(element) {
        element.style.display = 'block';
    }
    // Function to hide multiple elements
    function hideElements(elements) {
        elements.forEach(element => hideElement(element));
    }
});
