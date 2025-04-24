<?php

namespace App\Models;

use MF\Model\Model;

class Orgao extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function orgaos()
    {
        $query = "SELECT org.id_orgao ,org.inativo, org.cod_orgao, org.nome
        FROM orgaos AS org
        WHERE cod_local = :cod_local
        ORDER BY org.nome ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }
    //adicionar orgao
    public function adicionarOrgao()
    {
        $query = "INSERT INTO orgaos
            (cod_local, cod_orgao, nome, inativo) 
            VALUES 
            (:cod_local, :cod_orgao, :nome, :inativo)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->bindValue(':cod_orgao', $this->__get('cod_orgao'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':inativo', 0);
        $stmt->execute();

        return $this;
    }

    public function editaOrgao()
    {
        $query = "UPDATE orgaos
        SET nome = :nome
        WHERE id_orgao = :id_orgao";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':id_orgao', $this->__get('id_orgao'));
        $stmt->execute();

        return $this;
    }

    public function deletaOrgao()
    {
        $query = "DELETE FROM orgaos 
        WHERE id_orgao = :id_orgao";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_orgao', $this->__get('id_orgao'));
        $stmt->execute();

        return $this;
    }

    //pega o cargao pelo cod_local do associado
    public function buscaCodigoOrgaoPeloCodlocal()
    {
        $query = "SELECT org.cod_orgao, org.nome
        FROM orgaos AS org
        WHERE cod_local = :cod_local
        ORDER BY org.nome ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    // Responsavel por buscar todas os orgaos da praça do associado
    public function buscaCodigoOrgaoPeloCodlocalEdite()
    {
        $query = "SELECT org.*, a.cod_local
            FROM orgaos AS org
            INNER JOIN associados AS a ON org.cod_local = a.cod_local
            INNER JOIN propostas AS p ON a.id_associado = p.id_associado
            WHERE p.id_proposta = :id_proposta
            ORDER BY org.nome ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $this->__get('id_proposta'));
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }
    //Chamado quando adicionar orgão sem código do órgão
    public function buscaUltimoCodOrgParaIncrementar()
    {
        $query = "SELECT org.cod_orgao
        FROM orgaos AS org
        WHERE cod_local = :cod_local
        ORDER BY org.cod_orgao DESC
        LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function mudarSituacaoOrgao()
    {
        $query = "UPDATE orgaos
        SET inativo = :inativo
        WHERE id_orgao = :id_orgao";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':inativo', $this->__get('inativo'));
        $stmt->bindValue(':id_orgao', $this->__get('id_orgao'));
        $stmt->execute();

        return $this;
    }
}
