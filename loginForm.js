//validate username and passsword input
function validateform(){
    var user =  document.forms["loginform"]["username"].value;
    var pass =  document.forms["loginform"]["password"].value;
    if (user == ""){
    alert("Username must be filled.")
    }
    if (pass == ""){
    alert("Password must be filled.")
    }
}

