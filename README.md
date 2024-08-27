# Aplicación Web en PHP con el Modelo MVC para la Gestión de Celulares

A continuación se mostrará una breve explicación de cada parte implementada en la creación de la aplicación web con el modelo MVC.

## link de evidencias (video)



## Instrucciones para ejecutar la aplicación

### Paso 1: Descargar en instalar un servidor local

Primeramente se debe tener en cuenta que se necesita de un servidor local a elección, en este caso se utilizó XAMPP de Apache.

Enlace página oficial XAMPP: https://www.apachefriends.org/es/index.html

En el enlace anterior es posible descargar e instalar este servidor local.

### Paso 2: Inicializar el servidor local y descargar el proyecto

Una vez se tenga instalado XAMPP, se lo debe ejecutar e inicializar las dos primeras opciones que son Apache y MySQL, basta con darle click en "Start".

Una vez listo el servidor local, se procede a descargar el proyecto respectivo, en este caso de nombre examen_final, en formato .zip, una vez descargado darle click derecho y buscar la opción extraer aqui, aparecerá una carpeta del mismo nombre, esa carpeta debe ser copiada y pegada dentro de la carpeta htdocs que se encuentra en la dirección donde se haya instalado el servidor local, por lo general suele ser en C:\xampp\htdocs.

### Paso 3: Ingreso al proyecto desde Visual Studio Code

Una vez ubicada la carpeta del proyecto en el directorio correspondiente, se debe proceder a abrir Visual Studio Code.

En caso de que se requiera descargar e instalar el mismo, se especifica el siguiente enlace: https://code.visualstudio.com/ el cual direcciona a la página oficial de visual studio.

Dentro de Visual Studio Code, dirigirse hacia la parte superior izquierda sección "File", luego buscar la opción "Open Folder" y buscar la carpeta anteriormente ubicada en htdocs de nombre examen_final, apenas se abra la carpeta se mostrarán todas las implementaciones.

### Paso 4: Creación de la base de datos en XAMPP phpMyAdmin

Una vez completados todos los pasos anteriores, se procede a crear una base de datos en MySQL phpMyAdmin presente en XAMPP, para ello es de dirigirse al servidor local, buscar MySQL y darle click en la opción "Admin", automáticamente abrirá el navegador, mostrando phpMyAdmin.

**Base de datos:** Una vez dentro de phpMyAdmin, se debe crear una base de datos de nombre examen_final (El nombre debe ser tal cual como se menciona, sin embargo es posible cambiarlo en la parte de los modelos DB.php dentro de Visual Studio Code).

**Tabla celulares:** Una vez creada la base de datos se procede a crear la tabla autores con el siguiente código:

```
CREATE TABLE Celulares (
    id INT PRIMARY KEY AUTO_INCREMENT, -- identificador único para cada celular
    marca VARCHAR(50),                -- marca del celular
    modelo VARCHAR(50),               -- modelo del celular
    fecha_lanzamiento DATE,           -- fecha de lanzamiento del celular
    capacidad_bateria INT,            -- capacidad de la batería en mAh
    sistema_operativo VARCHAR(50),    -- sistema operativo del celular
    precio DECIMAL(10, 2)             -- precio del celular
);
```
Luego de haber digitado el código, se debe proceder a ejecutarlo, para ello se dará click en la opción continuar presente en la parte inferior izquierda.

### Paso 5: Aplicación web en el navegador utilizando XAMPP

Por último, se procede a abrir la aplicación web en el navegador utilizando el servidor local.

Para entrar en la página de inicio de la aplicación, se digitará lo siguiente (mientras se tiene abierto XAMPP en segundo plano): localhost/examen_final

Una vez digitada la ruta anterior, se presionará la tecla "enter" y automáticamente aparecerá la página de inicio de la aplicación respectiva, asi también en la misma página es posible navegar hacia la gestión de libros como la gestión de autores correspondientemente.

### Funcionalidad para gestionar Libros y autores

Para agregar un celular, basta con darle click en el botón agregar, es posible editar y eliminar cualquier autor agregado posteriormente.

## Estructura del proyecto aplicación web MVC-PHP

## Parte 1: Controladores

### 1.- Archivo controlador para los celulares de nombre CelularesController.php

Para este apartado se procedió a implementar una clase de nombre CelularesController la cual se encargará de gestionar las solicitudes relacionadas con los autores.

### Código implementado

```php
<?php
class CelularesController {
    public function index()
    {
        $celulares = Celular::all();
        view("celulares.index", ["celulares" => $celulares]);
    }
    public function crear()
    {
        echo "Estamos en crear celular";
    }
    public function create()
    {
        $data = json_decode(file_get_contents('php://input'));
        $celular = new Celular();
        $celular->marca = $data->marca;
        $celular->modelo = $data->modelo;
        $celular->fecha_lanzamiento = $data->fecha_lanzamiento;
        $celular->capacidad_bateria = $data->capacidad_bateria;
        $celular->sistema_operativo = $data->sistema_operativo;
        $celular->precio = $data->precio;
        $celular->save();
        echo json_encode($celular);
    }
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'));

        $celular = Celular::find($data->id);
        
        $celular->marca = $data->marca;
        $celular->modelo = $data->modelo;
        $celular->fecha_lanzamiento = $data->fecha_lanzamiento;
        $celular->capacidad_bateria = $data->capacidad_bateria;
        $celular->sistema_operativo = $data->sistema_operativo;
        $celular->precio = $data->precio;
        $celular->save();
        echo json_encode($celular);
    }
    public function delete($id)
    {
        try {
            $celular = Celular::find($id);
            $celular->remove();
            echo json_encode(['status' => true]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false]);
        }
    }
}
?>

```
### 2.- Archivo controlador para la página de inicio de nombre InicioController.php

En este punto solo se implementó una pequeña sentencia que se encargará de redirigir la petición url hacia la página de inicio principal.

### Código implementado

```php
<?php
class InicioController {
    public function index() {
        view("inicio.index", []);
    }
}
```
## Parte 2: Modelos

### 1.- Archivo clase DB encargada de manejar e interconectar el servicio MySQL hacia el modelo Celular, de nombre DB.php

En la base de datos se especifica el método de conexión, en este caso MySQL de donde se podrá ingresar directamente desde XAMPP, por este hecho se procede a definir el tipo de host como localhost, el nombre de la base de datos a crear en este caso examen_final, el usuario como root y sin contraseña, con el fin de agilizar el proceso de ingreso.

### Código implementado

```php
<?php
class DB extends PDO
{
    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=examen_final";
        parent::__construct($dsn, "root", "");
    }
}
?>
```
### 2.- Archivo clase modelo para los celulares de nombre Celular.php

En esta implementación se optó por ingresar funciones para mostrar los autores presentes en la base de datos establecida, de esta forma generando un modelo de la tabla presente en la mencionada, para este caso la entidad/tabla celulares de la base de datos, será contenedora de dos atributos que son el identificador "id" y el nombre.

### Código implementado

```php
<?php
class Celular extends DB
{
    public $id;
    public $marca;
    public $modelo;
    public $fecha_lanzamiento;
    public $capacidad_bateria;
    public $sistema_operativo;
    public $precio;
    public static function all()
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("SELECT * FROM celulares");
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_CLASS, Celular::class);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public static function find($id)
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("SELECT * FROM celulares WHERE id = :id");
            $prepare->execute([":id" => $id]);
            return $prepare->fetchObject(Celular::class);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function save()
    {
        $db = new DB();
        $params = [
            ":marca" => $this->marca,
            ":modelo" => $this->modelo,
            ":fecha_lanzamiento" => $this->fecha_lanzamiento,
            ":capacidad_bateria" => $this->capacidad_bateria,
            ":sistema_operativo" => $this->sistema_operativo,
            ":precio" => $this->precio
        ];

        try {
            if (empty($this->id)) {
                $prepare = $db->prepare("INSERT INTO celulares (marca, modelo, fecha_lanzamiento, capacidad_bateria, sistema_operativo, precio) VALUES (:marca, :modelo, :fecha_lanzamiento, :capacidad_bateria, :sistema_operativo, :precio)");
                $prepare->execute($params);
                $this->id = $db->lastInsertId();
            } else {
                $params[":id"] = $this->id;
                $prepare = $db->prepare("UPDATE celulares SET marca = :marca, modelo = :modelo, fecha_lanzamiento = :fecha_lanzamiento, capacidad_bateria = :capacidad_bateria, sistema_operativo = :sistema_operativo, precio = :precio WHERE id = :id");
                $prepare->execute($params);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function remove()
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("DELETE FROM celulares WHERE id = :id");
            $prepare->execute([":id" => $this->id]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

```
## Parte 3: Utilidades

### 1.- Archivo por defecto de nombre defaults.php

Para este apartado se procedió a implementar un archivo el cual tiene como finalidad realizar una inclusión dinámica de vistas en la estructura de archivos que se está creando, esto lo logra realizando un intercambio de parámetroos sin la necesidad de usar variables globales o modificaciones dirigidas hacia el alcance de las variables.

### Código implementado
```php
<?php

if (!function_exists("view")) {
    function view($nombreVista, $params)
    {
        foreach ($params as $key => $param) {
            $$key = $param;
        }
        $vista = explode('.', $nombreVista);
        include_once "./views/{$vista[0]}/$vista[1].php";
    }
}
```
## Parte 4: Vistas

### 1.- Vista para la sección Lista de celulares 

La implementación mostrada, está orientada a la parte visual de la gestión de celulares 

### Código implementado
```php
<?php
class Celular extends DB
{
    public $id;
    public $marca;
    public $modelo;
    public $fecha_lanzamiento;
    public $capacidad_bateria;
    public $sistema_operativo;
    public $precio;
    public static function all()
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("SELECT * FROM celulares");
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_CLASS, Celular::class);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public static function find($id)
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("SELECT * FROM celulares WHERE id = :id");
            $prepare->execute([":id" => $id]);
            return $prepare->fetchObject(Celular::class);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function save()
    {
        $db = new DB();
        $params = [
            ":marca" => $this->marca,
            ":modelo" => $this->modelo,
            ":fecha_lanzamiento" => $this->fecha_lanzamiento,
            ":capacidad_bateria" => $this->capacidad_bateria,
            ":sistema_operativo" => $this->sistema_operativo,
            ":precio" => $this->precio
        ];

        try {
            if (empty($this->id)) {
                $prepare = $db->prepare("INSERT INTO celulares (marca, modelo, fecha_lanzamiento, capacidad_bateria, sistema_operativo, precio) VALUES (:marca, :modelo, :fecha_lanzamiento, :capacidad_bateria, :sistema_operativo, :precio)");
                $prepare->execute($params);
                $this->id = $db->lastInsertId();
            } else {
                $params[":id"] = $this->id;
                $prepare = $db->prepare("UPDATE celulares SET marca = :marca, modelo = :modelo, fecha_lanzamiento = :fecha_lanzamiento, capacidad_bateria = :capacidad_bateria, sistema_operativo = :sistema_operativo, precio = :precio WHERE id = :id");
                $prepare->execute($params);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function remove()
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("DELETE FROM celulares WHERE id = :id");
            $prepare->execute([":id" => $this->id]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

```

## Parte 5: Router y implementación para direccionar rutas amigables

### 1.- Estructura del archivo router.php

Para la estructura funcional del router, se optó por incluir todas las rutas referentes a los modelos creados anteriormente, como lo son la base de datos, el modelo. La búsqueda de las URLs las realiza mediante identificadores para cada modelo correspondiente.

### Código implementado
```php
<?php
include_once "utils/defaults.php";
include_once "models/DB.php";
include_once "models/Celular.php";
$controller = $_GET['controller'];
$action = $_GET['action'];
$id = $_GET['id'];
if (empty($action))
    $action = "index";
$ctrlName = $controller . "Controller";
include "./controllers/$ctrlName.php";
$ctrl = new $ctrlName;
$ctrl->{$action}($id);
?>
```
### 2.- Estructura del archivo .htaccess

La estructura implementada para el archivo de configuración, se basa en la petición de rutas dirigidas directamente hacia el router implementado.

### Código implementado
```php
RewriteEngine On
RewriteRule ^([a-z]+)\/?([a-z]*)\/?([0-9]*)$ router.php?controller=$1&action=$2&id=$3
```
## Documentación

## Estructura de todo el proyecto realizado

A continuación se detallará la estructura general del proyecto MVC-PHP realizado.

### 1. Carpeta principal de nombre examen_final

Esta es la carpeta principal donde se especifican todas las demas subcarpetas encargadas de almacenar los archivos de configuración y las implementaciones que se realizen respectivamente.

Dentro de esta carpeta existen las subcarpetas controllers, models, utils y views.

Sin embargo también tiene ubicados directamente los archivos .htaccess y router.php.

### 2. Subcarpeta controllers

Esta subcarpeta contenida dentro de la principal, se encarga de contener todos los controladores respectivos llamados como CelularesController.php, 

Los cuales gestionan la lógica de la aplicación como tal, asi como la interacción con el modelo correspondiente de la aplicación.

### 3. Subcarpeta models

En esta subcarpeta se encuentran las clases que representan todos los datos y las operaciones que se realizarán sobre ellos, en este caso se encuentran implemetadas las clases DB.php para la base de datos, Celular.php para los celulares.php para el modelo.

### 4. Subcarpeta utils

En esta subcarpeta se encuentra el archivo de nombre defaults.php que se encarga principalmente de realizar una inclusión dinámica de vistas en la estructura de los archivos que se crearón anteriormente en las otras subcarpetas correspondeintes.

Esta inclusión la logra realizando un intercambio de parámetroos sin la necesidad de usar variables globales o modificaciones dirigidas hacia el alcance de las variables.

### 5. Subcarpeta views

Siendo la subcarpeta encargada me mostrar las interfaces de la aplicación web, se optó por dividir cada interfaz en otras subcarpetas diferentes para cada sección, quedando de la siguiente manera.

### 5.1. Subcarpeta views


## Funcionamiento del router en el diseño

El archivo llamado router.php es el nucleo de todo el proyecto, ya que su función principal es la de dirigir las solicitudes tanto a los controladores como a las acciones correspondientes, basándose en los parámetros presentes en la URL.

**Lo que realiza en su estructura:**
- *Incluir archivos necesarios:* Incluye los archivos defaults.php, DB.php, Celular.php, lo que permite usar sus funciones y clases en el enrutador.
- *Obtener parámetros de la URL:* Extrae los parámetros controller, action e id de la URL. Estos parámetros determinan qué controlador y acción se deben ejecutar.
- *Controlador predeterminado:* Si action no está especificado, se asigna un valor predeterminado "index".
- *Incluir y crear controlador:* Incluye el archivo del controlador correspondiente (nombrado como CelularController.php) y crea una instancia del controlador.
- *Llamar a la acción del controlador:* Llama al método correspondiente en el controlador con el parámetro id, si está presente.

## Funcionamiento de .htaccess en el diseño

El archivo .htaccess se usa para reescribir URLs, permitiendo que las URLs sean más limpias y amigables para el usuario.

**Funcionalidad de su estructura:**
- *Reescritura de URL:* Utiliza RewriteRule para transformar las URLs amigables en parámetros que router.php puede entender.
- *Regla de reescritura:* La regla ^([a-z]+)\/?([a-z]*)\/?([0-9]*)$ captura tres grupos:
  - ([a-z]+): El nombre del controlador.
  - ([a-z]*): La acción que el controlador debe realizar.
  - ([0-9]*): Un identificador opcional.
- *Redirección:* Redirige las solicitudes a router.php con los parámetros correspondientes, como controller, action e id.

## Funcionamiento y uso de Axios en el diseño

Principalmente Axios se utiliza para gestionar la interacción entre el frontend (la vista en HTML) y el backend (el servidor).

En el diseño implementado, Axios juega un papel crucial en la carga, actualización y eliminación de datos sin necesidad de recargar la página. 

A continuación se explica la funcionalidad respectiva.

### Axios en la implementación fetchAutoor presente en la interfaz para la gestión de celulares

En primera instancia Axios principalmente se usa para cargar datos específicos cuando el usuario desea editar un autor o un libro.

Para autor tenemos Axios en la siguiente parte presente en la subcarpeta views/celulares/index.php:

- **Función fetchAutor**:
```
  javascript
  const fetchAutor = (event) => {
    let id = event.target.closest('tr').dataset.id; // Obtiene el ID del autor desde el atributo data-id
    axios.get(`http://localhost/examen_final/celulares/find/${id}`).then((res) => {
      let info = res.data; // Obtiene la información del autor desde la respuesta de la petición
      document.querySelector("#celularesModalLabel").textContent = "Editar Celular"; // Cambia el título del modal
      document.querySelector('input[name="nombre"]').value = info.nombre; // Llena el campo de nombre con la información del celular
      document.querySelector('#identificador').value = id; // Llena el campo oculto con el ID del autor
      myModal.show(); // Muestra el modal
    });
  }
```

En esta parte, Axios realiza una solicitud GET para obtener los datos del autor que se va a editar. La respuesta de la solicitud se usa para llenar los campos del modal con la información del autor seleccionado.

### Axios en la implementación btn-guardar presente en la interfaz para la gestión de celulares

Axios también se utiliza para enviar datos al servidor con la finalidad de crear o actualizar registros.

Para autor tenemos Axios en la siguiente parte presente en la subcarpeta views/celulares/index.php:

- **Función btn-guardar**:
```
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
                        id,
                        marca,
                        modelo,
                        fecha_lanzamiento,
                        capacidad_bateria,
                        sistema_operativo,
                        precio,
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

```
Esta función también utiliza Axios para enviar una solicitud POST para crear o actualizar un libro, y actualiza la tabla en consecuencia.

### Axios en la implementación deleteCelular presente en la interfaz para la gestión de autores

Axios se utiliza para eliminar registros, enviando una solicitud DELETE al servidor.

Para autor tenemos Axios en la siguiente parte presente en la subcarpeta views/autores/index.php:

- **Función deleteCelular**:
```
javascript 
const deleteCelular = (event) => {
            let id = event.target.closest('tr').dataset.id; // Obtiene el ID del celular desde el atributo data-id
            axios.delete(`http://localhost/examen_final/celulares/delete/${id}`).then((res) => {
                let info = res.data; // Obtiene la respuesta de la eliminación
                if (info.status) { // Si la eliminación fue exitosa
                    document.querySelector(`tr[data-id="${id}"]`).remove(); // Elimina la fila correspondiente de la tabla
                }
            });
        }
```
No hace falta mostrar la implementación de ambas partes, debido a que en ambas funciones, Axios envía una solicitud DELETE para eliminar el registro correspondiente. Si la eliminación es exitosa, la fila correspondiente se elimina de la tabla correspondiente.

## Autores

- Hernández Ojeda Jonathan Rodrigo

