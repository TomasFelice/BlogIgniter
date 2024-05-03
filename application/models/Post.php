<?php

class Post extends MY_Model {
    public $table = "posts";
    public $table_id = "post_id";

    public function get_pagination($offset = 0, $posted = 'si', $order = 'desc', $limit = PAGE_SIZE, $c_url_clean = null) {
        $this->db->select('p.*, c.url_clean c_url_clean, c.name category');
        $this->db->from($this->table . ' as p');
        $this->db->join('categories as c', 'p.category_id = c.category_id');
        $this->db->where("p.posted", $posted);
        if(isset($c_url_clean)) {
            $this->db->where("c.url_clean", $c_url_clean);
        }
        $this->db->order_by("p.created_at", $order);
        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        return $query->result();
    }

    public function getByUrlClean(string $url_clean, string $posted = 'si') {
        $this->db->select('p.*, c.url_clean c_url_clean, c.name category');
        $this->db->from($this->table . ' as p');
        $this->db->join('categories as c', 'p.category_id = c.category_id');
        $this->db->where("p.posted", $posted);
        $this->db->where("p.url_clean", $url_clean);

        $query = $this->db->get();

        return $query->row();
    }

    public function countByUrlClean($c_url_clean, $posted = 'si') {
        $this->db->select('COUNT(p.post_id) as cantidad');
        $this->db->from($this->table . ' as p');
        $this->db->join('categories as c', 'p.category_id = c.category_id');
        $this->db->where("p.posted", $posted);
        $this->db->where("c.url_clean", $c_url_clean);

        $query = $this->db->get();

		return $query->row()->cantidad;
    }

    public function getBySearch($searchs, $category_id = null, $posted = 'si', $order = 'desc') {
        $this->db->select('p.*, c.url_clean c_url_clean, c.name category');
        $this->db->from($this->table . ' as p');
        $this->db->join('categories as c', 'p.category_id = c.category_id');
        $this->db->where("p.posted", $posted);

        foreach ($search as $key => $search) {
            $this->db->like("p.title", $search);
        }

        if (!is_null($category_id) && !empty($category_id)) {
            $this->db->where("c.category_id", $category_id);
        }

        $this->db->order_by("p.created_at", $order);
        
        $query = $this->db->get();

        return $query->result();
    }
}