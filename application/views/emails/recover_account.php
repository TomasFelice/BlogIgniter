<html>
    <head>
        <?php $this->load->view('emails/css_email'); ?>
    </head>
    <body>
        <div class="container">
            <img src="<?= base_url() . 'assets/img/logo.png' ?>" alt="Logo de BlogIgniter" class="photo">
            <br>
            <div class="header">
                <h1>Recuperación de Cuenta</h1>
            </div>
            <p class="description">Hola estimado,</p>
            <p class="description">Hemos recibido una solicitud para recuperar el acceso a tu cuenta</p>
            <p class="description">Para recuperarla, haz click en el siguiente enlace:</p>
            <a class="green" href="<?= base_url() . $link; ?>">Recuperar Cuenta</a>
        </div>
    </body>
</html>