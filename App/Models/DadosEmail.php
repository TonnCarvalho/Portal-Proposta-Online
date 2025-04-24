<?php

namespace App\Models;

use MF\Model\Model;

class DadosEmail extends Model
{

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function pegarDadosPendencia($id_proposta)
    {
        $query = "SELECT p.id_proposta, p.num_proposta,
        u.nome, u.email
        FROM propostas AS p
        INNER JOIN usuarios AS u ON p.id_usuario = u.id_usuario
        WHERE p.id_proposta = $id_proposta";

        $stmt = $this->db->prepare($query);

        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultado;
    }
}
