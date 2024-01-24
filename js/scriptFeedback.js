document.addEventListener('DOMContentLoaded', function () {
    // Variable to track if the current user is an admin
    let currentUserIsAdmin = false;
    let currentPage = 1;
    const feedbacksPerPage = 4;
    let feedbacks = [];

    // Fetch user data from the server
    fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/users.json')
        .then(response => response.json())
        .then(usersData => {
            usersData.sort((a, b) => {
                let dateA = a.date_feedbacks ? new Date(a.date_feedbacks) : new Date(0);
                let dateB = b.date_feedbacks ? new Date(b.date_feedbacks) : new Date(0);
                return dateB - dateA;
            });

            let usernameField = document.getElementById('username');
            let username = usernameField.value;

            let currentUserData = usersData.find(user => user.uname === username);

            // Check if the current user is blocked
            if (currentUserData && currentUserData.isBlocked) {
                hideFormFeedback2();
            }

            // Check if the current user is an admin
            if (currentUserData && currentUserData.isAdmin) {
                currentUserIsAdmin = true;
            }

            // Loop through each user and collect their feedbacks
            usersData.forEach(user => {
                if (user.feedback) {
                    // Create HTML elements for feedback display
                    let feedbackElement = createFeedbackElement(user);

                    // Add delete button for the current user's feedback or if admin
                    if (user.uname === username || currentUserIsAdmin) {
                        let deleteButton = createDeleteButton(user.uname);
                        feedbackElement.appendChild(deleteButton);
                    }

                    // Add block button for admin
                    if (currentUserIsAdmin) {
                        let blockButton = createBlockButton(user.uname);
                        feedbackElement.appendChild(blockButton);
                    }

                    // Add feedback element to the array
                    feedbacks.push(feedbackElement);
                }
            });

            // Fetch login status and determine the display of the feedback form
            fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_feedback.php')
                .then(response => response.json())
                .then(data => {
                    if (data.loggedIn) {
                        if (currentUserData && currentUserData.feedback) {
                            hideFormFeedback1();
                        } else {
                            if (currentUserData && !currentUserData.isBlocked) {
                                showForm();
                            } else {
                                hideFormFeedback2();
                            }
                        }
                    } else {
                        hideFormFeedback1();
                        showRegistrationText();
                    }
                })
                .catch(error => console.error('Error:', error));

            // Display feedbacks for the initial page
            displayFeedbacks();

            // Add event listeners for pagination buttons
            document.getElementById('prev-button').addEventListener('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    displayFeedbacks();
                }
            });

            document.getElementById('next-button').addEventListener('click', function () {
                if (currentPage < Math.ceil(feedbacks.length / feedbacksPerPage)) {
                    currentPage++;
                    displayFeedbacks();
                }
            });
        })
        .catch(error => console.error('Error:', error));

    // Add submit event listener for the feedback form
    // Add submit event listener for the feedback form
    document.getElementById('feedback-form').addEventListener('submit', function (event) {
        event.preventDefault();

        let feedbackField = document.getElementById('feedback');
        let feedback = feedbackField.value;
        let usernameField = document.getElementById('username');
        let username = usernameField.value;
        let date = new Date().toISOString();

        // Fetch to submit feedback on the server
        fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_loadfeedback.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'feedback=' + encodeURIComponent(feedback) + '&username=' + encodeURIComponent(username) + '&date_feedbacks=' + encodeURIComponent(date)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    document.getElementById('error').textContent = data.message;
                    console.error('Error:', data.message);
                    return;
                }
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('error').textContent = 'An unexpected error occurred. Please try again later.';
            });
    });


    // Function to create HTML elements for feedback display
    function createFeedbackElement(user) {
        let feedbackElement = document.createElement('p');
        let avatarElement = document.createElement('img');
        let usernameElement = document.createElement('span');
        let dateElement = document.createElement('span');
        let date = new Date(user.date_feedbacks);
        let dateOptions = { year: 'numeric', month: '2-digit', day: '2-digit' };
        let timeOptions = { hour: '2-digit', minute: '2-digit', hour12: false };

        // Customize date display
        dateElement.textContent = date.toLocaleDateString(undefined, dateOptions) + ' ' + date.toLocaleTimeString(undefined, timeOptions);
        dateElement.style.fontSize = '0.8em';
        dateElement.style.color = '#888';

        // Append elements to the feedback container
        feedbackElement.appendChild(dateElement);
        usernameElement.textContent = user.uname;
        feedbackElement.appendChild(usernameElement);
        avatarElement.src = user.avatar;
        avatarElement.className = 'avatar';
        feedbackElement.insertBefore(avatarElement, usernameElement);
        feedbackElement.appendChild(document.createTextNode(user.feedback));

        return feedbackElement;
    }

    // Function to create a delete button
    function createDeleteButton(username) {
        let deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.className = 'delete-btn';
        deleteButton.dataset.username = username;

        // Add event listener for delete button
        deleteButton.addEventListener('click', function () {
            if (!confirm('Are you sure you want to delete the feedback?')) {
                return;
            }

            const username = this.dataset.username;

            // Fetch to delete the feedback on the server
            fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_deletefeedback.php', {
                method: 'POST',
                body: JSON.stringify({ username }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.parentElement.remove();
                        document.querySelector('#feedback-form').style.display = 'block';
                    } else {
                        console.error('Error:', data.error);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });

        return deleteButton;
    }

    // Function to create a block button
    function createBlockButton(username) {
        let blockButton = document.createElement('button');
        blockButton.textContent = 'Block';
        blockButton.className = 'block-btn';
        blockButton.dataset.username = username;

        // Add event listener for block button
        blockButton.addEventListener('click', function () {
            let username = this.dataset.username;

            if (!confirm('Are you sure you want to block this user?')) {
                return;
            }

            // Fetch to block the user on the server
            fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_blockuser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username: username }),
            })
                .then(response => response.text())
                .then(data => console.log(data))
                .catch((error) => {
                    console.error('Error:', error);
                });
        });

        return blockButton;
    }

    // Function to display the feedback form
    function showForm() {
        document.getElementById('feedback-form').style.display = 'flex';
    }

    // Function to hide the feedback form and display feedback form related feedbacks
    function hideFormFeedback1() {
        document.getElementById('feedback-form').style.display = 'none';
        document.getElementById('separator2').style.display = 'none';
    }

    // Function to hide the feedback form and display blocked user message
    function hideFormFeedback2() {
        document.getElementById('feedback-form').style.display = 'none';
        document.getElementById('banned_text').style.display = 'block';
    }

    // Function to display registration text
    function showRegistrationText() {
        document.getElementById('registration-text').style.display = 'block';
        document.getElementById('separator2').style.display = 'block';
    }

    // Function to display paginated feedbacks
    function displayFeedbacks() {

        let feedbacksContainer = document.getElementById('feedbacks');
        while (feedbacksContainer.firstChild) {
            feedbacksContainer.removeChild(feedbacksContainer.firstChild);
        }
        let start = (currentPage - 1) * feedbacksPerPage;
        let end = start + feedbacksPerPage;

        for (let i = start; i < end && i < feedbacks.length; i++) {
            feedbacksContainer.appendChild(feedbacks[i]);
        }
    }
});
