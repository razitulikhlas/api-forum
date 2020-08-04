<?php

class Auth_model extends CI_Model{

    public function checkemail($email)
    {
        $this->db->get_where("tbl_user", ["email" => $email])->row();
        return $this->db->affected_rows();
    }
    
    public function checknohp($nohp)
    {
        $this->db->get_where("tbl_user", ["nohp" => $nohp])->row();
        return $this->db->affected_rows();
    }

    public function login($username, $password)
    {
        // $this->db->get_where("tbl_user", ["email" => $username])->row();
        $user = $this->db->get_where("tbl_user", ["email" => $username])->row();;
        if ($user) {
            if (password_verify($password, $user->password)) {
                $user->password = "";
                return $user;
            } else {
                return 20;
            }
        } else {
            return 23;
        }
    }


    public function getDokter($id = null){
        if($id === null){
            return $this->db->get('tbl_dokter')->result_array();
        }else{
            return $this->db->get_where('tbl_dokter',['kd_dokter' => $id])->result_array();
        }
        
    }

    public function deleteDokter($kd){
        $this->db->delete('tbl_dokter',['kd_dokter' => $kd]);
        return $this->db->affected_rows();
    }

    public function register($data){
        $this->db->insert('tbl_user',$data);
        return $this->db->affected_rows();
    }

    public function updateFCM($data,$email){
        $this->db->update('tbl_user',$data,['email' => $email]);
        return $this->db->affected_rows();
    }
}