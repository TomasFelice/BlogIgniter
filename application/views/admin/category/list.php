<table class="table table-condensed">
  <tbody>
    <!-- Headers de la tabla -->
    <tr>
      <th style="width: 10px">#</th>
      <th>Nombre</th>
      <th>Acciones</th>
    </tr>

    <!-- Contenido de la tabla -->
    <?php foreach($categories as $key => $category): ?>
    <tr>
      <td><?= $category->category_id ?></td>
      <td><?= $category->name ?></td>
      <td>
        <div class="mb-1">
          <a  class="btn btn-sm btn-primary"
              href="<?= base_url() . 'admin/category_save/' . $category->category_id ?>">
              <i class="fa fa-pencil"></i> Editar</a>
        </div>
        <div class="mt-1">
          <a  class="btn btn-sm btn-danger"
              href="#"
              data-categoryid="<?= $category->category_id ?>"
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
        <button type="button" class="btn btn-danger" id="borrar-category" data-dismiss="modal">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<script>

  let categoryId = 0;
  let deleteButton;// Button that triggered the modal
  
  // Abrimos el modal
  $('#deleteModal').on('show.bs.modal', function (event) {
    deleteButton = $(event.relatedTarget)
    categoryId = deleteButton.data('categoryid') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    let modal = $(this)
    modal.find('.modal-title').text('¿Deseas eliminar la Categoría seleccionada (id ' + categoryId + ')?')
    // modal.find('.modal-body input').val(postId)
  });

  // Llamamos a eliminar
  $('#borrar-category').click(function() {
    $.ajax({
      url: "<?= base_url() ?>admin/category_delete/" + categoryId
    }).done(function(res) {
      if(res) {
        $(deleteButton).parent().parent().parent().remove();
      }
    });
  });



</script>