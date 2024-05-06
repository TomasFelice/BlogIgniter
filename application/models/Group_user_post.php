<?php

class Group_user_post extends MY_Model {
    public $table = "group_user_posts";
    public $table_id = "group_user_post_id";

    public function getByUserId(string $user_id) {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where("user_id", $user_id);

        $query = $this->db->get();

        return $query->result();
    }

    public function deleteByPostIdAndUserId($post_id, $user_id) {
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete($this->table);
    }
}