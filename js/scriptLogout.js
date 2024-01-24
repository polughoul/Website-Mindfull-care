document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.getElementById('logout-btn');
    // Check if the logout button exists
    if (logoutBtn) {

        // Add a click event listener to the logout button
        logoutBtn.addEventListener('click', function () {
            // Ask the user to confirm the logout
            const confirmLogout = confirm("Are you sure you want to logout?");

            // Check if the user confirmed the logout
            if (confirmLogout) {
                // Send a request to the logout script
                fetch('/~stasiand/Semestralka_zwa/semestralka/scripts_php/script_logout.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page
                            location.reload();
                            // Redirect to the home page
                            window.location.href = 'home.php';

                        } else {    // Logout failed
                            console.error('Logout failed:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    }
});
