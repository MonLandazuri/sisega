@extends('layouts.master')

@section('content')
<section class="section">
  <div class="section-header">
    <h1></h1>
  </div>
  <div class="row">          
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    </div>
  </div>

  
  <div class="row">
    <div class="col-12">
      <div class="card">      
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>                                 
                <tr>
                  <th class="col-izq">#</th>
                  <th class="col-der">DATOS</th>
                </tr>
              </thead>
              <tbody>   
              @if ($contratista->count() > 0)  
                @foreach ($contratista as $contra)                              
                <tr>
                  <td>ID</td>
                  <td>
                    {{ $contra->id_contratista }}
                  </td>
                </tr>
                <tr>
                  <td>NOMBRE</td>
                  <td>
                    <textarea cols="50" rows="3">{{ $contra->nombre_contratista }}</textarea>
                  </td>   
                </tr>                       
                <tr>
                  <td>DIRECCIÓN</td>
                  <td>
                    <textarea cols="50" rows="3">{{ $contra->direccion_contratista }}</textarea>
                  </td>  
                </tr>                        
                <tr>
                  <td>BANCO</td>
                  <td>
                    <textarea cols="50" rows="3">{{ $contra->banco_contratista }}</textarea>
                  </td>  
                </tr>                        
                <tr>
                  <td>CLABE</td>
                  <td>
                    <textarea cols="50" rows="3">{{ strtoupper($contra->clabe_contratista) }}</textarea>
                  </td>
                </tr>                          
                <tr>
                  <td>CUENTA</td>
                  <td>
                    <textarea cols="50" rows="3">{{ strtoupper($contra->cuenta_contratista) }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="btn-group">
                      <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(119px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="{{ route('info.contratista', ['id_contratista' => $contra->id_contratista]) }}">Ver</a>
                        <a class="dropdown-item" title="Eliminar" data-confirm="¿Quieres eliminar el Contratista?" data-confirm-yes="alert('Deleted')"  href="#">Eliminar</a>
                      </div>
                      <!--<div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(119px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="{{ route('contratistas') }}">Ver</a>
                        <a class="dropdown-item" title="Cancelar" data-confirm="¿Quieres cancelar el Proyecto?" data-confirm-yes="alert('Deleted')"  href="#">Cancelar</a>
                        <a class="dropdown-item" title="Finalizar" data-confirm="¿Quieres finalizar el Proyecto?" data-confirm-yes="alert('Deleted')" href="#">Finalizar</a>
                      </div>-->
                    </div>
                  </td>
                </tr>
                @endforeach 
                @else
                    <p>No hay proyectos disponibles.</p>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Archivos de Contratista</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('contratistas.archivos.store', $contra->id_contratista) }}" class="dropzone dz-clickable" id="documentUploadDropzone">
                @csrf
                <div class="dz-default dz-message"><span>Arrastra documentos aquí o haz clic para subir.</span></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@section('scripts')
<script>
    Dropzone.autoDiscover = false; // Importante para inicializar Dropzone manualmente

    $(document).ready(function() {
        var myDropzone = new Dropzone("#documentUploadDropzone", {
            url: "{{ route('contratistas.archivos.store', $contra->id_contratista) }}",
            paramName: "file",
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            dictRemoveFile: "Quitar archivo",
            dictDefaultMessage: "Arrastra documentos aquí o haz clic para subir.",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function() {
                this.on("success", function(file, response) {
                    console.log("Archivo subido con éxito:", response);
                    if(response.success) {
                        // Agrega el nuevo archivo a la tabla
                        addFileToTable(response.file);
                        // Almacena el ID del servidor en el objeto de archivo de Dropzone para su eliminación
                        file.serverId = response.file.id;
                    }
                });
                this.on("error", function(file, message) {
                    console.error("Error al subir archivo:", message);
                    // Dropzone a veces devuelve el mensaje de error en el objeto response.errors.file
                    var errorMessage = message.errors && message.errors.file ? message.errors.file[0] : (typeof message === 'string' ? message : 'Error desconocido');
                    alert("Error al subir el archivo: " + errorMessage);
                    this.removeFile(file); // Quita la vista previa del archivo si hay un error
                });
                this.on("removedfile", function(file) {
                    // Si el archivo se subió con éxito (tiene un serverId), inicia la eliminación del lado del servidor
                    if (file.serverId) {
                        deleteFileFromServer(file.serverId);
                    }
                });
            }
        });

        // Función para agregar una fila a la tabla de archivos subidos
        function addFileToTable(fileData) {
            var tableBody = $('#archivosContratistaTable tbody');
            // Si la tabla estaba vacía, quita el mensaje "No hay documentos..."
            if (tableBody.find('tr').length === 1 && tableBody.find('tr td').attr('colspan') == 5) {
                tableBody.empty();
            }

            var newRow = `
                <tr id="file-row-${fileData.id}">
                    <td>${fileData.name}</td>
                    <td>${fileData.type}</td>
                    <td>${(fileData.size / 1024 / 1024).toFixed(2)} MB</td>
                    <td>${fileData.created_at}</td>
                    <td>
                        <a href="${fileData.url}" class="btn btn-sm btn-info" target="_blank" title="Ver"><i class="fas fa-eye"></i></a>
                        <button class="btn btn-sm btn-danger delete-file-btn" data-id="${fileData.id}" title="Eliminar"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            // Agrega la nueva fila al final de la tabla
            tableBody.append(newRow);
        }

        // Función para eliminar un archivo del servidor
        function deleteFileFromServer(fileId) {
            if (!confirm('¿Estás seguro de que quieres eliminar este archivo? Esta acción es irreversible.')) {
                return;
            }
            $.ajax({
                url: `/archivos/${fileId}`, // Ajusta la URL si tu ruta es diferente, pero con Route Model Binding debería funcionar
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#file-row-' + fileId).remove(); // Elimina la fila de la tabla
                        alert(response.message);
                    } else {
                        alert("Error al eliminar el archivo: " + response.message);
                    }
                    // Si la tabla queda vacía, puedes mostrar el mensaje de "No hay documentos" de nuevo
                    if ($('#archivosContratistaTable tbody tr').length === 0) {
                        $('#archivosContratistaTable tbody').append('<tr><td colspan="5">No hay documentos subidos para este contratista.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al eliminar archivo:", error);
                    alert("Error al eliminar el archivo. Verifica la consola para más detalles.");
                }
            });
        }

        // Delegar el evento click para los botones de eliminar en la tabla
        $(document).on('click', '.delete-file-btn', function() {
            var fileId = $(this).data('id');
            deleteFileFromServer(fileId);
        });
    });
</script>
@endsection
</section>
@push('styles')
<style>
  .table .col-izq{
    width: 30% !important;
  }
  .table .col-der{
    width: 60% !important;
  }
</style>
@endpush
@endsection