<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Mailing extends Controller {

    public function __construct() {
        parent:: __construct();
        $this->call->model('User_Model', 'users');
    }
	
    public function mail() {
        return $this->call->view('mail');
    }
    public function index() {
        return $this->call->view('access');
    }

    public function signout() {
        return $this->call->view('signout');
    }

    public function signin() {

        $this->form_validation
		->name('username_log')
			->required()
		->name('password_log')
			->required();
            
        if ($this->form_validation->run() == FALSE)
        {
            $data = [
                'errors' => $this->form_validation->errors(),
            ];
            $this->call->view('access', $data);
        }
        else {

            $username = $_POST['username_log'];
            $password = $_POST['password_log'];
            $result = $this->users->LoginUser($username);

            if($result) {
                if($result['status'] == 'INACTIVE') {
                    $this->session->set_flashdata('msg','Please verify your email before login.');
                    redirect(site_url().'/');
                } else {
                    $hashedpass = $result['password'];
                    if(password_verify($password,$hashedpass))
                    {
                        $userdata = array(
                            'id' => $result['id'],
                            'name' => $result['name'],
                            'username'  => $result['username'],
                            'email'     => $result['email'],
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($userdata);
                        redirect(site_url().'/mail');
                    }
                    else {
                        $this->session->set_flashdata('msg','wrong password.');
                        redirect(site_url().'/');
                    }

                }
            } else {
                $this->session->set_flashdata('msg','No users exist with that username.');
                redirect(site_url().'/');
            }
        }
    }

    public function signup() {

        $this->form_validation
        ->name('name')
            ->required()
		->name('username')
			->required()
			->min_length(6)
			->max_length(30)
        ->name('email')
			->required()
            ->valid_email()
		->name('password')
			->required()
            ->custom_pattern("^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$", 'The password must contain a minimum of eight characters, at least one letter, one number and one special character:')
		->name('confirmpassword')
			->matches('password')
			->required();

        if ($this->form_validation->run() == FALSE)
        {
            $data = [
                'errors' => $this->form_validation->errors(),
            ];
            $this->call->view('access', $data);
        }
        else {
            $name = $_POST['name'];   
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $res_email = $this->users->CheckDupEmail($email);
            $res_name = $this->users->CheckDupUsername($username);
            
            if($res_email) {
                $this->session->set_flashdata('msg','A user exists with that email. Please change your email.');
                redirect(site_url().'/');
            } else if ($res_name) {
                $this->session->set_flashdata('msg','A user exists with that username. Please change your username.');
                redirect(site_url().'/');
            } else {

                $random = substr(str_shuffle(str_repeat("0123456789", 6)), 0, 6);
                $code = sha1($random);
                $result = $this->users->RegUser($name ,$username, $email, $password, $code);
                if ($result) {
                    //sending code
                    $this->email->sender('auto_mailing@gmail.com', 'Sample Mailer');
                    $this->email->recipient($email);
                    $this->email->subject('Verification Code');
                    $this->email->email_content($random);
                    $test = $this->email->send();

                    $user = [
                        'email' => $get['email'],
                        'status' => $get['status'],
                    ];
                    $this->session->set_userdata($user);
                    $this->session->set_flashdata('msg','A code has been sent to your email. Please verify your email to login.');
                    redirect(site_url().'/sent');
                }else {
                    $this->session->set_flashdata('msg','Something went wrong.');
                    redirect(site_url().'/');
                }
            }
        }
    }

    public function verify() {
        if (isset($_POST['verifying'])) {
            $get = $this->users->Verifying($_POST['email']);
            if ($get && $get['status'] == 'INACTIVE') {
                $random = substr(str_shuffle(str_repeat("0123456789", 6)), 0, 6);
                $code = sha1($random);
                $new = $this->users->NewCode($get['email'] , $code);
                if($new) {
                    $this->email->sender('auto_mailing@gmail.com', 'Sample Mailer');
                    $this->email->recipient($get['email']);
                    $this->email->subject('Verification Code');
                    $this->email->email_content($random);
                    $test = $this->email->send();
                    if($test) {
                        $user = [
                            'email' => $get['email'],
                            'status' => $get['status'],
                        ];
                        $this->session->set_userdata($user);
                        redirect(site_url()."/sent");
                    } else {
                        $this->session->set_flashdata('msg', 'Something went wrong, Please try again later.');
                        redirect(site_url()."/");
                    }
                } else {
                    $this->session->set_flashdata('msg', 'Something went wrong, Please try again later.');
                    redirect(site_url()."/");
                }
            } else if($get['status'] == 'ACTIVE') {
                $this->session->set_flashdata('msg', 'You are already verified.');
                redirect(site_url()."/");
            } else {
                $this->session->set_flashdata('msg', 'User didn\'t exists.');
                redirect(site_url()."/sent");
            }

        } else if(isset($_POST['resend'])) {
            if(isset($_SESSION['email'])) {
                $random = substr(str_shuffle(str_repeat("0123456789", 6)), 0, 6);
                $code = sha1($random);
                $new = $this->users->NewCode($_SESSION['email'], $code);
                if($new) {
                    $this->email->sender('auto_mailing@gmail.com', 'Sample Mailer');
                    $this->email->recipient($_SESSION['email']);
                    $this->email->subject('Verification Code');
                    $this->email->email_content($random);
                    $test = $this->email->send();
                    if($test) {
                        $this->session->set_flashdata('msg', 'A new code has been sent to your email.');
                        redirect(site_url()."/sent");
                    } else {
                        $this->session->set_flashdata('msg', 'Something went wrong, Please try again later.');
                        redirect(site_url()."/");
                    }
                } else {
                    $this->session->set_flashdata('msg', 'Something went wrong, Please try again later.');
                    redirect(site_url()."/sent");
                }
            } else {
                $this->session->set_flashdata('msg', 'Please input your email.');
                redirect(site_url()."/sent");
            }
        } else {
            if(isset($_SESSION['email'])) {
                $get = $this->users->Verifying($_SESSION['email']); 
                if(sha1($_POST['code']) == $get['code']) {
                    $verified = $this->users->Verified($_SESSION['email']);
                    if($verified) {
                        $this->session->set_flashdata('msg', 'Verified successfully. You are now eligible for login.');
                        redirect(site_url()."/");
                    } else {
                        $this->session->set_flashdata('msg', 'Couldn\'t be verified at this moment, Please try again later.');
                        redirect(site_url()."/sent");
                    }
                } else {
                    $this->session->set_flashdata('msg', 'Wrong verification code.');
                    redirect(site_url()."/sent");
                }
            } else {
                $this->session->set_flashdata('msg', 'Please input your email.');
                redirect(site_url()."/sent");
            }
        }
    }

    public function send() {
        ini_set('SMTP','mailpit');
        ini_set('smtp_port',1025);

        $this->form_validation
		->name('recipient')
			->required()
			->valid_email()
        ->name('subject')
			->required()
            ->min_length(10);
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg',$this->form_validation->errors());
            redirect(site_url().'/mail');
        }
        else {
            // $this->session->userdata('name');
            if(!$_FILES['image']['name'] && !$_FILES['image2']['name'] && !$_FILES['attachment']['name']) {

                $this->email->sender($this->session->userdata('email'), $this->session->userdata('name'));
                $this->email->recipient($_POST['recipient']);

                $this->email->subject($_POST['subject']);
                $this->email->email_content($_POST['message']);

                $test = $this->email->send();

                if($test) {
                    $this->session->set_flashdata('msg', 'email was sent successfully.');
                    redirect(site_url().'/mail');
                } else {
                    $this->session->set_flashdata('msg', 'something went wrong.');
                    redirect(site_url().'/mail');
                }

            } else if((!$_FILES['image']['name'] || !$_FILES['image2']['name']) && $_FILES['attachment']['name']) {

                $this->call->library('upload', $_FILES['attachment']);
                $this->upload
                    ->set_dir('public')
                    ->is_image();
                if($this->upload->do_upload()) {

                    $this->email->sender($this->session->userdata('email'), $this->session->userdata('name'));
                    $this->email->recipient($_POST['recipient']);

                    $this->email->subject($_POST['subject']);
                    $this->email->email_content($_POST['message']);
                    $this->email->attachment('public/'.$this->upload->get_filename());

                    $test = $this->email->send();
                    
                    if($test) {
                        $this->session->set_flashdata('msg', 'email was sent successfully.');
                        redirect(site_url().'/mail');
                    } else {
                        $this->session->set_flashdata('msg', 'something went wrong.');
                        redirect(site_url().'/mail');
                    }

                } else {
                    $this->session->set_flashdata('msg', $this->upload->get_errors());
                    redirect(site_url().'/mail');
                }

            } else if($_FILES['image']['name'] && $_FILES['image2']['name'] && !$_FILES['attachment']['name']) {

                $this->call->library('upload', $_FILES['image']);
                $this->upload
                    ->set_dir('public')
                    ->is_image();
                $test1 = $this->upload->do_upload();
                $img = $this->upload->get_filename();

                $test2 = move_uploaded_file($_FILES['image2']['tmp_name'],"C:\laragon\www\Activity_1_F_LL4\public\\".$_FILES['image2']['name']);
                $name = $_FILES['image2']['name'];
                $img2 = 'public/'.$name;

                if($test1 && $test2) {

                    $this->email->sender($this->session->userdata('email'), $this->session->userdata('name'));
                    $this->email->recipient($_POST['recipient']);

                    $this->email->subject($_POST['subject']);
                    $this->email->email_content('<center>
                    <div style="background-color: rgb(135,96,115);color:white;margin-bottom:1dvh;padding:.5dvh;">
                    <h2 style="font-family: Courier, monospace;;word-break: break-word;">&#9668; &#9669; &#9668; &#10012; '.$_POST['header'].' &#10012; &#9658; &#9659; &#9658;</h2>
                    </div>
                    <p style="font-family: Courier, monospace;;word-break: break-word;">'.$_POST['content'].'</p>
                    <div style="background-color: rgb(135,96,115);color:white;margin-bottom:1dvh;padding:.5dvh;">
                    <h3 style="font-family: Courier, monospace;;word-break: break-word;">'.$_POST['subheader'].'</h3>
                    </div>
                    <p style="font-family: Courier, monospace;;word-break: break-word;">'.$_POST['content2'].'</p></br>
                    <img src="http://activity_1_f_ll4.test/public/'.$img.'" width="50%" height="50%">
                    <div style="background-color: rgb(135,96,115);color:white;margin-bottom:1dvh;padding:.5dvh;">
                    <h3 style="font-family: Courier, monospace;;word-break: break-word;">'.$_POST['subheader2'].'</h3>
                    </div>
                    <p style="font-family: Courier, monospace;word-break: break-word;">'.$_POST['content3'].'</p></br>
                    <img src="http://activity_1_f_ll4.test/'.$img2.'" width="50%" height="50%">
                    <h6 style="font-family: Courier, monospace;width: 100%;background-color:rgb(135,96,115);color: white;text-align: center;padding:1rem;word-break: break-word;">'.$_POST['footer'].'</h6>
                    </center>', 'html');

                    $test = $this->email->send();
                    
                    if($test) {
                        $this->session->set_flashdata('msg', 'email was sent successfully.');
                        redirect(site_url().'/mail');
                    } else {
                        $this->session->set_flashdata('msg', 'something went wrong.');
                        redirect(site_url().'/mail');
                    }

                } else {
                    $this->session->set_flashdata('msg', $this->upload->get_errors());
                    redirect(site_url().'/mail');
                }
            } else if($_FILES['image']['name'] && $_FILES['image2']['name'] && $_FILES['attachment']['name']) {
                $this->call->library('upload', $_FILES['image']);
                $this->upload
                    ->set_dir('public')
                    ->is_image();
                $test1 = $this->upload->do_upload();
                $img = $this->upload->get_filename();

                $test2 = move_uploaded_file($_FILES['image2']['tmp_name'],"C:\laragon\www\Activity_1_F_LL4\public\\".$_FILES['image2']['name']);
                $name = $_FILES['image2']['name'];
                $img2 = 'public/'.$name;

                $test3 = move_uploaded_file($_FILES['attachment']['tmp_name'],"C:\laragon\www\Activity_1_F_LL4\public\\".$_FILES['attachment']['name']);
                $name2 = $_FILES['attachment']['name'];
                $img3 = 'public/'.$name2;

                if($test1 && $test2 && $test3) {

                    $this->email->sender($this->session->userdata('email'), $this->session->userdata('name'));
                    $this->email->recipient($_POST['recipient']);

                    $this->email->subject($_POST['subject']);
                    $this->email->email_content('<center>
                    <div style="background-color: rgb(135,96,115);color:white;margin-bottom:1dvh;padding:.5dvh;">
                    <h2 style="font-family: Courier, monospace;;word-break: break-word;">&#9668; &#9669; &#9668; &#10012; '.$_POST['header'].' &#10012; &#9658; &#9659; &#9658;</h2>
                    </div>
                    <p style="font-family: Courier, monospace;;word-break: break-word;">'.$_POST['content'].'</p>
                    <div style="background-color: rgb(135,96,115);color:white;margin-bottom:1dvh;padding:.5dvh;">
                    <h3 style="font-family: Courier, monospace;;word-break: break-word;">'.$_POST['subheader'].'</h3>
                    </div>
                    <p style="font-family: Courier, monospace;;word-break: break-word;">'.$_POST['content2'].'</p></br>
                    <img src="http://activity_1_f_ll4.test/public/'.$img.'" width="50%" height="50%">
                    <div style="background-color: rgb(135,96,115);color:white;margin-bottom:1dvh;padding:.5dvh;">
                    <h3 style="font-family: Courier, monospace;;word-break: break-word;">'.$_POST['subheader2'].'</h3>
                    </div>
                    <p style="font-family: Courier, monospace;word-break: break-word;">'.$_POST['content3'].'</p></br>
                    <img src="http://activity_1_f_ll4.test/'.$img2.'" width="50%" height="50%">
                    <h6 style="font-family: Courier, monospace;width: 100%;background-color:rgb(135,96,115);color: white;text-align: center;padding:1rem;word-break: break-word;">'.$_POST['footer'].'</h6>
                    </center>', 'html');

                    $this->email->attachment('public/'.$name2);
                    $test = $this->email->send();
                    
                    if($test) {
                        $this->session->set_flashdata('msg', 'email was sent successfully.');
                        redirect(site_url().'/mail');
                    } else {
                        $this->session->set_flashdata('msg', 'something went wrong.');
                        redirect(site_url().'/mail');
                    }

                } else {
                    $this->session->set_flashdata('msg', $this->upload->get_errors());
                    redirect(site_url().'/mail');
                }
            } else {
                $this->session->set_flashdata('msg', 'if you\'re using email with design, please make sure you uploaded or filled the images under the email content, you cannot leave the other one empty.');
                redirect(site_url().'/mail');
            }
        }
    }

}
?>
