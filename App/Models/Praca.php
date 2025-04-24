<?php

namespace App\Models;

use MF\Model\Model;

class Praca extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    /**
     * Responsavel por buscar todas as pracas ativas
     * @return void
     */
    public function getTodasPracasAtivas()
    {
        $query = "SELECT cod_local, nome
        FROM origem
        WHERE inativo = 0
        ORDER BY nome ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function getPracaCadastroAssociado()
    {
        $query = "SELECT *
        FROM origem
        WHERE cod_local = :cod_local
        AND inativo = 0
        ORDER BY nome ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    //Lista as praças no /pracas
    public function todasPracas()
    {
        $query = "SELECT cod_local, nome, inativo
        FROM origem
        ORDER BY cod_local ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    //Ativa ou desativa praça
    public function mudarSituacaoPraca($cod_local, $ativo)
    {
        $query = "UPDATE origem
        SET inativo = $ativo
        WHERE cod_local = $cod_local";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $this;
    }

    //Adicionar Praça
    public function adicionarPraca()
    {
        $query = "INSERT INTO origem (cod_local, nome) 
        VALUES (:cod_local, :nome)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->bindValue(':nome', $this->__get('nome_praca'));
        $stmt->execute();

        return $this;
    }
    //Edita Praça
    public function editaPraca()
    {
        $query = "UPDATE origem SET
        nome = :nome
        WHERE cod_local = :cod_local";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->bindValue(':nome', $this->__get('nome_praca'));
        $stmt->execute();

        return $this;
    }

    public function deletaPraca()
    {
        $query = "DELETE FROM origem 
        WHERE cod_local = :cod_local";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->execute();

        return $this;
    }
    public function pesquisaPraca()
    {
        $query = "SELECT *
        FROM origem 
        WHERE (cod_local LIKE :cod_local
        OR nome LIKE :nome)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_local', '%' .  $this->__get('pesquisa') . '%');
        $stmt->bindValue(':nome', '%' .   $this->__get('pesquisa') . '%');

        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }
}
