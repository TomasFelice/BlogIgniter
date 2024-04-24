<?php

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library("parser");
        $this->load->library("form_validation");

		$this->load->helper("url");
        $this->load->helper('form');

        $this->load->helper('post_helper');

        $this->load->database();

        $this->load->model("Post");
    }

    public function index() {
        $this->load->view("admin/test");
    }

    /*     * ***
     * CRUD PARA LOS POST
     */

    public function post_list() {
        $view["body"] = $this->load->view("admin/post/list", null, true);
        $view["title"] = "Posts";
        
        $this->parser->parse("admin/template/body", $view);
    }

    public function post_save() {
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            $this->form_validation->set_rules('title', 'Titulo', 'required|min_length[10]|max_length[65]');
            $this->form_validation->set_rules('content', 'Contenido', 'required|min_length[10]');
            $this->form_validation->set_rules('description', 'Descripcion', 'max_length[100]');
            $this->form_validation->set_rules('posted', 'Publicado', 'required');

            if($this->form_validation->run()) {
                // Form valido
                $save = [
                    'content' => $this->input->post('content'),
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'posted' => $this->input->post('posted')
                ];

                $post_id = $this->Post->insert($save);

                $this->upload_file($post_id, $save['title']);
            }
        }

        $data["data_posted"] = posted();
        $view["body"] = $this->load->view("admin/post/save", $data, true);
        $view["title"] = "Crear Post";
        
        $this->parser->parse("admin/template/body", $view);
    }

    private function upload_file($post_id, $title) {
        $field_image                    = 'image';
        $title                          = clean_name($title);

        // Configuracion de carga
        $config['upload_path']          = './uploads/';
        $config['file_name']            = $title;
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5000;
        $config['overwrite']            = true;

        // Cargo la libreria con la config seteada
        $this->load->library('upload', $config);

        if($this->upload->do_upload($field_image)) {
            // Imagen cargada

            // Nos da info del archivo que se acaba de cargar
            $data = $this->upload->data();

            $save = [
                'image' => $title . $data['file_ext']
            ];

            $this->Post->update($post_id, $save);
            $this->resize_image($data['full_path'], $title . $data['file_ext']);
        }
    }

    function resize_image($path_image, $image_name) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path_image;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 500;
        $config['height']       = 500;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

}
