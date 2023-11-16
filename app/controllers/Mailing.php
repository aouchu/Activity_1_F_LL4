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
        $username = $_POST['username_log'];
        $password = $_POST['password_log'];
        $result = $this->users->LoginUser($username);

        if($result) {
            $hashedpass = $result['password'];
            if(password_verify($password,$hashedpass))
            {
                $userdata = array(
                    'id' => $result['id'],
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
        } else {
            $this->session->set_flashdata('msg','No users exist with that username.');
            redirect(site_url().'/');
        }
    }

    public function signup() {

        $this->form_validation
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
        else
        {
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
                $result = $this->users->RegUser($username, $email, $password);
                if ($result) {
                    $this->session->set_flashdata('msg','You have registered sucessfully.');
                    redirect(site_url().'/');
                }else {
                    $this->session->set_flashdata('msg','Something went wrong.');
                    redirect(site_url().'/');
                }
            }
        }
    }

    public function send() {
        $this->form_validation
		->name('recipient')
			->required()
			->valid_email()
        ->name('subject')
			->required()
            ->min_length(10);

        if ($this->form_validation->run() == FALSE)
        {
            
        }
        else {

        }
    }

}
?>
