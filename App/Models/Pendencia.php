<?php

namespace App\Models;

use MF\Model\Model;

class Pendencia extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function pendenciaCriar($id_proposta, $id_usuario)
    {
        $query = "INSERT INTO pendencia
        (id_proposta, mensagem, id_usuario)
        VALUES
        (:id_proposta, :mensagem, :id_usuario )";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':mensagem', $this->__get('mensagem'));
        $stmt->execute();

        return $this;
    }

    public function pendenciaEditar($id_proposta, $id_usuario)
    {
        $query = "UPDATE pendencia
        SET mensagem = :mensagem,
        id_usuario = :id_usuario
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':mensagem', $this->__get('mensagem'));
        $stmt->execute();

        $this->pendenciaReativada($id_proposta);
    }

    public function pendenciaReativada($id_proposta)
    {
        $query = "UPDATE pendencia
        SET status = 0
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta);
        $stmt->execute();
    }

    public function pendenciaDeleta($id_proposta)
    {
        $query = "DELETE FROM pendencia
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta);
        $stmt->execute();
        return $this;
    }
}
