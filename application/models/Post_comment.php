<?php

Class Post_comment extends MY_Model {

    public $table = 'post_comments';
    public $table_id = 'post_comment_id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // to insert comments

    function findByPostId($post_id) {

        $this->db->select('post_comment_id as id, parent_id as parent, '
                . 'pc.created_at as modified, pc.created_at as created, comment as content, '
                . 'u.user_id as creator, u.name as fullname, '
                . 'IF(u.avatar = "", CONCAT("/assets/img/logo.png",""), '
                . 'IF(u.avatar != "", CONCAT("' . base_url() . 'uploads/user/",avatar), u.avatar ))'
                . ' as profile_picture_url');
        $this->db->from($this->table . ' pc');
        $this->db->join('users as u', 'u.user_id = pc.user_id');
        $this->db->where('post_id = ', $post_id);

        $query = $this->db->get();
        return $query->result();
    }

}
