/** Script encargado de añadir y eliminar nuevos campos
 * de los formularios de creación de formularios.
 */

$(document).ready(function() {
    var i = 1;
    // Al pulsar botón de add, añadir una nueva fila
    $('#add').click(function() {
        i++;
        $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="name[]" placeholder="Ingrese nombre del campo" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    // Al pulsar botón de remove, obtener id de fila y eliminarla.
    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });


});
