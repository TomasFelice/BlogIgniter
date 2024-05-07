<?php

class Blog extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->optional_session_auto(1);
        $this->load->model('Group_user_post', 'gup');
    }

    public function index ($num_page = 1) {
        $num_page--;
        $num_post = $this->Post->count();
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0) {
            $num_page = 0;
        } elseif ($num_page > $last_page) {
            $num_page = 0;
        }

        $offset = $num_page * PAGE_SIZE;

        // Meta Tags SEO
        $data = $this->build_header(
            '',
            '',
            '',
            base_url() . 'blog/'
        );

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = '/blog/';
        $data['posts'] = $this->Post->get_pagination($offset);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;

        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        
        $this->parser->parse("blog/template/body", $view);
    }

    public function category ($c_url_clean, $num_page = 1) {

        $category = $this->Category->getByUrlClean($c_url_clean);

        if(!isset($category)) {
            show_404();
        }

        $num_page--;
        $num_post = $this->Post->countByUrlClean($c_url_clean);
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0 || $num_page > $last_page) {
            redirect('/blog/category/' . $c_url_clean);
        }

        $offset = $num_page * PAGE_SIZE;
        
        // Meta Tags SEO
        $data = $this->build_header(
            APP_NAME . ' - ' . $category->name,
            'Posts de la categoría "' . $category->name . '"',
            '',
            base_url() . 'blog/category/' . $category->url_clean
        );

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'blog/category/' . $c_url_clean . '/';
        $data['posts'] = $this->Post->get_pagination($offset, 'si', 'desc', PAGE_SIZE, $c_url_clean);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;

        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        
        $this->parser->parse("blog/template/body", $view);
    }

    public function post_view(string $c_url_clean, string $url_clean = null) {
        $this->output->cache(PAGE_CACHE);

        if( strpos($this->uri->uri_string(), 'blog/post_view') != false) {
			show_404();
        }

        if(!isset($url_clean)) {
            show_404();
        }

        $post = $this->Post->getByUrlClean($url_clean);

        if(!isset($post)) {
            show_404();
        }

        $category = $this->Category->getByUrlClean($c_url_clean);

        if(!isset($category)) {
            show_404();
        }

        // Meta Tags SEO
        $data = $this->build_header(
            APP_NAME . ' - ' . $post->title,
            $post->description,
            image_post($post->post_id),
            base_url() . $category->url_clean . '/' . $post->url_clean,
        );
        
        $data['post'] = $post;
        
        $view['body'] = $this->load->view("blog/utils/post_detail", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);

    }

    public function search() {

        $search = $this->input->get_post('search');
        $category_id = $this->input->get_post('category_id');

        if(is_null($search) || $search == '') {
            return '';
        }

        // explode separa la cadena en un array
        $searchs = explode(' ', $search);

        $posts = $this->Post->getBySearch($searchs, $category_id);

        $data['posts'] = $posts;
        $data['pagination'] = false;
        $view['body'] = $this->load->view("blog/utils/post_list", $posts);
    }

    /* Favorites */
    
    public function favorite_save($post_id) {

        if ($this->session->userdata("id") != null) {
            $save = array('user_id' => $this->session->userdata("id"), 'post_id' => $post_id);
            $this->gup->insert($save);
            echo $post_id;
        } else
            echo 0;
    }

    public function favorite_delete($post_id) {

        if ($this->session->userdata("id") != null) {
            $this->gup->deleteByPostIdAndUserId($post_id, $this->session->userdata("id"));
            echo $post_id;
        } else
            echo 0;
    }

    public function favorite_list() {

        if ($this->session->userdata("id") == null) {
            show_404();
        }

        $posts = $this->Post->getGUP($this->session->userdata("id"));

        // Meta Tags SEO
        $data = $this->build_header(
            '',
            '',
            '',
            base_url() . 'blog/favorite_list',
        );

        $data['posts'] = $posts;
        $data['pagination'] = false;
        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    /* Funciones privadas */
    private function build_header($title = '', $desc = '', $imgurl = '', $url = '') {
        $data['title'] = $title;
        $data['desc'] = $desc;
        $data['imgurl'] = $imgurl;
        $data['url'] = $url;

        return $data;
    }
}

?>
