// Function to validate the form before submission
function validateForm() {
    var departmentName = document.getElementById("department_name").value;
    var managerId = document.getElementById("manager_id").value;
  
    // Check if department name and manager are selected
    if (departmentName.trim() === "") {
      alert("Please enter a department name.");
      return false;
    }
  
    if (managerId === "") {
      alert("Please select a manager.");
      return false;
    }
  
    return true;
  }
  