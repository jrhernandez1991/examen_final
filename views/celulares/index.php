<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Define el tipo de documento como HTML5 -->
    <meta charset="UTF-8"> <!-- Define la codificación de caracteres como UTF-8 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Asegura compatibilidad con la versión más reciente del motor de renderizado de IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura el viewport para que el diseño sea responsive -->
    <title>Listado de celulares </title> <!-- Título que aparece en la pestaña del navegador -->
    
    <!-- Enlaza el archivo de estilos CSS de Bootstrap desde un CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Enlaza el archivo de scripts de Axios desde un CDN para hacer peticiones HTTP -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Enlaza el archivo de scripts de Bootstrap desde un CDN, incluyendo dependencias como Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Contenedor principal de la página con margen superior -->
    <div class="container">
        <!-- Título de la página con margen superior -->
        <h1 class="mt-5">Lista de Celulares</h1>
        
        <!-- Botón para abrir el modal de agregar celular con clase de éxito (verde) -->
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#celularesModal">Agregar</button>
        
        <!-- Tabla que lista los celulares con estilo de Bootstrap -->
        <table class="table table-striped mt-4" id="table">
            <thead>
                <!-- Encabezados de la tabla -->
                <tr>
                    <th>ID</th> <!-- Columna para el ID del celular -->
                    <th>Marca</th> <!-- Columna para la marca del celular -->
                    <th>Modelo</th> <!-- Columna para el modelo del celular -->
                    <th>Fecha de Lanzamiento</th> <!-- Columna para la fecha de lanzamiento del celular -->
                    <th>Capacidad de Batería (mAh)</th> <!-- Columna para la capacidad de la batería del celular -->
                    <th>Sistema Operativo</th> <!-- Columna para el sistema operativo del celular -->
                    <th>Precio</th> <!-- Columna para el precio del celular -->
                    <th>Acciones</th> <!-- Columna para las acciones (editar y eliminar) -->
                </tr>
            </thead>
            <tbody>
                <!-- Itera sobre la lista de celulares y crea una fila para cada celular -->
                <?php foreach ($celulares as $celular) : ?>
                    <tr data-id="<?php echo $celular->id; ?>">
                        <td><?php echo $celular->id; ?></td> <!-- Muestra el ID del celular -->
                        <td><?php echo $celular->marca; ?></td> <!-- Muestra la marca del celular -->
                        <td><?php echo $celular->modelo; ?></td> <!-- Muestra el modelo del celular -->
                        <td><?php echo $celular->fecha_lanzamiento; ?></td> <!-- Muestra la fecha de lanzamiento del celular -->
                        <td><?php echo $celular->capacidad_bateria; ?></td> <!-- Muestra la capacidad de la batería del celular -->
                        <td><?php echo $celular->sistema_operativo; ?></td> <!-- Muestra el sistema operativo del celular -->
                        <td><?php echo $celular->precio; ?></td> <!-- Muestra el precio del celular -->
                        <td>
                            <!-- Botones para editar y eliminar el celular -->
                            <button class="btn btn-warning btnEditar">Editar</button>
                            <button class="btn btn-danger btnEliminar">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para crear o editar un celular -->
    <div class="modal fade" id="celularesModal" tabindex="-1" aria-labelledby="celularesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título del modal y botón para cerrarlo -->
                    <h5 class="modal-title" id="celularesModalLabel">Crear Celular</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario dentro del modal para ingresar los datos del celular -->
                    <div class="form-floating mb-3">
                        <input type="text" name="marca" class="form-control" placeholder="Marca">
                        <label>Marca</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="modelo" class="form-control" placeholder="Modelo">
                        <label>Modelo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="fecha_lanzamiento" class="form-control" placeholder="Fecha de Lanzamiento">
                        <label>Fecha de Lanzamiento</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="capacidad_bateria" class="form-control" placeholder="Capacidad de Batería (mAh)">
                        <label>Capacidad de Batería (mAh)</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="sistema_operativo" class="form-control" placeholder="Sistema Operativo">
                        <label>Sistema Operativo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="precio" class="form-control" placeholder="Precio">
                        <label>Precio</label>
                    </div>
                </div>
                <!-- Campo oculto para almacenar el ID del celular cuando se edita -->
                <input type="hidden" id="identificador" value="">
                <div class="modal-footer">
                    <!-- Botones para cancelar o guardar cambios en el modal -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-guardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para manejar la lógica del frontend con JavaScript -->
    <script>
        // Crea una instancia del modal de Bootstrap para controlar su visibilidad
        let myModal = new bootstrap.Modal(document.getElementById('celularesModal'));

        // Función para cargar y mostrar información del celular en el modal para edición
        const fetchCelular = (event) => {
            let id = event.target.closest('tr').dataset.id; // Obtiene el ID del celular desde el atributo data-id
            axios.get(`http://localhost/examen_final/celulares/find/${id}`).then((res) => {
                let info = res.data; // Obtiene la información del celular desde la respuesta de la petición
                document.querySelector("#celularesModalLabel").textContent = "Editar Celular"; // Cambia el título del modal
                document.querySelector('input[name="marca"]').value = info.marca; // Llena el campo de marca con la información del celular
                document.querySelector('input[name="modelo"]').value = info.modelo; // Llena el campo de modelo con la información del celular
                document.querySelector('input[name="fecha_lanzamiento"]').value = info.fecha_lanzamiento; // Llena el campo de fecha de lanzamiento con la información del celular
                document.querySelector('input[name="capacidad_bateria"]').value = info.capacidad_bateria; // Llena el campo de capacidad de batería con la información del celular
                document.querySelector('input[name="sistema_operativo"]').value = info.sistema_operativo; // Llena el campo de sistema operativo con la información del celular
                document.querySelector('input[name="precio"]').value = info.precio; // Llena el campo de precio con la información del celular
                document.querySelector('#identificador').value = id; // Llena el campo oculto con el ID del celular
                myModal.show(); // Muestra el modal
            });
        }

        // Función para eliminar un celular
        const deleteCelular = (event) => {
            let id = event.target.closest('tr').dataset.id; // Obtiene el ID del celular desde el atributo data-id
            axios.delete(`http://localhost/examen_final/celulares/delete/${id}`).then((res) => {
                let info = res.data; // Obtiene la respuesta de la eliminación
                if (info.status) { // Si la eliminación fue exitosa
                    document.querySelector(`tr[data-id="${id}"]`).remove(); // Elimina la fila correspondiente de la tabla
                }
            });
        }

        // Agrega un evento click al botón de agregar para mostrar el modal en modo de creación
        document.querySelector('.btn.btn-success').addEventListener('click', () => {
                document.querySelector("#celularesModalLabel").textContent = "Crear Celular"; // Cambia el título del modal
                document.querySelector('input[name="marca"]').value = ""; // Limpia el campo de marca
                document.querySelector('input[name="modelo"]').value = ""; // Limpia el campo de modelo
                document.querySelector('input[name="fecha_lanzamiento"]').value = ""; // Limpia el campo de fecha de lanzamiento
                document.querySelector('input[name="capacidad_bateria"]').value = ""; // Limpia el campo de capacidad de batería
                document.querySelector('input[name="sistema_operativo"]').value = ""; // Limpia el campo de sistema operativo
                document.querySelector('input[name="precio"]').value = ""; // Limpia el campo de precio
                document.querySelector('#identificador').value = ""; // Limpia el campo oculto
                myModal.show(); // Muestra el modal
            });

        // Agrega un evento click al botón de guardar para crear o actualizar el celular
        document.querySelector('.btn-guardar').addEventListener('click', () => {
                let marca = document.querySelector('input[name="marca"]').value; // Obtiene el valor de la marca del celular
                let modelo = document.querySelector('input[name="modelo"]').value; // Obtiene el valor del modelo del celular
                let fecha_lanzamiento = document.querySelector('input[name="fecha_lanzamiento"]').value; // Obtiene el valor de la fecha de lanzamiento del celular
                let capacidad_bateria = document.querySelector('input[name="capacidad_bateria"]').value; // Obtiene el valor de la capacidad de batería del celular
                let sistema_operativo = document.querySelector('input[name="sistema_operativo"]').value; // Obtiene el valor del sistema operativo del celular
                let precio = document.querySelector('input[name="precio"]').value; // Obtiene el valor del precio del celular
                let id = document.querySelector('#identificador').value; // Obtiene el ID del celular

                axios.post(`http://localhost/examen_final/celulares/${id === "" ? 'create' : 'update'}`, {
                        marca,
                        modelo,
                        fecha_lanzamiento,
                        capacidad_bateria,
                        sistema_operativo,
                        precio,
                        id
                    })
                    .then((r) => {
                        let info = r.data; // Obtiene la información del celular desde la respuesta de la petición
                        if (id === "") { // Si el ID está vacío, se trata de una creación
                            let tr = document.createElement("tr"); // Crea una nueva fila en la tabla
                            tr.setAttribute('data-id', info.id); // Establece el atributo data-id de la fila con el ID del nuevo celular
                            tr.innerHTML = `<td>${info.id}</td>
                                            <td>${info.marca}</td>
                                            <td>${info.modelo}</td>
                                            <td>${info.fecha_lanzamiento}</td>
                                            <td>${info.capacidad_bateria}</td>
                                            <td>${info.sistema_operativo}</td>
                                            <td>${info.precio}</td>
                                            <td><button class='btn btn-warning btnEditar'>Editar</button>
                                            <button class='btn btn-danger btnEliminar'>Eliminar</button></td>`; // Añade el contenido HTML para la fila
                            document.getElementById("table").querySelector("tbody").append(tr); // Añade la nueva fila al cuerpo de la tabla
                            tr.querySelector('.btnEditar').addEventListener('click', fetchCelular);
                            tr.querySelector('.btnEliminar').addEventListener('click', deleteCelular);
                        } else {
                            let tr = document.querySelector(`tr[data-id="${id}"]`); // Selecciona la fila correspondiente
                            let cols = tr.querySelectorAll("td"); // Obtiene todas las celdas de la fila
                            cols[1].textContent = info.marca; // Actualiza la marca del celular en la fila
                            cols[2].textContent = info.modelo; // Actualiza el modelo del celular en la fila
                            cols[3].textContent = info.fecha_lanzamiento; // Actualiza la fecha de lanzamiento del celular en la fila
                            cols[4].textContent = info.capacidad_bateria; // Actualiza la capacidad de batería del celular en la fila
                            cols[5].textContent = info.sistema_operativo;
                            cols[6].textContent = info.precio;
                        }
                        myModal.hide();
                    });
            });

        document.querySelectorAll('.btnEditar').forEach(btn => btn.addEventListener('click', fetchCelular));
        document.querySelectorAll('.btnEliminar').forEach(btn => btn.addEventListener('click', deleteCelular));
    </script>
</body>
</html>
