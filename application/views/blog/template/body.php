<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo APP_NAME . ' | ' . APP_DESCRIPTION ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css">
        <!-- JQuery Comments -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/blog/jquery-comments.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/blog/custom.css">

        <script>
            var BASE_URL = '<?php echo base_url() ?>';
        </script>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->load->view("blog/template/header"); ?>

        <section class="container">
            <div id="post_search"></div>
            {body}
        </section>

        <?php $this->load->view("blog/template/footer"); ?>

        <!-- JQuery -->
        <script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <!-- Toaster -->
        <script src="<?php echo base_url() ?>assets/js/jquery.toaster.js"></script>
        <!-- JQuery Comments -->
        <script src="<?php echo base_url() ?>assets/js/blog/jquery-comments.min.js"></script>
        <!-- Main.js -->
        <script src="<?php echo base_url() ?>assets/js/blog/main.js"></script>

        <?php if(!is_null($this->session->flashdata('text'))) : ?>
            <script>
                $.toaster({
                    priority : '<?php echo $this->session->flashdata('type') ?>',
                    title : '<?php echo $this->session->flashdata('text') ?>',
                    message : ''
                });
            </script>
        <?php endif; ?>
    </body>
</html>