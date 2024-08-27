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