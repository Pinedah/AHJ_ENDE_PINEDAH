<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ejecutivos y Citas - SICAM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Sistema de Gestión</h1>
        
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="ejecutivos-tab" data-toggle="tab" href="#ejecutivos" role="tab">Ejecutivos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="citas-tab" data-toggle="tab" href="#citas" role="tab">Citas</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" id="myTabContent">
            <!-- EJECUTIVOS TAB -->
            <div class="tab-pane fade show active" id="ejecutivos" role="tabpanel">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Gestión de Ejecutivos</h4>
                    </div>
                    <div class="card-body">
                        <!-- Formulario para agregar ejecutivo -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" id="nom_eje" class="form-control" placeholder="Nombre del ejecutivo">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="tel_eje" class="form-control" placeholder="Teléfono">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary" onclick="guardarEjecutivo()">Agregar Ejecutivo</button>
                            </div>
                        </div>
                        
                        <!-- Filtro -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" id="filtro-ejecutivos" class="form-control" placeholder="Buscar ejecutivos...">
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-info" onclick="cargarEjecutivos()">Buscar</button>
                            </div>
                        </div>
                        
                        <!-- Tabla de ejecutivos -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-ejecutivos">
                                    <!-- Los datos se cargan aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CITAS TAB -->
            <div class="tab-pane fade" id="citas" role="tabpanel">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Gestión de Citas</h4>
                    </div>
                    <div class="card-body">
                        <!-- Formulario para agregar cita -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" id="nom_cit" class="form-control" placeholder="Nombre del cliente">
                            </div>
                            <div class="col-md-4">
                                <select id="id_eje2" class="form-control">
                                    <option value="">Seleccionar ejecutivo</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" onclick="guardarCita()">Agregar Cita</button>
                            </div>
                        </div>
                        
                        <!-- Filtro -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" id="filtro-citas" class="form-control" placeholder="Buscar citas...">
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-info" onclick="cargarCitas()">Buscar</button>
                            </div>
                        </div>
                        
                        <!-- Tabla de citas -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Ejecutivo Asignado</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-citas">
                                    <!-- Los datos se cargan aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cargar datos al inicializar
        $(document).ready(function() {
            cargarEjecutivos();
            cargarEjecutivosSelect();
            cargarCitas();
        });

        // FUNCIONES PARA EJECUTIVOS
        function cargarEjecutivos() {
            var filtro = $('#filtro-ejecutivos').val() || '';
            
            $.ajax({
                url: 'server/controlador_ejecutivo.php',
                type: 'POST',
                data: { 
                    action: 'obtener_ejecutivos',
                    filtro: filtro
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        renderizarEjecutivos(response.data);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error de conexión al servidor');
                }
            });
        }

        function renderizarEjecutivos(ejecutivos) {
            var html = '';
            ejecutivos.forEach(function(ejecutivo) {
                html += '<tr>';
                html += '<td>' + ejecutivo.id_eje + '</td>';
                html += '<td>' + ejecutivo.nom_eje + '</td>';
                html += '<td>' + ejecutivo.tel_eje + '</td>';
                html += '</tr>';
            });
            $('#tabla-ejecutivos').html(html);
        }

        function guardarEjecutivo() {
            var nom_eje = $('#nom_eje').val();
            var tel_eje = $('#tel_eje').val();
            
            if(!nom_eje || !tel_eje) {
                alert('Por favor complete todos los campos');
                return;
            }
            
            $.ajax({
                url: 'server/controlador_ejecutivo.php',
                type: 'POST',
                data: {
                    action: 'guardar_ejecutivo',
                    nom_eje: nom_eje,
                    tel_eje: tel_eje
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        alert('Ejecutivo guardado correctamente');
                        $('#nom_eje').val('');
                        $('#tel_eje').val('');
                        cargarEjecutivos();
                        cargarEjecutivosSelect();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error de conexión al servidor');
                }
            });
        }

        // FUNCIONES PARA CITAS
        function cargarEjecutivosSelect() {
            $.ajax({
                url: 'server/controlador_ejecutivo.php',
                type: 'POST',
                data: { action: 'obtener_ejecutivos' },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        var html = '<option value="">Seleccionar ejecutivo</option>';
                        response.data.forEach(function(ejecutivo) {
                            html += '<option value="' + ejecutivo.id_eje + '">' + ejecutivo.nom_eje + '</option>';
                        });
                        $('#id_eje2').html(html);
                    }
                }
            });
        }

        function cargarCitas() {
            var filtro = $('#filtro-citas').val() || '';
            
            $.ajax({
                url: 'server/controlador_ejecutivo.php',
                type: 'POST',
                data: { 
                    action: 'obtener_citas',
                    filtro: filtro
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        renderizarCitas(response.data);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error de conexión al servidor');
                }
            });
        }

        function renderizarCitas(citas) {
            var html = '';
            citas.forEach(function(cita) {
                html += '<tr>';
                html += '<td>' + cita.id_cit + '</td>';
                html += '<td>' + cita.nom_cit + '</td>';
                html += '<td>' + (cita.nom_eje || 'Sin asignar') + '</td>';
                html += '</tr>';
            });
            $('#tabla-citas').html(html);
        }

        function guardarCita() {
            var nom_cit = $('#nom_cit').val();
            var id_eje2 = $('#id_eje2').val();
            
            if(!nom_cit || !id_eje2) {
                alert('Por favor complete todos los campos');
                return;
            }
            
            $.ajax({
                url: 'server/controlador_ejecutivo.php',
                type: 'POST',
                data: {
                    action: 'guardar_cita',
                    nom_cit: nom_cit,
                    id_eje2: id_eje2
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        alert('Cita guardada correctamente');
                        $('#nom_cit').val('');
                        $('#id_eje2').val('');
                        cargarCitas();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error de conexión al servidor');
                }
            });
        }

        // Eventos de tecla para filtros
        $('#filtro-ejecutivos').keyup(function(e) {
            if(e.keyCode === 13) cargarEjecutivos();
        });

        $('#filtro-citas').keyup(function(e) {
            if(e.keyCode === 13) cargarCitas();
        });
    </script>
</body>
</html>
