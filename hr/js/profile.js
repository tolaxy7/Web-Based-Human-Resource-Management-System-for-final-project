// Wait for the DOM to be loaded
document.addEventListener("DOMContentLoaded", function () {
    // Get the form element
    const form = document.querySelector("form");
  
    // Add a submit event listener to the form
    form.addEventListener("submit", function (event) {
      // Check if any input fields are empty
      const inputs = form.querySelectorAll("input");
      let isValid = true;
  
      inputs.forEach(function (input) {
        if (input.value.trim() === "") {
          isValid = false;
          input.classList.add("error");
        } else {
          input.classList.remove("error");
        }
      });
  
      // Validate Ethiopian phone number format
      const phoneInput = form.querySelector("#phone");
      const phoneValue = phoneInput.value.trim();
      const phoneRegex = /^(09\d{8})|\+251\d{9}$/;
  
      if (!phoneRegex.test(phoneValue)) {
        isValid = false;
        phoneInput.classList.add("error");
      } else {
        phoneInput.classList.remove("error");
      }
  
      // Prevent form submission if any input field is empty or phone number is invalid
      if (!isValid) {
        event.preventDefault();
      }
    });
  });
  