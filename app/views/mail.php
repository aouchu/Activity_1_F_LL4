<?php if(isset($_SESSION['logged_in'])) {

} else {
    redirect(site_url().'/');
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

    * {
        padding:0;
        margin:0;
        font-family: 'Exo 2', sans-serif;
    }
    body {
        padding:2dvh;
        display: flex;
        justify-content: center;
        background-image: url('public/background.gif');
        background-repeat: no-repeat;
        background-size: cover;
    }
    .box {
        border: .1dvh solid rgba(0,0,0,30%);
        padding:1dvh;
        border-radius:3dvh;
        width:80%;
        height:100%;
        background-color: white;
    }
    .header {
        background-color: rgb(135,96,115);
        color:white;
        margin-bottom:1dvh;
        padding:.5dvh;
        border-radius:3dvh;
    }
    #user {
        float: right;
    }
    #logout {
        color: #cccccc;
        font-size:smaller;
        margin-right: 1dvh;
    }
    .content {
        display: flex;
    }
    .sub {
        padding:1dvh;
        width: 50%;
    }
    .group {
        margin:1dvh;
        display:flex;
    }
    .label {
        width:40%;
        font-size:3dvh;
    }
    .sublabel {
        font-size:2.5dvh !important;
    } 
    .form {
        background-color:rgb(225, 206, 213);
        border-radius:3dvh;
        margin-top:1dvh;
        margin-bottom;1dvh;
    }
    .preview {
        color:rgb(135,96,115);
    }
    a {
        text-decoration: none;
    }
    a:link {
        color:white;
    }
    a:hover {
        color:rgb(225, 206, 213) !important;
    }
    a:active {
        color:rgb(251, 242, 184);
    }
    a:visited {
        color:white;
    }
    h1, h3, h4 {
        margin:.5dvh;
        margin-left:1.5dvh !important;
    }
    label.active {
        border-bottom: 2px solid rgb(167,116,129);
        font-weight:bold;
    }
    #simplecontent, .designcontent {
        margin-left: 10%;
    }
    #contentpreview, #content2preview, #content3preview {
        margin-left: 10%;
        white-space: normal;
    }
    #mailmessage, #mailsubject, #mailrecipient, #message {
        word-break: break-word;
    }
    .prev {
        margin-left:0% !important;
    }
    footer {
        width: 100%;
        background-color:rgb(135,96,115);
        color: white;
        text-align: center;
    }
    textarea {
        overflow: auto;
        resize: none;
        text-align:justify !important;
}
    button.active {
        background-color: rgb(135,96,115);
    }
    button:hover {
        background-color: rgb(135,96,115);
    }
    button {
        background-color: rgb(167,116,129);
        border: none;
        color: white;
        padding: 15px 5dvh;
        text-align: center;
        display:inline;
        text-decoration: none;
        text-transform: uppercase;
        font-size: 13px;
        -webkit-box-shadow: 0 10px 30px 0 rgba(167,116,129, 0.4);
        box-shadow: 0 10px 30px 0 rgba(167,116,129, 0.4);
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        margin: .5dvh 1dvh 1dvh;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    input[type=button], input[type=submit], input[type=reset]  {
    background-color: rgb(167,116,129);
    width: 97%;
    border: none;
    color: white;
    padding: 15px 80px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    text-transform: uppercase;
    font-size: 13px;
    -webkit-box-shadow: 0 10px 30px 0 rgba(167,116,129, 0.4);
    box-shadow: 0 10px 30px 0 rgba(167,116,129, 0.4);
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
    margin: .5dvh 1dvh 1dvh;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    }

    input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
    background-color: rgb(135,96,115);
    }

    input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
    -moz-transform: scale(0.95);
    -webkit-transform: scale(0.95);
    -o-transform: scale(0.95);
    -ms-transform: scale(0.95);
    transform: scale(0.95);
    }

    input[type=text], input[type=email], textarea{
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding-top: 1dvh;
    padding-bottom: 1dvh;
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

    input[type=text]:focus, input[type=email]:focus, textarea:focus {
    background-color: #fff;
    border-bottom: 2px solid rgb(167,116,129);
    }

    input[type=text]:placeholder, input[type=email]:placeholder, textarea:placeholder {
    color: #cccccc;
    }

    [type="file"] {
  height: 0;
  overflow: hidden;
  width: 0;
}

[type="file"] + label {
    background: #f15d22;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    width: 60%;
    font-family: 'Rubik', sans-serif;
	font-size: inherit;
    font-weight: 500;
    text-align: center;
    margin-bottom: 1rem;
    outline: none;
    padding: 1rem 40px;
    position: relative;
    transition: all 0.3s;
    vertical-align: middle;
  
  &:hover {
    background-color: darken(#f15d22, 10%);
  }
  
  &.btn-2 {
    background-color: rgb(167,116,129);
    border-radius: 50px;
    overflow: hidden;
    
    /* */
    &::before {
      color: #fff;
      content: "\25bc";
      font-family: "Font Awesome 5 Pro";
      font-size: 100%;
      height: 100%;
      right: 130%;
      line-height: 3.3;
      position: absolute;
      top: 0px;
      transition: all 0.3s;
    }

    &:hover {
      background-color: darken(#99c793, 30%);
        
      &::before {
        right: 75%;
      }
    }
  }
}


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

    *:focus {
        outline: none;
    } 
    .hidden {
        display:none;
    }

</style>
<body>
    <?php 
    
    ?>
    <div class='box fadeInDown'>
        <div class='header'>
            <h1><a href='<?= site_url();?>/mail'>Mailing</a><span id='user'><?php if(isset($_SESSION['username'])): ?>Welcome, <?= $_SESSION['username']; ?>! &nbsp    <a href='/signout' id='logout'>Sign out</a><span><?php endif; ?></h1>
        </div>
        <hr>
        <div class='content'>
            <div class='sub form'>
                <div class='header'>
                    <h3>Send an Email</h3>
                </div>
                <!-- flash message -->
                    <?php if(isset($_SESSION['msg'])):?>
                        <div class='msg'>
                            <center>
                                <h4><?= $_SESSION['msg']; ?></h4>
                            </center>
                        </div>
                    <?php endif;?>
                <!-- end -->
                <center>
                <button class='button active' id='simple'>Simple Email</button> <button class='button' id='design'>Email with Design</button>
                </center>
                <form action='/send' method='post' enctype='multipart/form-data'>
                    <div class='group'>
                        <div  class='label'>
                            <label for='recipient' id='l_recipient'>Recipient:</label>
                        </div>
                        <input type='email' name='recipient' id='recipient' placeholder='recipient' />
                    </div>

                    <div class='group'>
                        <div  class='label'>
                            <label for='subject' id='l_subject'>Subject:</label>
                        </div>
                        <input type='text' name='subject' id='subject' placeholder='subject' /> 
                    </div>

                    <hr>
                    <div class='group'>
                        <div  class='label'>
                            <label id='l_emailcontent'>Email content:</label>
                        </div>
                    </div>
                    <hr>
                    <!-- simple email -->
                    <div id='simplecontent' class='group'>
                            <div  class='label sublabel'>
                                <label for='message' id='l_message'>Message:</label>
                            </div>
                            <textarea rows="8" name='message' id='message' placeholder='message'></textarea>
                    </div>
`                   <!-- end -->

                    <!-- Email with Design-->
                        <!-- header content -->
                            <div  class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='header' id='l_header'>Header:</label>
                                    </div>
                                    <input type='text' name='header' id='header' placeholder='header' />
                            </div>
                            <div  class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='content' id='l_content'>Content:</label>
                                    </div>
                                    <textarea rows='8' type='text' name='content' id='content' placeholder='content' ></textarea>
                            </div>
                        <!-- end-->
                        <!-- subcontent1 -->
                            <div class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='subheader' id='l_subheader'>Subheader:</label>
                                    </div>
                                    <input type='text' name='subheader' id='subheader' placeholder='subheader' />
                            </div>
                            <div class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='content2' id='l_content2'>Content:</label>
                                    </div>
                                    <textarea rows='8' type='text' name='content2' id='content2' placeholder='content2' ></textarea>
                            </div>
                            <div class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='image' id='l_image'>Image:</label>
                                    </div>
                                    <input type="file" id="image" />
                                    <label for="image" class="btn-2">upload</label>
                            </div>
                        <!-- end -->
                        <!-- subcontent2 -->
                            <div class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='subheader2' id='l_subheader2'>Subheader:</label>
                                    </div>
                                    <input type='text' name='subheader2' id='subheader2' placeholder='subheader2' />
                            </div>
                            <div class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='content3' id='l_content3'>Content:</label>
                                    </div>
                                    <textarea rows='8' type='text' name='content3' id='content3' placeholder='content3'></textarea>
                            </div>
                            <div class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='image2' id='l_image2'>Image:</label>
                                    </div>
                                    <input type="file" id="image2" />
                                    <label for="image2" class="btn-2">upload</label>
                            </div>
                        <!-- end -->
                        <!-- footer --> 
                            <div  class='group hidden designcontent'>
                                    <div  class='label sublabel'>
                                        <label for='footer' id='l_footer'>Footer:</label>
                                    </div>
                                    <textarea rows='5'type='text' name='footer' id='footer' placeholder='footer'></textarea>
                            </div>
                        <!-- end -->
                    <!-- end -->
                    <hr>
                    <div class='group'>
                                    <div  class='label'>
                                        <label for='attachment' id='l_attachment'>Attachment (Optional):</label>
                                    </div>
                                    <input type="file" id="attachment" />
                                    <label for="attachment" class="btn-2">upload</label>
                    </div>

                    <div>
                        <input type='submit'  value='Submit' />
                    </div>
                </form>
            </div>
            <div class='sub preview'>
                <center><h3>Preview</h3></center>
                <div id='simplepreview'>
                    <h3>Sender: <?= $_SESSION['email']; ?> </h3>
                    <hr>
                    <h3>Recipient: <span id='mailrecipient'></span></h3>
                    <hr>
                    <h3>Subject: <span id='mailsubject'></span></h3>
                    <hr>
                    <h3>Message: <br><span id='mailmessage'></span></h3>
                    <hr>
                    <h3>Attachment: <span id='mailattachment'></span></h3>
                </div>

                <div class='hidden designcontent prev'>
                    <h3 >Sender: <?= $_SESSION['email']; ?> </h3>
                    <hr>
                    <h3>Recipient: <span id='mailrecipient2'></span></h3>
                    <hr>
                    <h3>Subject: <span id='mailsubject2'></span></h3>
                    <hr>
                    <?php $emailwithhtmlcontent = "
                    <div id='designgrouper'>
                    <h3 id='headerpreview'>Sample header</h3>
                    <pre id='contentpreview'>Sample message under header. </pre>
                    <h4 id='subheaderpreview'>Sample subheader</h4>
                    <pre id='content2preview'>Sample message under subheader. </pre>
                    <img id='imagepreview' src='public/sample.jpg' height='20%' width='100%'>
                    <h4 id='subheader2preview'>Sample subheader</h4>
                    <pre id='content3preview'>Sample message under subheader. </pre>
                    <img id='imagepreview2' src='public/sample2.jpg' height='20%' width='100%'>
                    <footer><pre id='footerpreview'></pre></footer>
                    </div>
                    "; echo $emailwithhtmlcontent;?>
                    <hr>
                    <h3>Attachment: <span id='mailattachment2'> </span></h3>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
//design toggle
    const simple = document.getElementById('simplecontent');
    const simpleprev = document.getElementById('simplepreview');
    const design = document.getElementsByClassName('designcontent');
    const simplebutton = document.getElementById('simple');
    const designbutton = document.getElementById('design');

    const simpledesign = function () {
        simple.classList.remove('hidden');
        simpleprev.classList.remove('hidden');
        simplebutton.classList.add('active');
        designbutton.classList.remove('active');

        for(var i = 0; i < design.length; i++)
        {
            design[i].classList.add('hidden');
        }

    }

    const extradesign = function () {
        for(var i = 0; i < design.length; i++)
        {
            design[i].classList.remove('hidden');
        }
        simpleprev.classList.add('hidden');
        designbutton.classList.add('active');
        simplebutton.classList.remove('active');
        simple.classList.add('hidden');
    }

    simplebutton.addEventListener("click", simpledesign);
    designbutton.addEventListener("click", extradesign);

//form active
    const labelrecipient = document.getElementById("l_recipient");
    const inputrecipient = document.getElementById("recipient");

    const labelsubject = document.getElementById("l_subject");
    const inputsubject = document.getElementById("subject");

    const labelmessage = document.getElementById("l_message");
    const inputmessage = document.getElementById("message");

    const labelattachment = document.getElementById("l_attachment");
    const inputattachment = document.getElementById("attachment");

    const labelheader = document.getElementById("l_header");
    const inputheader = document.getElementById("header");

    const labelcontent = document.getElementById("l_content");
    const inputcontent = document.getElementById("content");

    const labelsubheader = document.getElementById("l_subheader");
    const inputsubheader = document.getElementById("subheader");

    const labelcontent2 = document.getElementById("l_content2");
    const inputcontent2 = document.getElementById("content2");

    const labelimage = document.getElementById("l_image");
    const inputimage = document.getElementById("image");

    const labelsubheader2 = document.getElementById("l_subheader2");
    const inputsubheader2 = document.getElementById("subheader2");

    const labelcontent3 = document.getElementById("l_content3");
    const inputcontent3 = document.getElementById("content3");

    const labelimage2 = document.getElementById("l_image2");
    const inputimage2 = document.getElementById("image2");

    const labelfooter = document.getElementById("l_footer");
    const inputfooter = document.getElementById("footer");
    
    const labelemailcontent = document.getElementById("l_emailcontent");

    const recipient = function () {
        labelrecipient.classList.add("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.remove("active");
    };

    const subject = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.add("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.remove("active");
    };

const message = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.add("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const header = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.add("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const content = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.add("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const subheader = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.add("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const content2 = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.add("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const image = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.add("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const subheader2 = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.add("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const content3 = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.add("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const image2 = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.add("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const footer = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.add("active");
        labelattachment.classList.remove("active");
        labelemailcontent.classList.add("active");
    };

    const attachment = function () {
        labelrecipient.classList.remove("active");
        labelsubject.classList.remove("active");
        labelmessage.classList.remove("active");
        labelheader.classList.remove("active");
        labelcontent.classList.remove("active");
        labelsubheader.classList.remove("active");
        labelcontent2.classList.remove("active");
        labelimage.classList.remove("active");
        labelsubheader2.classList.remove("active");
        labelcontent3.classList.remove("active");
        labelimage2.classList.remove("active");
        labelfooter.classList.remove("active");
        labelattachment.classList.add("active");
        labelemailcontent.classList.remove("active");
    };

    inputrecipient.addEventListener("click", recipient);
    inputsubject.addEventListener("click", subject);
    inputmessage.addEventListener("click", message);
    inputheader.addEventListener("click", header);
    inputcontent.addEventListener("click", content);
    inputsubheader.addEventListener("click", subheader);
    inputcontent2.addEventListener("click", content2);
    inputimage.addEventListener("click", image);
    inputsubheader2.addEventListener("click", subheader2);
    inputcontent3.addEventListener("click", content3);
    inputimage2.addEventListener("click", image2);
    inputfooter.addEventListener("click", footer);
    inputattachment.addEventListener("click", attachment);

// get file name
let fileInput = document.getElementById('attachment');
let span = document.getElementById('mailattachment');
let span2 = document.getElementById('mailattachment2');
// Fires on file upload
fileInput.addEventListener('change', function(event){

    let fileName = fileInput.files[0].name;
    
    // Update file name in span
    span.innerText = fileName + ' is the selected file.';
    span2.innerText = fileName + ' is the selected file.';
});

// img prev
let imageprev = document.getElementById('image');
let imageprev2 = document.getElementById('image2');
let img = document.getElementById('imagepreview');
let img2 = document.getElementById('imagepreview2');

imageprev.addEventListener('change', function(){
  const [file] = imageprev.files
  if (file) {
    img.src = URL.createObjectURL(file)
  }
});

imageprev2.addEventListener('change', function(){
  const [file] = imageprev2.files
  if (file) {
    img2.src = URL.createObjectURL(file)
  }
});

//prev
const recipientprev = document.getElementById('mailrecipient');
const recipientprev2 = document.getElementById('mailrecipient2');
const subjectprev = document.getElementById('mailsubject');
const subjectprev2 = document.getElementById('mailsubject2');
const headerprev = document.getElementById('headerpreview');
const contentprev = document.getElementById('contentpreview');
const subheaderprev = document.getElementById('subheaderpreview');
const content2prev = document.getElementById('content2preview');
const subheader2prev = document.getElementById('subheader2preview');
const content3prev = document.getElementById('content3preview');
const footerprev = document.getElementById('footerpreview');
const messageprev = document.getElementById('mailmessage');

inputrecipient.addEventListener("input", inputrecipientval );
inputrecipient.addEventListener("propertychange", inputrecipientval );
inputsubject.addEventListener("input", inputsubjectval );
inputsubject.addEventListener("propertychange", inputsubjectval );
inputmessage.addEventListener("input", inputmessageval );
inputmessage.addEventListener("propertychange", inputmessageval );
inputheader.addEventListener("input", inputheaderval );
inputheader.addEventListener("propertychange", inputheaderval );
inputcontent.addEventListener("input", inputcontentval );
inputcontent.addEventListener("propertychange", inputcontentval );
inputsubheader.addEventListener("input", inputsubheaderval );
inputsubheader.addEventListener("propertychange", inputsubheaderval );
inputcontent2.addEventListener("input", inputcontent2val );
inputcontent2.addEventListener("propertychange", inputcontent2val );
inputsubheader2.addEventListener("input", inputsubheader2val );
inputsubheader2.addEventListener("propertychange", inputsubheader2val );
inputcontent3.addEventListener("input", inputcontent3val );
inputcontent3.addEventListener("propertychange", inputcontent3val );
inputfooter.addEventListener("input", inputfooterval );
inputfooter.addEventListener("propertychange", inputfooterval );

function inputsubjectval (e) {
  subjectprev.textContent = e.target.value;
  subjectprev2.textContent = e.target.value;
}

function inputrecipientval (e) {
  recipientprev.textContent = e.target.value;
  recipientprev2.textContent = e.target.value;
}

function inputmessageval (e) {
  messageprev.textContent = e.target.value;
}

function inputheaderval (e) {
  headerprev.textContent = e.target.value;
}

function inputcontentval (e) {
  contentprev.textContent = e.target.value;
}

function inputsubheaderval (e) {
  subheaderprev.textContent = e.target.value;
}

function inputcontent2val (e) {
  content2prev.textContent = e.target.value;
}

function inputsubheader2val (e) {
  subheader2prev.textContent = e.target.value;
}

function inputcontent3val (e) {
  content3prev.textContent = e.target.value;
}

function inputfooterval (e) {
  footerprev.textContent = e.target.value;
}
</script>
</html>