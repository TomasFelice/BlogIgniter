<?php

class Category extends MY_Model {
    public $table = "categories";
    public $table_id = "category_id";

    public function getByUrlClean(string $url_clean) {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where("url_clean", $url_clean);

        $query = $this->db->get();

        return $query->row();
    }
}