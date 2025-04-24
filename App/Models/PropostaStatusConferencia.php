<?php

namespace App\Models;

use MF\Model\Model;

class PropostaStatusConferencia extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, $status_proposta)
    {

        $query = "INSERT INTO acompanhamento (id_proposta, id_usuario,id_conferente, status_proposta, data_status) 
        VALUES (:id_proposta, :id_usuario, :id_conferente, :status_proposta, NOW())";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':id_conferente', $id_conferente);
        $stmt->bindValue(':status_proposta', $status_proposta);

        $stmt->execute();

        return $this;
    }

    public function idConferente($id_proposta)
    {
        $query = "SELECT id_conferente
            FROM acompanhamento 
            WHERE id_proposta = $id_proposta
            AND status_proposta = 'em analise'";
        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }
}
