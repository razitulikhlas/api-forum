<?php

class Questions_model extends CI_Model{

    public function get($id = null){
        if($id === null){
            $query = "SELECT id_pertanyaan,tbl_user.id as id_user,tbl_user.name AS 'name_user',tbl_category.category AS 'category',
            tbl_user.image_profile AS 'url_image',tbl_pertanyaan.like,tbl_pertanyaan.comment,
            tbl_pertanyaan.pertanyaan,tbl_pertanyaan.is_delete as 'is_delete',tbl_pertanyaan.created_at
            FROM tbl_pertanyaan,tbl_category,tbl_user
            WHERE
            tbl_pertanyaan.id_user = tbl_user.id &&
            tbl_category.id_category = tbl_pertanyaan.id_category &&
            tbl_pertanyaan.is_delete = 0 
            order by tbl_pertanyaan.id_pertanyaan DESC";
            
        }else{
            $query = "SELECT id_pertanyaan,tbl_user.id as id_user,tbl_user.name AS 'name_user',tbl_category.category AS 'category',
            tbl_user.image_profile AS 'url_image',
            tbl_pertanyaan.pertanyaan,tbl_pertanyaan.is_delete as 'is_delete',tbl_pertanyaan.created_at
            FROM tbl_pertanyaan,tbl_category,tbl_user
            WHERE
            tbl_pertanyaan.id_user = tbl_user.id &&
            tbl_category.id_category = tbl_pertanyaan.id_category &&
            tbl_pertanyaan.is_delete = 0 
            order by tbl_pertanyaan.id_pertanyaan DESC";
        }
        return $this->db->query($query)->result_array();
    }

    public function insert($data){
        $this->db->insert('tbl_pertanyaan',$data);
        return $this->db->affected_rows();
    }

    public function update($data,$id_ask){
        $this->db->update('tbl_pertanyaan',$data,['id_pertanyaan' => $id_ask]);
        return $this->db->affected_rows();
    }

    public function getQuestion($id_user){
        $query = "SELECT id_pertanyaan,tbl_user.id as id_user,tbl_user.name AS 'name_user',tbl_category.category AS 'category',
        tbl_user.image_profile AS 'url_image',
        tbl_pertanyaan.pertanyaan,tbl_pertanyaan.is_delete as 'is_delete',tbl_pertanyaan.created_at
        FROM tbl_pertanyaan,tbl_category,tbl_user
        WHERE
        tbl_pertanyaan.id_user = tbl_user.id &&
        tbl_category.id_category = tbl_pertanyaan.id_category &&
        tbl_pertanyaan.is_delete = 0 &&
        tbl_pertanyaan.id_user = $id_user";
        return $this->db->query($query)->result_array();
    }
}