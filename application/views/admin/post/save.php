<!-- Formulario -->
<!-- form_open() envia todo por post -->
<?= form_open('', 'class="my_form" enctype="multipart/form-data"'); ?>
    <div class="form-group">
        <?= form_label('Titulo', 'title'); ?>
        <?php
            $text_input = array(
                'name' => 'title',
                'id' => 'title',
                'class' => 'form-control input-lg',
                'value' => $title
            );

            echo form_input($text_input);
        ?>
        <?= form_error('title', '<div class="text-error">', '</div>'); ?>
    </div>
    <div class="form-group">
        <?= form_label('Url Limpia', 'url_clean'); ?>
        <?php
            $text_input = array(
                'name' => 'url_clean',
                'id' => 'url_clean',
                'class' => 'form-control input-lg',
                'value' => $url_clean
            );

            echo form_input($text_input);
        ?>
        <?= form_error('url_clean', '<div class="text-error">', '</div>'); ?>
    </div>
    <div class="form-group"> 
        <?= form_label('Contenido', 'content'); ?>
        <?php
            $text_area = array(
                'name' => 'content',
                'id' => 'content',
                'class' => 'form-control input-lg',
                'value' => $content
            );

            echo form_textarea($text_area);
        ?>  
        <?= form_error('content', '<div class="text-error">', '</div>'); ?>
    </div>
    <div class="form-group"> 
        <?= form_label('Descripcion', 'description'); ?>
        <?php
            $text_area = array(
                'name' => 'description',
                'id' => 'description',
                'class' => 'form-control input-lg',
                'value' => $description
            );

            echo form_textarea($text_area);
        ?>
        <?= form_error('description', '<div class="text-error">', '</div>'); ?>  
    </div>
    <div class="form-group"> 
        <?= form_label('Imagen', 'image'); ?>
        <?php
            $file_input = array(
                'name' => 'upload',
                'id' => 'upload',
                'class' => 'form-control input-lg',
                'value' => '',
                'type' => 'file'
            );

            echo form_upload($file_input);
        ?> 
        
        <?= $image != '' ? '<img class="img_post img-presentation-small" src="' . base_url() . 'uploads/post/' . $image . '">' : ''; ?>
    </div>
    <div class="form-group"> 
        <?= form_label('Publicado', 'posted'); ?>
        <!-- dropdown -> select en html -->
        <?= form_dropdown('posted', $data_posted, $posted, 'class="form-control input lg"'); ?>                                        
    </div>

    <?= form_submit('mysubmit', 'Guardar', 'class="btn btn-primary"'); ?>

<?= form_close(); ?>

<script>
    $(function () {
        let editor = CKEDITOR.replace('content', {
            height: 400,
            filebrowserUploadUrl: "<?= base_url() ?>admin/upload",
            filebrowserBrowseUrl: "<?= base_url() ?>admin/images_server"
        });
    });
</script>

								