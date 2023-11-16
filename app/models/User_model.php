<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {
	
    public function CheckDupEmail($email) {
        $mail = $email;
        $data = $this->db->table('user')->where('email',$mail)->get();
        return $data;
    }

    public function CheckDupUsername($username) {
        $name = $username;
        $data = $this->db->table('user')->where('username',$name)->get();
        return $data;
    }

    public function GetUser($id){
        $ID = $id;
        $data = $this->db->table('user')->where('id',$ID)->get();
		return $data;
    }

    public function LoginUser($username){
        $name = $username;
        $data = $this->db->table('user')->where('username',$name)->get();
		return $data;
    }

    public function RegUser($username, $email, $password){
        $bind = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ];
        return $this->db->table('user')->insert($bind);
    }
}
?>
