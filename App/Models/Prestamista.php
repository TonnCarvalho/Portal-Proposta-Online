<?php

namespace App\Models;

use MF\Model\Model;

class Prestamista extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function buscarAssociadosPrestaMista($cpf)
    {
        $query = "SELECT nome, cpf, SUM(valor_presente) AS total_presente
        FROM estoque
        WHERE cpf = :cpf";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue('cpf', $cpf);
        $stmt->execute();

        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }
}