function checkEmailField(){
    var x, text;
    x = document.getElementById("email").value;

    if (x.length < 1) {
        text = "Email must not be empty";
        document.getElementById("email_field_msg_id").innerHTML = text;
        return false;
    }
}


// function pressHandler(e) {
//     console.log(this.value);
// }

// $( document ).ready(function() {
//     console.log( "ready!" );
// });

//document.getElementById("email").addEventListener("input",pressHandler);