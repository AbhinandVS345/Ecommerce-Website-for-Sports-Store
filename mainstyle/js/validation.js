document.addEventListener("DOMContentLoaded", function() {
    
    // Get the form
    var form = document.querySelector(".sign-in-form");

    //get the customername field
    var customername=document.getElementById("name");
    var nameError=document.getElementById("nameError");

    function validateName(){
        var namePattern=/^[a-zA-Z-' ]*$/;

        if(!namePattern.test(customername.value)){
            nameError.textContent="Only letters and white space allowed";
            return false;
        }
        else
        {
            nameError.textContent="";
            return true;
        }

    }

    customername.addEventListener("blur",validateName);

    //Get the phone number field
    var phno=document.getElementById("phno");
    var phnoError=document.getElementById("phoneError");

    //function to check phone number format
    function validatePhonenumberFormat(){
        var phoneNumberPattern = /^\d{10}$/;

        if(!phoneNumberPattern.test(phno.value)){
            phnoError.textContent = "Invalid phone number. It should be 10 digits.";
            return false;
        }
        else{
            phnoError.textContent = "";
            return true;
        }

    }

    // add event listner to phone number field
    phno.addEventListener("blur",validatePhonenumberFormat);


    // Get the email field
    var email=document.getElementById("email");
    var emailError=document.getElementById("emailError");

    //function to check email validation
    function validateEmail() {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    
        // Check if the email matches a general format
        if (!emailPattern.test(email.value)) {
            emailError.textContent = "Invalid email format.";
            return false;
        }
        
        // Check if the email ends with @gmail.com
        if (!email.value.endsWith("@gmail.com")) {
            emailError.textContent = "Email must be a Gmail address.";
            return false;
        }
    
        emailError.textContent = ""; // Clear any error messages if valid
        return true;
    }
    
    //add event listner to email field
    email.addEventListener("blur",validateEmail);

    // Get the password and confirm password fields
    var password = document.getElementById("password");
    var confPassword = document.getElementById("confpassword");
    var passwordError = document.getElementById("passwordError");

    // Function to check if passwords match
    function checkPasswordsMatch() {
        if (password.value !== confPassword.value) {
            passwordError.textContent = "Passwords do not match";
            return false;
        } else {
            passwordError.textContent = "";
            return true;
        }
    }

    // Add event listener to the confirm password field
    confPassword.addEventListener("blur", checkPasswordsMatch);

   // Add event listener to the form submit event
   form.addEventListener("submit", function(event) {
    // Validate phone number and password match before submitting
    if (!validatePhonenumberFormat() || !validateEmail()|| !checkPasswordsMatch()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
    });



});