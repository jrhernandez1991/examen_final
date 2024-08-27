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
