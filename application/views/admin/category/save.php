<!-- Formulario -->
<!-- form_open() envia todo por post -->
<?= form_open('', 'class="my_form"'); ?>
    <div class="form-group">
        <?= form_label('Nombre', 'name'); ?>
        <?php
            $text_input = array(
                'name' => 'name',
                'id' => 'name',
                'class' => 'form-control input-lg',
                'value' => $name
            );

            echo form_input($text_input);
        ?>
        <?= form_error('name', '<div class="text-error">', '</div>'); ?>
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

    <?= form_submit('mysubmit', 'Guardar', 'class="btn btn-primary"'); ?>

<?= form_close(); ?>
								