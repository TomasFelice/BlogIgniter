<?php

function posted() {
    return array("no" => "No", "si" => "Si");
}

function categories_to_form($categories) {
    $aCategories = array();

    foreach ($categories as $key => $c) {
        $aCategories[$c->category_id] = $c->name;
    }

    return $aCategories;
}

function clean_name($name) {
    return convert_accented_characters(url_title($name, '-', true));
}

function all_images() {
    // Cargamos la librería de archivos
    $CI = & get_instance();
    $CI->load->helper('directory');

    // Obtenemos los archivos
    $dir = "uploads/post";
    $files = directory_map($dir);

    return $files;
}

function image_post($post_id) {
    // Cargamos la librería de archivos
    $CI = & get_instance();
    $post = $CI->Post->find($post_id);

    if(isset($post->image) && !empty($post->image)) {
        return base_url() . "uploads/post/" . $post->image;
    }

    return base_url() . "assets/img/logo_black.png";
}

function get_all_categories() {
    $CI = & get_instance();

    return $CI->Category->findAll();
}

