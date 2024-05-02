<?php

class Blog extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index ($num_page = 1) {
        $num_page--;
        $num_post = $this->Post->count();
        $last_page = ceil($num_page / PAGE_SIZE);

        if ($num_page < 0) {
            $num_page = 0;
        } elseif ($num_page > $last_page) {
            $num_page = 0;
        }

        $offset = $num_page * PAGE_SIZE;

        $data['last_page'] = $last_page;
        $data['num_page'] = $num_page;
        $data['posts'] = $this->Post->get_pagination($offset);
        $data['last_page'] = $last_page;

        $view['body'] = $this->load->view("blog/index", $data, TRUE);
        
        $this->parser->parse("blog/template/body", $view);
    }
}
