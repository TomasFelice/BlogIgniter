<?php

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library("parser");
        $this->load->library("Form_validation");

		$this->load->helper("url");
        $this->load->helper('form');
        $this->load->helper('text');

        $this->load->helper('post_helper');
        $this->load->helper('date_helper');

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
        $data["posts"] = $this->Post->findAll();

        $view["body"] = $this->load->view("admin/post/list", $data, true);
        $view["title"] = "Posts";
        
        $this->parser->parse("admin/template/body", $view);
    }

    public function post_save($post_id = null) {
        if(is_null($post_id)) {
            // Crear post
            $data['title'] = "";
            $data['content'] = "";
            $data['description'] = "";
            $data['posted'] = "";
            $data['url_clean'] = "";
            $data['image'] = "";
            $view["title"] = "Crear Post";
        } else {
            // Editar post
            $post = $this->Post->find($post_id);
            $data['title'] = $post->title;
            $data['content'] = $post->content;
            $data['description'] = $post->description;
            $data['posted'] = $post->posted;
            $data['url_clean'] = $post->url_clean;
            $data['image'] = $post->image;
            $view["title"] = "Editar Post";
        }


        // Si es un post
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            $this->form_validation->set_rules('title', 'Titulo', 'required|min_length[10]|max_length[65]');
            $this->form_validation->set_rules('content', 'Contenido', 'required|min_length[10]');
            $this->form_validation->set_rules('description', 'Descripcion', 'max_length[100]');
            $this->form_validation->set_rules('posted', 'Publicado', 'required');

            $data['title'] = $this->input->post('title');
            $data['content'] = $this->input->post('content');
            $data['description'] = $this->input->post('description');
            $data['posted'] = $this->input->post('posted');
            $data['url_clean'] = $this->input->post('url_clean');

            if($this->form_validation->run()) {
                $url_clean = $this->input->post('url_clean');

                if (empty($url_clean)) {
                    $url_clean = clean_name($this->input->post('title'));
                }

                // Form valido
                $save = [
                    'content' => $this->input->post('content'),
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'posted' => $this->input->post('posted'),
                    'url_clean' => $url_clean
                ];

                if(is_null($post_id)) {
                    $post_id = $this->Post->insert($save);
                } else {
                    $this->Post->update($post_id ,$save);
                }

                $this->upload($post_id, $save['title']);
            }
        }

        $data["data_posted"] = posted();
        $view["body"] = $this->load->view("admin/post/save", $data, true);
        
        $this->parser->parse("admin/template/body", $view);
    }

    public function post_delete($post_id = null) {
        if (is_null($post_id)) {
            echo false;
        }
        
        $this->Post->delete($post_id);
        echo true;
    }

    public function upload($post_id = null, $title = null) {
        $field_image                    = 'upload';

        if(!is_null($title)) {
            $title                  = clean_name($title);
            $config['file_name']    = $title;
        }

        // Configuracion de carga
        $config['upload_path']          = 'uploads/post';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5000;
        $config['overwrite']            = true;

        // Cargo la libreria con la config seteada
        $this->load->library('upload', $config);

        if($this->upload->do_upload($field_image)) {
            // Imagen cargada

            // Nos da info del archivo que se acaba de cargar
            $data = $this->upload->data();

            if (!is_null($title) && !is_null($post_id)) {
                $save = [
                    'image' => $title . $data['file_ext']
                ];  
    
                $this->Post->update($post_id, $save);
            } else {
                $title = $data['file_name'];
                echo json_encode([
                    'fileName'  => $title,
                    'uploaded'  => 1,
                    'url'       => '/' . PROJECT_FOLDER . '/uploads/post/' . $title
                ]);
            }

            $this->resize_image($data['full_path']);
        }
    }

    function resize_image($path_image) {
        $config['image_library']    = 'gd2';
        $config['source_image']     = $path_image;
        $config['maintain_ratio']   = true;
        $config['width']            = 500;
        $config['height']           = 500;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

}
