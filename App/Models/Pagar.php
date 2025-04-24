<?php

namespace App\Models;

use MF\Model\Model;

class Pagar extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function getPropostas()
    {
        $query = "SELECT 
                    p.id_proposta, 
                    p.num_proposta, 
                    a.nome as nome_associado,
                    o.nome as nome_praca,
                    DATE_FORMAT(p.data_proposta, '%d/%m/%Y') as data_proposta,
                    p.status_proposta,
                    p.status_recusado,
                    p.valor_financiado,
                    p.valor_liberado
                    FROM propostas AS p
                    INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                    INNER JOIN origem AS o ON o.cod_local = p.cod_local
                    WHERE p.status_proposta = 9
                    AND p.status_recusado = 0
                    ORDER BY p.data_proposta, p.num_proposta ASC
                    LIMIT 20";
        $stmt = $this->db->query($query);
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function getPesquisaPropostas()
    {
        $query = "SELECT 
        p.id_proposta, 
        p.num_proposta, 
        a.nome as nome_associado,
        o.nome as nome_praca,
        DATE_FORMAT(p.data_proposta, '%d/%m/%Y') as data_proposta,
        p.status_proposta,
        p.status_recusado,
        p.valor_financiado,
        p.valor_liberado
        FROM propostas AS p
        INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
        INNER JOIN origem AS o ON o.cod_local = p.cod_local
        WHERE p.status_proposta = 9
        AND p.status_recusado = 0
        AND (a.nome LIKE :nome
        OR a.cpf LIKE :cpf
        OR p.num_proposta LIKE :num_proposta)
        ORDER BY p.data_proposta, p.num_proposta ASC
        LIMIT 20";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', '%' .  $this->__get('nome') . '%');
        $stmt->bindValue(':cpf', '%' . $this->__get('cpf') . '%');
        $stmt->bindValue(':num_proposta', '%' . $this->__get('num_proposta') . '%');
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function getDataPropostas()
    {
        $query = "SELECT 
        p.id_proposta, 
        p.num_proposta, 
        a.nome as nome_associado,
        o.nome as nome_praca,
        DATE_FORMAT(p.data_proposta, '%d/%m/%Y') as data_proposta,
        p.status_proposta,
        p.status_recusado,
        p.valor_financiado,
        p.valor_liberado
        FROM propostas AS p
        INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
        INNER JOIN origem AS o ON o.cod_local = p.cod_local
        WHERE p.status_proposta = 9
        AND p.status_recusado = 0
        AND (DATE(p.data_proposta) = :data)
        ORDER BY p.data_proposta, p.num_proposta ASC
        LIMIT 30";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':data', $this->__get('data'));
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }
}
