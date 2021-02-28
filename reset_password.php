<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="styles/background.css">
        <link rel="stylesheet" href="styles/reset_password.css">
        <title>
            ATM - Reset password
        </title>
    </head>
    <body>
        <div class="login_background">
            <div class="logo_div">
                <div class="logo_text">
                    ATM
                </div>
                <form class="reset_pass_form" action="index.php">
                    <input type="text" id="email" name="email" placeholder="Email"><br>
                    <input class="btn" type="submit" value="Reset my password">
                </form> 
                <div class="back_button_div">
                    <a href="index.php"><button class="btn cancel_register_btn" type="button">Back</button></a>
                </div>
            </div>
        </div>
    </body>
</html>