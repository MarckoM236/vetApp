function deleteObject(id,route,success,error){
    var url = `/${route}/${id}/delete`;
    Swal.fire({
            title: 'Confirmar',
            text: '¿Estás seguro de que desea eliminar el cliente?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Eliminado', success, 'success');
                            window.location.reload();
                        } else {
                            Swal.fire('Error', error, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
                    }
                });
            }
        });
}