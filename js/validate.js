function validateForm() {
    var emailID= document.getElementById("emailSu").value;

    //var firstname= document.getElementById("fname").value;
    var atposition=emailID.indexOf("@");
    var dotposition=emailID.lastIndexOf(".");
    if (atposition<1 || dotposition<atposition+2 || dotposition+2>=emailID.length){
        alert("Please enter a valid e-mail address.");
  return false;
  }
}
