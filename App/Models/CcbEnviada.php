<?php

namespace App\Models;

use MF\Model\Model;

class CcbEnviada extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function getPropostasCcbEnviada()
    {
        $query = "SELECT
        p.id_proposta,
        p.num_proposta,
        a.nome AS nome_associado,
        o.nome AS nome_praca,
        DATE_FORMAT(p.data_proposta, '%d%m%Y') AS data_proposta,
        p.status_proposta,
        p.status_recusado,
        p.valor_financiado,
        p.valor_liberado
        FROM propostas AS p
        INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
        INNER JOIN origem AS o ON o.cod_local = p.cod_local
        WHERE p.status_proposta = 8
        AND p.status_recusado = 0
        ORDER BY p.data_proposta, p.num_proposta ASC 
        LIMIT 20";
        $stmt = $this->db->query($query);
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }
}
