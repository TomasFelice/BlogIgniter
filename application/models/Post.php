<?php

class Post extends MY_Model {
    public $table = "posts";
    public $table_id = "post_id";

    public function get_pagination($offset = 0, $posted = 'si', $order = 'desc', $limit = PAGE_SIZE) {
        $this->db->select();
        $this->db->from($this->table . ' as p');
        $this->db->join('categories as c', 'p.category_id = c.category_id');
        $this->db->where("p.posted", $posted);
        $this->db->order_by("p.created_at", $order);
        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        return $query->result();
    }
}