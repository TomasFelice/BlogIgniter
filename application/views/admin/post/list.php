<table class="table table-condensed">
  <tbody>
    <!-- Headers de la tabla -->
    <tr>
      <th style="width: 10px">#</th>
      <th>Título</th>
      <th>Descripción</th>
      <th>Fecha de Creación</th>
      <th>Imagen</th>
      <th>Publicado</th>
      <th>Acciones</th>
    </tr>

    <!-- Contenido de la tabla -->
    <?php foreach($posts as $key => $post): ?>
    <tr>
      <td><?= $post->post_id ?></td>
      <td><?= word_limiter($post->title, 4) ?></td>
      <td><?= word_limiter($post->description, 4) ?></td>
      <td><?= format_date($post->created_at) ?></td>
      <td><?= $post->image != '' ? '<img class="img_post img-presentation-small" src="' . base_url() . 'uploads/post/' . $post->image . '">' : ''; ?></td>
      <td><?= ucfirst($post->posted);  ?></td>
      <td>
        <div class="mb-1">
          <a  class="btn btn-sm btn-primary"
              href="<?= base_url() . 'admin/post_save/' . $post->post_id ?>">
              <i class="fa fa-pencil"></i> Editar</a>
        </div>
        <div class="mt-1">
          <a  class="btn btn-sm btn-danger"
              href="#"
              data-postid="<?= $post->post_id ?>"
              data-toggle="modal"
              data-target="#deleteModal">
              <i class="fa fa-remove"></i> Eliminar</a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
								
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="borrar-post" data-dismiss="modal">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<script>

  let postId = 0;
  let deleteButton;// Button that triggered the modal
  
  // Abrimos el modal
  $('#deleteModal').on('show.bs.modal', function (event) {
    deleteButton = $(event.relatedTarget)
    postId = deleteButton.data('postid') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    let modal = $(this)
    modal.find('.modal-title').text('¿Deseas eliminar el Post seleccionado (id ' + postId + ')?')
    // modal.find('.modal-body input').val(postId)
  });

  // Llamamos a eliminar
  $('#borrar-post').click(function() {
    $.ajax({
      url: "<?= base_url() ?>admin/post_delete/" + postId
    }).done(function(res) {
      if(res) {
        $(deleteButton).parent().parent().parent().remove();
      }
    });
  });



</script>