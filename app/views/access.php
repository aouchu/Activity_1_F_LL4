<?php if(isset($_SESSION['logged_in'])) {
    redirect(site_url()."/mail");
} else {

} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Mailing with Session</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@300&display=swap');

    /* BASIC */

    html {
    background-image: url('public/background.gif');
    background-repeat: no-repeat;
    background-size: cover;
    }

    body {
    font-family: 'Exo 2', sans-serif;
    height: 100vh;
    }

    a {
    color: #92badd;
    display:inline-block;
    text-decoration: none;
    font-weight: 400;
    }

    h2 {
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    display:inline-block;
    margin: 40px 8px 10px 8px; 
    color: #cccccc;
    }

    h2.msg {
        text-transform: none !important;
        word-break: break-word;
    }


    /* STRUCTURE */

    .wrapper {
    display: flex;
    align-items: center;
    flex-direction: column; 
    justify-content: center;
    width: 100%;
    min-height: 100%;
    padding: 20px;
    }

    #formContent {
    -webkit-border-radius: 10px 10px 10px 10px;
    border-radius: 10px 10px 10px 10px;
    background: #fff;
    padding: 30px;
    width: 90%;
    max-width: 450px;
    position: relative;
    padding: 0px;
    -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
    box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
    text-align: center;
    }

    #formFooter {
    background-color: #f6f6f6;
    border-top: 1px solid #dce8f1;
    padding: 25px;
    text-align: center;
    -webkit-border-radius: 0 0 10px 10px;
    border-radius: 0 0 10px 10px;
    }



    /* TABS */

    h2.inactive {
    color: #cccccc;
    }

    h2.active {
    color: #0d0d0d;
    border-bottom: 2px solid rgb(167,116,129);
    }



    /* FORM TYPOGRAPHY*/

    input[type=button], input[type=submit], input[type=reset]{
    background-color: rgb(167,116,129);
    border: none;
    color: white;
    padding: 15px 166px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    text-transform: uppercase;
    font-size: 13px;
    -webkit-box-shadow: 0 10px 30px 0 rgba(167,116,129, 0.4);
    box-shadow: 0 10px 30px 0 rgba(167,116,129, 0.4);
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
    margin: 5px 5px 40px 5px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    }

    input[type=submit].verify {
        padding: 15px 80px !important;
    }

    button {
        background-color: rgb(167,116,129);
        border: none;
        color: white;
        padding: 15px 20px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        font-size: 13px;
        -webkit-box-shadow: 0 10px 30px 0 rgba(167,116,129, 0.4);
        box-shadow: 0 10px 30px 0 rgba(167,116,129, 0.4);
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover, button:hover  {
    background-color: rgb(135,96,115);
    }

    input[type=button]:active, input[type=submit]:active, input[type=reset]:active, button:active  {
    -moz-transform: scale(0.95);
    -webkit-transform: scale(0.95);
    -o-transform: scale(0.95);
    -ms-transform: scale(0.95);
    transform: scale(0.95);
    }

    input[type=text], input[type=email], input[type=password] {
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px;
    width: 85%;
    border: 2px solid #f6f6f6;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
    }

    input[type=text]:focus, input[type=email]:focus, input[type=password]:focus {
    background-color: #fff;
    border-bottom: 2px solid rgb(167,116,129);
    }

    input[type=text]:placeholder, input[type=email]:placeholder, input[type=password]:placeholder {
    color: #cccccc;
    }



    /* ANIMATIONS */

    /* Simple CSS3 Fade-in-down Animation */
    .fadeInDown {
    -webkit-animation-name: fadeInDown;
    animation-name: fadeInDown;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    }

    @-webkit-keyframes fadeInDown {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(0, -100%, 0);
        transform: translate3d(0, -100%, 0);
    }
    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
    }

    @keyframes fadeInDown {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(0, -100%, 0);
        transform: translate3d(0, -100%, 0);
    }
    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
    }

    /* Simple CSS3 Fade-in Animation */
    @-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    @-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    .fadeIn {
    opacity:0;
    -webkit-animation:fadeIn ease-in 1;
    -moz-animation:fadeIn ease-in 1;
    animation:fadeIn ease-in 1;

    -webkit-animation-fill-mode:forwards;
    -moz-animation-fill-mode:forwards;
    animation-fill-mode:forwards;

    -webkit-animation-duration:1s;
    -moz-animation-duration:1s;
    animation-duration:1s;
    }

    .fadeIn.first {
    -webkit-animation-delay: 0.4s;
    -moz-animation-delay: 0.4s;
    animation-delay: 0.4s;
    }

    .fadeIn.second {
    -webkit-animation-delay: 0.6s;
    -moz-animation-delay: 0.6s;
    animation-delay: 0.6s;
    }

    .fadeIn.third {
    -webkit-animation-delay: 0.8s;
    -moz-animation-delay: 0.8s;
    animation-delay: 0.8s;
    }

    .fadeIn.fourth {
    -webkit-animation-delay: 1s;
    -moz-animation-delay: 1s;
    animation-delay: 1s;
    }

    .fadeIn.fifth {
    -webkit-animation-delay: 1.2s;
    -moz-animation-delay: 1.2s;
    animation-delay: 1.2s;
    }
    .fadeIn.sixth {
    -webkit-animation-delay: 1.4s;
    -moz-animation-delay: 1.4s;
    animation-delay: 1.4s;
    }
    .fadeIn.seven {
    -webkit-animation-delay: 1.6s;
    -moz-animation-delay: 1.6s;
    animation-delay: 1.6s;
    }
    /* Simple CSS3 Fade-in Animation */
    .underlineHover:after {
    display: block;
    left: 0;
    bottom: -10px;
    width: 0;
    height: 2px;
    background-color: rgb(167,116,129);
    content: "";
    transition: width 0.2s;
    }

    .underlineHover:hover {
    color: #0d0d0d;
    }

    .underlineHover:hover:after{
    width: 100%;
    }

    /* OTHERS */

    *:focus {
        outline: none;
    } 

    .hidden {
        display: none;
    }

    .pointer {
        cursor: pointer;
    }

    #icon {
    width:35%;
    height:35%;
    }

    * {
    box-sizing: border-box;
    }
</style>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 id='signin' class="pointer <?php if(strpos($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], "sent")): ?><?= 'inactive underlineHover' ?><?php else:?><?= 'active';?><?php endif; ?>"> Sign In </h2>
            <h2 id='signup' class="pointer <?php if(strpos($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], "sent")): ?><?= 'inactive underlineHover' ?><?php else:?><?= 'inactive underlineHover';?><?php endif; ?>">Sign Up </h2>
            <h2 id='verify' class="pointer <?php if(strpos($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], "sent")): ?><?= 'active ' ?><?php else:?><?= 'inactive underlineHover';?><?php endif; ?>">Verify </h2>

            <!-- Icon -->
            <div class="fadeIn first">
            <img src="public/user.svg" id="icon" alt="User Icon" />
            </div>

            <!-- flashmessage -->
            <?php if(isset($_SESSION['msg'])): ?>
            <div class="fadeIn first">
                <h2 class='msg'><?= $_SESSION['msg'];?></h2>
            <div>
            <?php endif; ?>
            

            <!-- formvalidation errors -->
            <?php if(isset($errors)): ?>
            <div class="fadeIn first">
                <h2 class='msg'><?= $errors; ?></h2>
            <div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action='/signin' method='post' id='signinform' class='<?php if(strpos($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], "sent")): ?><?= 'hidden' ?><?php else: endif; ?>'>
            <input type="text" id="username_log" class="fadeIn second" name="username_log" id='' placeholder="username">
            <input type="password" id="password_log" class="fadeIn third" name="password_log" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Sign in">
            </form>

            <!-- Register Form -->
            <form action='/signup' method='post' id='signupform' class='<?php if(strpos($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], "sent")): ?><?= 'hidden'; ?><?php else: echo 'hidden'; endif;?>'>
            <input type="text" id="name" class="fadeIn second" name="name" placeholder="name">
            <input type="text" id="username" class="fadeIn third" name="username" placeholder="username">
            <input type="email" id="email" class="fadeIn fourth" name="email" placeholder="email">
            <input type="password" id="password" class="fadeIn fifth" name="password" placeholder="password">
            <input type="password" id="confirmpassword" class="fadeIn sixth" name="confirmpassword" placeholder="confirm password">
            <input type="submit" class="fadeIn seven" value="Sign up">
            </form>

            <!-- Verify Form -->
            <form action='/verify' method='post' id='verifyform' class='<?php if(strpos($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], "sent")): ?><?php else: ?><?= 'hidden' ?><?php endif; ?>'>
            <?php if(isset($_SESSION['email']) && isset($_SESSION['status'])): ?>
                <?php if($_SESSION['status'] == 'INACTIVE'): ?>
                    <input type="email" class="fadeIn fourth" value="<?= $_SESSION['email'] ?>" readonly>
                    <input type="text" id="code" class="fadeIn fifth" name="code" maxlength="6" placeholder="verification code">
                    <button type="submit" class="fadeIn sixth" name="resend" value="Resend Code">Resend Code</button>
                    <input type="submit" name="verify" class="fadeIn seven verify" value="submit">
                <?php else:?>
                    <input type="text" class="fadeIn fourth" value="You are already verified." readonly>
                <?php endif;?>
            <?php else: ?>
                <input type="email" id="email" class="fadeIn fourth" name="email" placeholder="email">
                <input type="submit" class="fadeIn fifth" value="verify" name="verifying">
            <?php endif; ?>
            </form>

            </div>
        </div>
    </div>
</body>
<script>
    const signin = document.getElementById("signin");
    const signup = document.getElementById("signup");
    const verify = document.getElementById("verify");
    const signinform = document.getElementById("signinform");
    const signupform = document.getElementById("signupform");
    const verifyform = document.getElementById("verifyform");

    const signinview = function () {
        signup.classList.remove("active");
        signup.classList.add("inactive");
        signup.classList.add("underlineHover");
        signin.classList.add("active");
        signin.classList.remove("inactive");
        signin.classList.remove("underlineHover");
        verify.classList.remove("active");
        verify.classList.add("inactive");
        verify.classList.add("underlineHover");

        signinform.classList.remove("hidden");
        signupform.classList.add("hidden"); 
        verifyform.classList.add("hidden");
    };

    const signupview = function () {
        signin.classList.remove("active");
        signin.classList.add("inactive");
        signin.classList.add("underlineHover");
        signup.classList.add("active");
        signup.classList.remove("inactive");
        signup.classList.remove("underlineHover");
        verify.classList.remove("active");
        verify.classList.add("inactive");
        verify.classList.add("underlineHover");

        signinform.classList.add("hidden");
        signupform.classList.remove("hidden");
        verifyform.classList.add("hidden");
    };

    const verifyview = function () {
        signin.classList.remove("active");
        signin.classList.add("inactive");
        signin.classList.add("underlineHover");
        verify.classList.add("active");
        verify.classList.remove("inactive");
        verify.classList.remove("underlineHover");
        signup.classList.remove("active");
        signup.classList.add("inactive");
        signup.classList.add("underlineHover");

        signinform.classList.add("hidden");
        verifyform.classList.remove("hidden");
        signupform.classList.add("hidden");
    }

    signin.addEventListener("click", signinview);
    signup.addEventListener("click", signupview);
    verify.addEventListener("click", verifyview);
</script>
</html>