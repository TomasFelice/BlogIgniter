<?php 

class Emails {

    private string $config;

    public function __construct() {
        $CI = & get_instance();
        $CI->load->library("email");

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_port'] = 25;
        $config['smtp_user'] = 'tfelice.quinttos@gmail.com';
        // Cambiar password por el password de la cuenta de correo
        $config['smtp_pass'] = 'Chic@g01710!';
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';

        $CI->email->initialize($config);
    }

    public function recover_account($link, $email) {

        $CI = & get_instance();
        $subject = 'Recuperación de cuenta';
        $data['link'] = $link;
        $html = $CI->load->view('emails/recover_account', $data, TRUE);


        $this->send_email($email, $subject, $html);
    }

    private function send_email($email, $subject, $html) {
        $CI = & get_instance();
        $CI->email->from('tfelice.quinttos@gmail.com', 'Tomás Felice');
        $CI->email->to($email);

        $CI->email->subject($subject);
        $CI->email->message($html);

        $CI->email->send();
    }
}