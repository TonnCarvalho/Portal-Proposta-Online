<?php

namespace App\Models;

use MF\Model\Model;

class Contadores extends Model
{
    public function propostaAndamentoContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas AS p
        WHERE p.status_proposta = 1
        AND status_recusado = 0";

        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaAnaliseContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas AS p
        WHERE p.status_proposta = 2
        AND status_recusado = 0";

        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaPendenteContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas AS p
        WHERE p.status_proposta = 3
        AND status_recusado = 0";

        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaPendenciaResolvidaContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas AS p
        WHERE p.status_proposta = 4
        AND status_recusado = 0";

        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaConferidoContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas AS p
        WHERE p.status_proposta = 5
        AND status_recusado = 0";

        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaAguardandoAssinaturaContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas AS p
        WHERE p.status_proposta = 6
        AND status_recusado = 0";

        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaAssinadoContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas
        WHERE status_proposta = 7
        AND status_recusado = 0";
        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaAguardandoCCBContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas
        WHERE status_proposta = 8
        AND status_recusado = 0";
        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaPagaContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas
        WHERE status_proposta = 9
        AND status_recusado = 0";
        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function propostaRecusadoContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas
        WHERE status_recusado = 1";
        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }

    public function clickSignContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM propostas AS p
        WHERE p.status_assinatura = 1
        AND p.status_proposta = 5";

        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }
    public function ConsultaContador()
    {
        $query = "SELECT COUNT(*) AS total
        FROM consultas AS c
        WHERE c.status_consulta = 1";

        $resultado = $this->db->query($query)->fetchColumn();
        return $resultado;
    }
}
