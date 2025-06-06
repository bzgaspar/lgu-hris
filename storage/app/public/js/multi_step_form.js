var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Save";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    setTimeout(function () {
        document.getElementById("regForm").submit();
    }, 5000);
    document.getElementById("waiting").style.display = "inline";
    return false;
  }else{
    document.getElementById("waiting").style.display = "none";
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var valid = true;
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}

$("#same_check").click(copyDate);
function copyDate() {
    if (this.checked == true) {
        $("#h_b_l_no_2").val($("#h_b_l_no").val());
        $("#street_2").val($("#street").val());
        $("#village_2").val($("#village").val());
        $("#barangay_2").val($("#barangay").val());
        $("#city_2").val($("#city").val());
        $("#province_2").val($("#province").val());
        $("#zipcode_2").val($("#zipcode").val());
    } else {
        $("#h_b_l_no_2").val("");
        $("#street_2").val("");
        $("#village_2").val("");
        $("#barangay_2").val("");
        $("#city_2").val("");
        $("#province_2").val("");
        $("#zipcode_2").val("");
    }
}
