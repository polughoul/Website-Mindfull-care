document.addEventListener('DOMContentLoaded', function () {
    // Get form elements and other necessary page elements
    const form = document.getElementById('form');
    const submitButton = document.getElementById('submit-button');
    const successMessage = document.getElementById('registration_success_message');
    const Error = document.getElementById('error');
    ValidateSignin();


    function validateForm() {
        const fieldsToValidate = [
            { id: 'fname', minLength: 2, maxLength: 24, regex: /^[A-Za-z]+$/, errorMessage: 'Name should have at least 2 characters and maximum 24 characters.' },
            { id: 'sname', minLength: 2, maxLength: 24, regex: /^[A-Za-z]+$/, errorMessage: 'Surname should have at least 2 characters and maximum 24 characters.' },
            { id: 'date', errorMessage: 'Please select your date of birth.' },
            { id: 'email', regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, errorMessage: 'Invalid email address.' },
            { id: 'tel', regex: /^\+\d{3}\s\d{3}\s\d{3}\s\d{3}$/, errorMessage: 'Invalid phone number format. Please use +xxx xxx xxx xxx.' },
            { id: 'uname', minLength: 1, maxLength: 24, regex: /^[A-Za-z0-9]+$/, errorMessage: 'Username should have at least 1 character and maximum 24 characters and no special characters.' },
            { id: 'password', regex: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()-+]+$/, minLength: 6, errorMessage: 'Password should contain at least one letter, one number and no spaces. Minimum 6 symbols.' },
            { id: 'repassword', errorMessage: 'Password dont match' },
            { id: 'secret_question', minLength: 5, maxLength: 50, regex: /^[A-Za-z0-9\s]+$/, errorMessage: 'Secret question should have at least 5 characters and maximum 50 characters. No special characters' },
            { id: 'secret_answer', minLength: 4, maxLength: 50, regex: /^[A-Za-z0-9\s]+$/, errorMessage: 'Secret answer should have at least 4 characters and maximum 50 characters. No special characters' }
        ];

        // Iterate over fields for validation
        for (const field of fieldsToValidate) {
            const element = document.getElementById(field.id);
            const value = element.value.trim();
            // Check the value of the field using a regular expression if specified
            if (field.regex && !field.regex.test(value)) {
                setError(field.errorMessage);
                element.classList.add('invalidField');
                return;
            }
            // Check the length of the field value if minLength or maxLength parameters are specified
            if (field.minLength && value.length < field.minLength || field.maxLength && value.length > field.maxLength) {
                setError(field.errorMessage);
                element.classList.add('invalidField');
                return;
            }

            // If the field value passes all checks, remove the error class
            element.classList.remove('invalidField');
        }

        clearError();
        submitForm();
    }

    // Function to submit the form
    function submitForm() {
        const formData = new FormData(form);
        fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_signin.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.style.display = 'none';
                    successMessage.style.display = 'block';
                } else {
                    setError(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to set an error message
    function setError(message) {
        Error.textContent = message;
    }
    // Function to clear the error message
    function clearError() {
        Error.textContent = '';
    }
    // Function to validate the form when the button is clicked
    function ValidateSignin() {
        submitButton.addEventListener('click', function (event) {
            event.preventDefault();
            validateForm();
        });
    }
});
