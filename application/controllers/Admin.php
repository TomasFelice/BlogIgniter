<?php

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library("Form_validation");
        $this->load->library('Grocery_CRUD');

        $this->load->helper('form');

        $this->init_session_auto(9);
    }

    public function index() {
        redirect('admin/post_list');
    }

    public function user_crud () {
        $crud = new grocery_CRUD();
 
        $crud->set_theme('datatables');
        $crud->set_table('users');
        $crud->set_subject('Usuario');

        // Solo admins
        $crud->where('auth_level', 9);

        $state = $crud->getState();
        
        $crud->columns('username','email', 'avatar');

        if ($state == 'edit' || $state == 'update' || $state == 'update_validation') {
            // Modo edición
            $crud->fields('auth_level', 'created_at', 'user_id', 'avatar');
        } else {
            // Modo inserción
            $crud->fields('auth_level', 'created_at', 'user_id', 'username', 'email', 'passwd', 'avatar');
            $crud->set_rules('email', 'Email', 'required|valid_email|is_unique[' . config_item('user_table') . '.email]');
            $crud->set_rules('username', 'Usuario', 'max_length[50]|is_unique[' . config_item('user_table') . '.username]|required');
            $crud->set_rules('passwd', 'Contraseña', 'min_length[8]|required|max_length[72]|callback_validate_password');
        }
        
        $crud->callback_before_insert([
            $this,'user_before_insert_callback'
        ]);
        $crud->callback_after_upload([
            $this,'user_after_upload_callback'
        ]);

        // Cambiamos la forma de mostrar los campos
        $crud->display_as('username', 'Usuario');
        $crud->display_as('passwd', 'Contraseña');

        // Ocultamos algunos campos
        $crud->field_type('auth_level', 'hidden');
        $crud->field_type('created_at', 'hidden');
        $crud->field_type('user_id', 'hidden');
        $crud->field_type('passwd', 'password');
        $crud->set_field_upload('avatar', 'uploads/user', 'png|jpg');

        // Para no volver a cargar JQuery
        $crud->unset_jquery();
        // Para no mostrar el botón de ver
        $crud->unset_read();
        // Para no mostrar el botón de clonar
        $crud->unset_clone();
 
        $output = $crud->render();

        $view['grocery_crud'] = json_encode($output);

        $view["title"] = "Usuario";
        
        $this->parser->parse("admin/template/body", $view);
    }

    /*     * ***
     * CRUD PARA LOS POST
     */

    public function post_list() {
        // $data["posts"] = $this->Post->findAll();

        // $view["body"] = $this->load->view("admin/post/list", $data, true);
        $crud = new grocery_CRUD();
 
        $crud->set_table('posts');
        $crud->set_subject('Post');
        $crud->columns('post_id','title', 'created_at', 'description', 'image', 'posted');

        $crud->set_rules('title', 'Titulo', 'required|min_length[10]|max_length[65]');
        $crud->set_rules('content', 'Contenido', 'required|min_length[10]');
        $crud->set_rules('description', 'Descripcion', 'max_length[100]');
        $crud->set_rules('posted', 'Publicado', 'required');
        $crud->set_rules('category_id', 'Categoría', 'required');

        // Para no volver a cargar JQuery
        $crud->unset_jquery();
        // Para no mostrar el botón de ver
        $crud->unset_read();
        // Para no mostrar el botón de clonar
        $crud->unset_clone();
        // Para no mostrar el botón de agregar
        $crud->unset_add();
        // Para no mostrar el botón de editar
        $crud->unset_edit();

        $crud->add_action('Editar', '', 'admin/post_save', 'edit-icon');
 
        $output = $crud->render();

        $view['grocery_crud'] = json_encode($output);

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
            $data['category_id'] = "";
            $view["title"] = "Crear Post";
        } else {
            // Editar post
            $post = $this->Post->find($post_id);

            if (!isset($post)) {
                show_404();
            }

            $data['title'] = $post->title;
            $data['content'] = $post->content;
            $data['description'] = $post->description;
            $data['posted'] = $post->posted;
            $data['url_clean'] = $post->url_clean;
            $data['image'] = $post->image;
            $data['category_id'] = $post->category_id;
            $view["title"] = "Editar Post";
        }

        // Obtenemos el listado de categorias para el select
        $data['categories'] = categories_to_form($this->Category->findAll());

        // Si es un post
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            $this->form_validation->set_rules('title', 'Titulo', 'required|min_length[10]|max_length[65]');
            $this->form_validation->set_rules('content', 'Contenido', 'required|min_length[10]');
            $this->form_validation->set_rules('description', 'Descripcion', 'max_length[100]');
            $this->form_validation->set_rules('posted', 'Publicado', 'required');
            $this->form_validation->set_rules('category_id', 'Categoría', 'required');

            $data['title'] = $this->input->post('title');
            $data['content'] = $this->input->post('content');
            $data['description'] = $this->input->post('description');
            $data['posted'] = $this->input->post('posted');
            $data['url_clean'] = $this->input->post('url_clean');
            $data['category_id'] = $this->input->post('category_id');

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
                    'url_clean' => $url_clean,
                    'category_id' => $this->input->post('category_id')
                ];

                if(is_null($post_id)) {
                    $post_id = $this->Post->insert($save);
                } else {
                    $this->Post->update($post_id ,$save);
                }

                $this->upload($post_id, $save['title']);
                
                redirect('admin/post_save/' . $post_id);
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

    /*     * ***
     * CRUD PARA LAS CATEGORIAS
     */

    public function category_list() {
        // $data["categories"] = $this->Category->findAll();

        // $view["body"] = $this->load->view("admin/category/list", $data, true);
        $crud = new grocery_CRUD();
 
        $crud->set_theme('datatables');
        $crud->set_table('categories');
        $crud->set_subject('Categoría');
        $crud->columns('category_id','name');

        $crud->callback_before_insert([
            $this,'category_iu_before_callback'
        ]);
        $crud->callback_before_update([
            $this,'category_iu_before_callback'
        ]);

        $crud->set_rules('name', 'Nombre', 'required|min_length[5]|max_length[100]');

        // Para no volver a cargar JQuery
        $crud->unset_jquery();
        // Para no mostrar el botón de ver
        $crud->unset_read();
        // Para no mostrar el botón de clonar
        $crud->unset_clone();
 
        $output = $crud->render();

        $view['grocery_crud'] = json_encode($output);
        $view["title"] = "Categories";
        
        $this->parser->parse("admin/template/body", $view);
    }

    public function category_save($category_id = null) {
        if(is_null($category_id)) {
            // Crear categoría
            $data['name'] = "";
            $data['url_clean'] = "";
        } else {
            // Editar categpría
            $category = $this->Category->find($category_id);
            $data['name'] = $category->name;
            $data['url_clean'] = $category->url_clean;
            $view["title"] = "Editar Categoría";
        }


        // Si es un post
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            $this->form_validation->set_rules('name', 'Nombre', 'required|min_length[5]|max_length[100]');

            $data['name'] = $this->input->post('name');
            $data['url_clean'] = $this->input->post('url_clean');

            if($this->form_validation->run()) {
                $url_clean = $this->input->post('url_clean');

                if (empty($url_clean)) {
                    $url_clean = clean_name($this->input->post('name'));
                }

                // Form valido
                $save = [
                    'name' => $this->input->post('name'),
                    'url_clean' => $url_clean
                ];

                if(is_null($category_id)) {
                    $category_id = $this->Category->insert($save);
                } else {
                    $this->Category->update($category_id ,$save);
                }
            }
        }

        $view["body"] = $this->load->view("admin/category/save", $data, true);
        
        $this->parser->parse("admin/template/body", $view);
    }

    public function category_delete($category_id = null) {
        if (is_null($category_id)) {
            echo false;
        }
        
        $this->Category->delete($category_id);
        echo true;
    }

    public function images_server() {
        $data['images'] = all_images();
        $this->load->view('admin/post/image', $data);
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
        } else if (!empty($_FILES[$image]['name'])) {
            // Error al cargar la imagen
            // set_flashdata sirve para guardar mensajes en la session
            $this->session->set_flashdata('text', $this->upload->display_errors());
            $this->session->set_flashdata('type', 'danger');
        }
    }

    private function resize_image($path_image) {
        $config['image_library']    = 'gd2';
        $config['source_image']     = $path_image;
        $config['maintain_ratio']   = true;
        $config['width']            = 500;
        $config['height']           = 500;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

    /*     * ***
     * CALLBACKS
     */

    public function category_iu_before_callback($post_array, $pk = null) {
        if ($post_array['url_clean']  == '') {
            $post_array['url_clean'] = clean_name($post_array['name']);
        }
        return $post_array;
    }

    public function user_before_insert_callback($post_array) {
        $post_array['passwd'] = $this->authentication->hash_passwd($post_array['passwd']);
        $post_array['user_id'] = $this->User->get_unused_id();
        $post_array['created_at'] = date('Y-m-d H:i:s');
        $post_array['auth_level'] = 9;

        return $post_array;
    }

    public function user_after_upload_callback($uploader_response, $field_info, $files_to_upload) {
        $this->load->library('Image_moo');
        //Is only one file uploaded so it ok to use it with $uploader_response[0].
        $file_uploaded = $field_info->upload_path . '/' . $uploader_response[0]->name;
        $this->image_moo->load($file_uploaded)->resize(500, 500)->save($file_uploaded, true);

        return true;
    }


}
