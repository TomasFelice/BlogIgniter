<?php $grocery_crud = json_decode($grocery_crud);?>

<?php foreach($grocery_crud->css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>

<?php foreach($grocery_crud->js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
