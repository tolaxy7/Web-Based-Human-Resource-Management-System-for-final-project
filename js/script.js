// Get the login modal and login buttons
var modal = document.getElementById("login-modal");
var loginButtons = document.getElementById("login-buttons").getElementsByTagName("button");

// Display the login modal when the login button is clicked
function displayLogin() {
    var modal = document.getElementById("login-modal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("login-modal");
    modal.style.display = "none";
}


// Loop through the login buttons and add a click event listener to each one
for (var i = 0; i < loginButtons.length; i++) {
    loginButtons[i].addEventListener("click", function() {
        // Do something when a login button is clicked
    });
}
