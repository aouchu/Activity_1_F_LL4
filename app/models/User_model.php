<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {
	
    public function CheckDupEmail($email) {
        return $this->db->table('user')->where('email',$email)->get();
    }

    public function CheckDupUsername($username) {
        return $this->db->table('user')->where('username',$username)->get();
    }

    public function GetUser($id){
        return $this->db->table('user')->where('id',$id)->get();
    }

    public function LoginUser($username){
        return $this->db->table('user')->where('username',$username)->get();
    }

    public function RegUser($name, $username, $email, $password, $code){
        $bind = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'code' => $code,
            'status' => 'INACTIVE',
        ];
        return $this->db->table('user')->insert($bind);
    }

    public function Verified($email) {
        return $this->db->table('user')->where('email', $email)->update(['status'=>'ACTIVE']);
    }

    public function Verifying($email) {
        return $this->db->table('user')->where('email', $email)->get();
    }

    public function NewCode($email, $code) {
        return $this->db->table('user')->where('email', $email)->update(['code' => $code]);
    }
}
?>
