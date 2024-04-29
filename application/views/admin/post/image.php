<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME . ' | ' . APP_DESCRIPTION ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/admin/custom.css">
    <!-- JQuery -->
    <script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <?php foreach ($images as $key => $image) : ?>
        <img class="img-presentation-small img-thumbnail" src="<?= '/' . PROJECT_FOLDER . '/uploads/post/' . $image ?>" alt="<?= $key ?>" >
    <?php endforeach;?>
    <div class="clearfix"></div>

    <script>
        let fileUrl = '';
        $("img").click(function() {
            fileUrl = $(this).attr("src");
            returnFileUrl();
        });

        // Helper function to get parameters from the query string.
        function getUrlParam( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );

            return ( match && match.length > 1 ) ? match[1] : null;
        }
        // Simulate user action of selecting a file to be returned to CKEditor.
        function returnFileUrl() {
            if ( !fileUrl.length ) {
                alert( 'Please select a file first.' );
                return;
            }

            var funcNum = getUrlParam( 'CKEditorFuncNum' );
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        }
    </script>
</body>
</html>