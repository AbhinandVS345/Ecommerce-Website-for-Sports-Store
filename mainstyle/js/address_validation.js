document.addEventListener("DOMContentLoaded", function() {
    
    // Get the form
    var form = document.querySelector(".address-form");

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

    //Get the pincode field
    var pincode=document.getElementById("pincode");
    var pinError=document.getElementById("pinError");

    //function to check phone number format
    function validatePincodeFormat(){
        var pincodePattern = /^\d{6}$/;

        if(!pincodePattern.test(pincode.value)){
            pinError.textContent = "Invalid pincode. It should be 6 digits.";
            return false;
        }
        else{
            pinError.textContent = "";
            return true;
        }

    }

    // add event listner to phone number field
    pincode.addEventListener("blur",validatePincodeFormat);



   // Add event listener to the form submit event
   form.addEventListener("submit", function(event) {
    // Validate phone number and password match before submitting
    if (!validatePincodeFormat() || !validateName() || !validatePhonenumberFormat()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
    });



});