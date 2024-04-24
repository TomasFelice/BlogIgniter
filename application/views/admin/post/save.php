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
                'value' => ''
            );

            echo form_input($text_input);
        ?>
        <?= form_error('title', '<div class="text-error">', '</div>'); ?>
    </div>
    <div class="form-group">
        <?= form_label('Url_limpia', 'url_clean'); ?>
        <?php
            $text_input = array(
                'name' => 'url_clean',
                'id' => 'url_clean',
                'class' => 'form-control input-lg',
                'value' => ''
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
                'value' => ''
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
                'value' => ''
            );

            echo form_textarea($text_area);
        ?>
        <?= form_error('description', '<div class="text-error">', '</div>'); ?>  
    </div>
    <div class="form-group"> 
        <?= form_label('Imagen', 'image'); ?>
        <?php
            $file_input = array(
                'name' => 'image',
                'id' => 'image',
                'class' => 'form-control input-lg',
                'value' => '',
                'type' => 'file'
            );

            echo form_upload($file_input);
        ?>  
    </div>
    <div class="form-group"> 
        <?= form_label('Publicado', 'posted'); ?>
        <!-- dropdown -> select en html -->
        <?= form_dropdown('posted', $data_posted, null, 'class="form-control input lg"'); ?>                                        
    </div>

    <?= form_submit('mysubmit', 'Guardar', 'class="btn btn-primary"'); ?>

<?= form_close(); ?>
								