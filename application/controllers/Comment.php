<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('Form_validation');
        $this->load->helper('form');
        $this->load->model('Post_comment');

        $this->optional_session_auto(1);
    }

    public function index() {
        show_404();
    }

    public function json($post_id) {
        $comments = $this->Post_comment->findByPostId($post_id);
        echo json_encode($comments);
    }

    function add() {

        $this->form_validation->set_rules('post_id', 'post_id', 'required');
        $this->form_validation->set_rules('comment', 'comment_body', 'required|trim|htmlspecialchars');
        if ($this->form_validation->run() == FALSE) {
            
        } else {

            $save = array(
                'parent_id' => $this->input->post('parent_id'),
                'comment' => $this->input->post('comment'),
                'post_id' => $this->input->post('post_id'),
                'user_id' => $this->session->userdata('id')
            );

            if ($save['parent_id'] == 0 || $save['parent_id'] == "") {
                $save['parent_id'] = NULL;
            }

            $this->Post_comment->insert($save);
        }
    }

}
