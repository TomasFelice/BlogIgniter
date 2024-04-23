<?php

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('admin/test');
    }

    public function postList() {
        $this->load->view('admin/postList');
    }
}