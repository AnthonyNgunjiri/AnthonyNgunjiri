function submitForm() {
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const course = document.getElementById("course").value;

    const formData = new FormData();
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('course', course);

    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    // Get username, email, and password values
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // Create an AJAX request
    var xhr = new XMLHttpRequest();

    // Define the request parameters
    xhr.open("POST", "register.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Handle the response
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Response from register.php
                var response = xhr.responseText;

                // Check the response for success or failure
                if (response.includes("successful")) {
                    // If login was successful, display a confirmation box
                    var confirmation = confirm("Login successful. User details inserted into the login table. Do you want to proceed?");
                    if (confirmation) {
                        // Redirect or perform further actions after confirmation
                        // Example: window.location.href = "dashboard.html";
                    } else {
                        // Handle cancellation
                    }
                } else {
                    // If login failed, display an alert box
                    alert("Invalid username, email, or password");
                }

                // You can perform further actions based on the response here
            } else {
                // Handle errors
                console.error('Error: ' + xhr.status);
            }
        }
    };

    // Prepare and send the request with login details
    xhr.send("username=" + username + "&email=" + email + "&password=" + password);
});

