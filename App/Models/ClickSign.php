<?php

namespace App\Models;

use MF\Model\Model;

class ClickSign extends Model
{

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function clickSignInicio()
    {
        $query = "SELECT a.nome,
            p.id_proposta, p.id_associado, p.num_proposta, p.valor_financiado, p.valor_liberado, p.valor_parcela, p.valor_mensalidade, p.prazo, p.status_refin,
            p.tipo_proposta,
            o.nome AS nome_praca,
            r.id_refin, r.num_contrato1, r.num_contrato2, r.num_contrato3, r.saldo_devedor1, r.saldo_devedor2, r.saldo_devedor3, r.valor_parcela1, r.valor_parcela2, r.valor_parcela3
            FROM associados AS a
            INNER JOIN propostas AS p ON p.id_associado = a.id_associado
            INNER JOIN origem AS o ON o.cod_local = p.cod_local
            LEFT JOIN refin AS r ON r.id_proposta = p.id_proposta
            WHERE p.status_assinatura = 1
            AND p.status_proposta = 5
            ORDER BY p.id_proposta ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function excelAssinaturaGerada(int $id_proposta)
    {
        $query = "UPDATE propostas
        SET status_assinatura = 0
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta, \PDO::PARAM_INT);
        $stmt->execute();

        return $this;
    }

    public function adicionarRefin()
    {
        $query = "INSERT INTO refin
        (id_proposta, id_associado, num_proposta, num_contrato1, saldo_devedor1, valor_parcela1, num_contrato2, saldo_devedor2, valor_parcela2, num_contrato3, saldo_devedor3, valor_parcela3)
        VALUES
        (:id_proposta, :id_associado, :num_proposta, :num_contrato1, :saldo_devedor1, :valor_parcela1, :num_contrato2, :saldo_devedor2, :valor_parcela2, :num_contrato3, :saldo_devedor3, :valor_parcela3)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $this->__get('id_proposta'));
        $stmt->bindValue(':id_associado', $this->__get('id_associado'));
        $stmt->bindValue(':num_proposta', $this->__get('num_proposta'));
        $stmt->bindValue(':num_contrato1', $this->__get('num_contrato1'));
        $stmt->bindValue(':num_contrato2', $this->__get('num_contrato2'));
        $stmt->bindValue(':num_contrato3', $this->__get('num_contrato3'));
        $stmt->bindValue(':saldo_devedor1', $this->__get('saldo_devedor1'));
        $stmt->bindValue(':saldo_devedor2', $this->__get('saldo_devedor2'));
        $stmt->bindValue(':saldo_devedor3', $this->__get('saldo_devedor3'));
        $stmt->bindValue(':valor_parcela1', $this->__get('valor_parcela1'));
        $stmt->bindValue(':valor_parcela2', $this->__get('valor_parcela2'));
        $stmt->bindValue(':valor_parcela3', $this->__get('valor_parcela3'));
        $stmt->execute();

        return $this;
    }
    public function editaRefin()
    {
        $query = "UPDATE refin
        SET
          num_contrato1 = :num_contrato1,
          num_contrato2 = :num_contrato2,
          num_contrato3 = :num_contrato3,
          saldo_devedor1 = :saldo_devedor1,
          saldo_devedor2 = :saldo_devedor2,
          saldo_devedor3 = :saldo_devedor3,
          valor_parcela1 = :valor_parcela1,
          valor_parcela2 = :valor_parcela2,
          valor_parcela3 = :valor_parcela3
          WHERE id_refin = :id_refin";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':num_contrato1', $this->__get('num_contrato1'));
        $stmt->bindValue(':num_contrato2', $this->__get('num_contrato2'));
        $stmt->bindValue(':num_contrato3', $this->__get('num_contrato3'));
        $stmt->bindValue(':saldo_devedor1', $this->__get('saldo_devedor1'));
        $stmt->bindValue(':saldo_devedor2', $this->__get('saldo_devedor2'));
        $stmt->bindValue(':saldo_devedor3', $this->__get('saldo_devedor3'));
        $stmt->bindValue(':valor_parcela1', $this->__get('valor_parcela1'));
        $stmt->bindValue(':valor_parcela2', $this->__get('valor_parcela2'));
        $stmt->bindValue(':valor_parcela3', $this->__get('valor_parcela3'));
        $stmt->bindValue(':id_refin', $this->__get('id_refin'));
    }
    public function dadosExcelClickSing($id_proposta)
    {
        $query = "SELECT p.id_proposta, a.estado_civil, a.agencia, a.banco, a.conta, a.sexo, a.nome_pai, a.setor, a.nome, a.data_nasc, a.cpf, a.mat, a.rg, a.orgao_exp, a.email, a.cel, a.cargo, a.nat, a.nome_mae, a.endereco, a.bairro, a.municipio, a.uf, a.cep, a.tel,
        o.nome AS nome_orgao,
        p.num_proposta,p.cod_local, p.cod_corretor,p.valor_financiado,p.valor_mensalidade, p.valor_parcela, p.prazo,
        r.num_contrato1, r.num_contrato2, r.num_contrato3, r.saldo_devedor1, r.saldo_devedor2, r.saldo_devedor3, r.valor_parcela1, r.valor_parcela2, r.valor_parcela3, r.data_hora
        FROM associados AS a
        INNER JOIN propostas AS p ON p.id_associado = a.id_associado
        INNER JOIN orgaos AS o ON o.cod_orgao = a.cod_orgao
        LEFT JOIN refin AS r ON r.id_proposta = p.id_proposta
        WHERE p.id_proposta = :id_proposta
        AND o.cod_local = p.cod_local";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }
    public function mudarStatusRefinProposta($id_proposta)
    {
        $query = "UPDATE propostas
        SET
        status_refin = 1
        WHERE id_proposta = $id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $this;
    }
    public function apagaRefin($id_refin)
    {
        $query = "DELETE FROM refin
        WHERE id_refin = $id_refin";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $this;
    }
    public function removeRefinProposta($id_proposta)
    {
        $query = "UPDATE propostas
        SET 
        status_refin = 0
        WHERE id_proposta = $id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $this;
    }
}
