<?php 

function image_user ($user_id) {
    $CI = & get_instance();
    
    $user = $CI->User->find($user_id);

    if (isset($user) && $user->avatar != '') {
        return base_url() . 'uploads/user/' . $user->avatar;
    }

    return base_url() . 'assets/img/logo.png';
}