<?php

namespace App\Models;

use MF\Model\Model;

class Proposta extends Model
{
    private $id_proposta;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function cadastraProposta()
    {
        $num_proposta = $this->db->query("SELECT num_proposta AS numero_proposta FROM propostas")->fetchColumn();
        if ($num_proposta < 1) {
            $num_proposta = 30000000;
        } else {
            $num_proposta = $this->db->query("SELECT MAX(num_proposta) + 1 AS numero_proposta FROM propostas")->fetchColumn();
        }

        $query = "INSERT INTO propostas (id_associado, id_usuario, cod_local, cod_corretor, num_proposta,  valor_financiado, valor_liberado, valor_parcela, valor_mensalidade, iof, prazo, tipo_proposta) VALUES (:id_associado, :id_usuario, :cod_local, :cod_corretor, :num_proposta, :valor_financiado, :valor_liberado, :valor_parcela, :valor_mensalidade,:iof, :prazo, :tipo_proposta)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_associado', $this->__get('id_associado'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':num_proposta', $num_proposta);
        $stmt->bindValue(':valor_financiado', $this->__get('valor_financiado'));
        $stmt->bindValue(':valor_liberado', $this->__get('valor_liberado'));
        $stmt->bindValue(':valor_parcela', $this->__get('valor_parcela'));
        $stmt->bindValue(':valor_mensalidade', $this->__get('valor_mensalidade'));
        $stmt->bindValue(':iof', $this->__get('iof'));
        $stmt->bindValue(':prazo', $this->__get('prazo'));
        $stmt->bindValue(':tipo_proposta', $this->__get('tipo_proposta'));

        $stmt->execute();

        $this->id_proposta = $this->db->lastInsertId();
        return $this;
    }
    //Atualiza valores da proposta
    public function atualizaProposta()
    {
        $query = "UPDATE propostas 
        SET 
        id_usuario = :id_usuario,
        -- cod_local = :cod_local,
        -- cod_corretor = :cod_corretor,
        valor_financiado = :valor_financiado,
        valor_liberado = :valor_liberado,
        valor_parcela = :valor_parcela,
        valor_mensalidade = :valor_mensalidade,
        prazo = :prazo,
        iof = :iof,
        taxa = :taxa,
        tipo_proposta = :tipo_proposta
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        // $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        // $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':valor_financiado', $this->__get('valor_financiado'));
        $stmt->bindValue(':valor_liberado', $this->__get('valor_liberado'));
        $stmt->bindValue(':valor_parcela', $this->__get('valor_parcela'));
        $stmt->bindValue(':valor_mensalidade', $this->__get('valor_mensalidade'));
        $stmt->bindValue(':iof', $this->__get('iof'));
        $stmt->bindValue(':taxa', $this->__get('taxa'));
        $stmt->bindValue(':prazo', $this->__get('prazo'));
        $stmt->bindValue(':tipo_proposta', $this->__get('tipo_proposta'));
        $stmt->bindValue(':id_proposta', $this->__get('id_proposta'));

        $stmt->execute();

        return $this;
    }
    //Usada para se tiver os dados do associado mostrar no cadastro.
    //E inserir dados na proposta física
    public function pegarDadosProposta()
    {
        $query = "SELECT a.*,
        o.nome as nome_praca, org.nome AS nome_orgao,
        p.*, DATE_FORMAT(p.data_proposta, '%d/%m/%Y') as data_proposta,
        pen.mensagem, pen.status as pendencia_status
        FROM propostas AS p
        INNER JOIN associados as a ON a.id_associado = p.id_associado
        INNER JOIN origem AS o ON  a.cod_local = o.cod_local
        LEFT JOIN pendencia AS pen ON  p.id_proposta = pen.id_proposta
        INNER JOIN orgaos AS org ON a.cod_orgao = org.cod_orgao AND a.cod_local = org.cod_local
        WHERE p.id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $this->__get('id_proposta'));
        $stmt->execute();

        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }

    // Método para contar o total de propostas para paginação
    public function contarPropostas()
    {
        $query = "SELECT COUNT(*) as total 
        FROM propostas AS p
        LEFT JOIN associados AS a ON (a.id_associado = p.id_associado)
        WHERE a.inativo = 0";

        $resultado = $this->db->query($query)->fetch(\PDO::FETCH_ASSOC);

        return $resultado['total'];
    }

    //Responsavel por mostrar as propostas no crud em /inicio
    public function pegarPropostaInicio($limite, $offset)
    {
        $query = "SELECT 
        a.cod_local, a.cod_corretor, a.nome AS nome_associado, a.inativo,
        o.nome AS nome_praca,
        p.id_proposta, p.num_proposta,p.data_proposta, p.status_proposta, p.status_assinatura,
        p.status_recusado, p.status_refin
        FROM propostas AS p
        LEFT JOIN associados AS a ON (a.id_associado = p.id_associado)
        INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
        WHERE a.inativo = 0
        ORDER BY p.data_proposta DESC
        LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    //Retona as propostas filtradas nos select
    public function propostaFiltroPraca($limite, $offset)
    {
        $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta, 
            p.status_proposta,p.status_recusado, a.inativo,
            o.nome AS nome_praca
            FROM propostas AS p
            INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
            INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
            WHERE  p.cod_local = :cod_local
            AND a.inativo = 0
            ORDER BY id_proposta DESC
            LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    //Filtra situação da proposta
    public function propostaFiltroSituacao($limite, $offset)
    {

        switch ($this->__get('situacao')) {

            case 'andamento':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 1
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'analise':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 2
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'conferido':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                    p.status_proposta,p.status_recusado,
                    o.nome AS nome_praca
                    FROM propostas AS p
                    INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                    INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                    WHERE p.status_proposta = 5
                    AND  p.status_recusado = 0
                    AND a.inativo = 0 
                    ORDER BY p.id_proposta DESC
                    LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'pendente':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 3
                OR p.status_proposta = 4
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'aguardando_assinatura':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                    p.status_proposta,p.status_recusado,
                    o.nome AS nome_praca
                    FROM propostas AS p
                    INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                    INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                    WHERE p.status_proposta = 6
                    AND  p.status_recusado = 0
                    AND a.inativo = 0 
                    ORDER BY p.id_proposta DESC
                    LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'assinado':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                        p.status_proposta,p.status_recusado,
                        o.nome AS nome_praca
                        FROM propostas AS p
                        INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                        INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                        WHERE p.status_proposta = 7
                        AND  p.status_recusado = 0
                        AND a.inativo = 0 
                        ORDER BY p.id_proposta DESC
                        LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'ccb_enviada':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 8
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'aguardando_pagamento':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                    p.status_proposta,p.status_recusado,
                    o.nome AS nome_praca
                    FROM propostas AS p
                    INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                    INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                    WHERE p.status_proposta = 9
                    AND  p.status_recusado = 0
                    AND a.inativo = 0 
                    ORDER BY p.id_proposta DESC
                    LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'pago':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 10
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'recusado':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_recusado = 1
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;
        }

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }
    //Filtra situação da proposta com o cod_local
    public function propostaFiltroPracaSituacao($limite, $offset)
    {
        switch ($this->__get('situacao')) {

            case 'andamento':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
            p.status_proposta,p.status_recusado,
            o.nome AS nome_praca
            FROM propostas AS p
            INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
            INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
            WHERE p.status_proposta = 1
            AND  p.status_recusado = 0
            AND a.inativo = 0 
            AND  p.cod_local = :cod_local
            ORDER BY p.id_proposta DESC
            LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'analise':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 2
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'conferido':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 5
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'pendente':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 3
                OR p.status_proposta = 4
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'aguardando_assinatura':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                    p.status_proposta,p.status_recusado,
                    o.nome AS nome_praca
                    FROM propostas AS p
                    INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                    INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                    WHERE p.status_proposta = 6
                    AND  p.status_recusado = 0
                    AND a.inativo = 0 
                    AND  p.cod_local = :cod_local
                    ORDER BY p.id_proposta DESC
                    LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'assinado':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                        p.status_proposta,p.status_recusado,
                        o.nome AS nome_praca
                        FROM propostas AS p
                        INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                        INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                        WHERE p.status_proposta = 7
                        AND  p.status_recusado = 0
                        AND a.inativo = 0 
                        AND  p.cod_local = :cod_local
                        ORDER BY p.id_proposta DESC
                        LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;


            case 'ccb_enviada':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_proposta = 8
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'aguardando_pagamento':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                     p.status_proposta,p.status_recusado,
                     o.nome AS nome_praca
                     FROM propostas AS p
                     INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                     INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                     WHERE p.status_proposta = 9
                     AND  p.status_recusado = 0
                     AND a.inativo = 0 
                     AND  p.cod_local = :cod_local
                     ORDER BY p.id_proposta DESC
                     LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'pago':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                 p.status_proposta,p.status_recusado,
                 o.nome AS nome_praca
                 FROM propostas AS p
                 INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                 INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                 WHERE p.status_proposta = 10
                 AND  p.status_recusado = 0
                 AND a.inativo = 0 
                 AND  p.cod_local = :cod_local
                 ORDER BY p.id_proposta DESC
                 LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'recusado':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE p.status_recusado = 1
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;
        }

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    //Retorna as proposta quando pesquisada pelo input Pesquisa
    public function propostaPesquisa($limite, $offset)
    {
        $query = "SELECT a.cod_local, a.cod_corretor, a.nome AS nome_associado,a.cpf, a.inativo,
        o.nome AS nome_praca,
        p.id_proposta, p.num_proposta,p.data_proposta, p.status_proposta, p.status_recusado
        FROM propostas AS p
        LEFT JOIN associados AS a ON (a.id_associado = p.id_associado)
        INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
        INNER JOIN usuarios AS u ON (u.id_usuario = a.id_usuario)
        WHERE a.inativo = 0
        AND (a.nome LIKE :nome
        OR a.cpf LIKE :cpf
        OR p.num_proposta LIKE :num_proposta)
        ORDER BY id_proposta DESC
        LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':nome', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->bindValue(':cpf', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->bindValue(':num_proposta', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    //PROPOSTAS DOS CORRETORES
    public function pegarPropostaInicioCorretor($limite, $offset)
    {
        $query = "SELECT 
        a.cod_local, a.cod_corretor, a.nome AS nome_associado, a.inativo,
        o.nome AS nome_praca,
        p.id_proposta, p.num_proposta,p.data_proposta, p.status_proposta, p.status_assinatura,
        p.status_recusado, p.status_refin
        FROM propostas AS p
        LEFT JOIN associados AS a ON (a.id_associado = p.id_associado)
        INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
        INNER JOIN usuarios AS u ON (u.id_usuario = a.id_usuario)
        WHERE (a.cod_corretor = :cod_corretor 
        OR a.id_usuario = :id_usuario)
        AND a.inativo = 0
        ORDER BY p.data_proposta DESC
        LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    //Retona as propostas filtradas nos select
    public function propostaFiltroPracaCorretor($limite, $offset)
    {
        $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta, 
                p.status_proposta,p.status_recusado, a.inativo,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE (a.cod_corretor = :cod_corretor
                AND  p.cod_local = :cod_local)
                AND a.inativo = 0
                ORDER BY id_proposta DESC
                LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    //Filtra situação da proposta
    public function propostaFiltroSituacaoCorretor($limite, $offset)
    {
        switch ($this->__get('situacao')) {

            case 'andamento':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND p.status_proposta = 1
                AND p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'analise':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND p.status_proposta = 2
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'conferido':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                    p.status_proposta,p.status_recusado,
                    o.nome AS nome_praca
                    FROM propostas AS p
                    INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                    INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                    WHERE a.cod_corretor = :cod_corretor
                    AND p.status_proposta = 5
                    AND  p.status_recusado = 0
                    AND a.inativo = 0 
                    ORDER BY p.id_proposta DESC
                    LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'pendente':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND (p.status_proposta = 3
                OR p.status_proposta = 4)
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'aguardando_assinatura':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                    p.status_proposta,p.status_recusado,
                    o.nome AS nome_praca
                    FROM propostas AS p
                    INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                    INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                    WHERE a.cod_corretor = :cod_corretor
                    AND p.status_proposta = 6
                    AND  p.status_recusado = 0
                    AND a.inativo = 0 
                    ORDER BY p.id_proposta DESC
                    LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'assinado':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                        p.status_proposta,p.status_recusado,
                        o.nome AS nome_praca
                        FROM propostas AS p
                        INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                        INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                        WHERE a.cod_corretor = :cod_corretor
                        AND p.status_proposta = 7
                        AND  p.status_recusado = 0
                        AND a.inativo = 0 
                        ORDER BY p.id_proposta DESC
                        LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'ccb_enviada':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND p.status_proposta = 8
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'aguardando_pagamento':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                       p.status_proposta,p.status_recusado,
                       o.nome AS nome_praca
                       FROM propostas AS p
                       INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                       INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                       WHERE a.cod_corretor = :cod_corretor
                       AND p.status_proposta = 9
                       AND  p.status_recusado = 0
                       AND a.inativo = 0 
                       ORDER BY p.id_proposta DESC
                       LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'pago':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                   p.status_proposta,p.status_recusado,
                   o.nome AS nome_praca
                   FROM propostas AS p
                   INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                   INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                   WHERE a.cod_corretor = :cod_corretor
                   AND p.status_proposta = 10
                   AND  p.status_recusado = 0
                   AND a.inativo = 0 
                   ORDER BY p.id_proposta DESC
                   LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'recusado':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND p.status_recusado = 1
                AND a.inativo = 0 
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;
        }

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    //Filtra situação da proposta com o cod_local
    public function propostaFiltroPracaSituacaoCorretor($limite, $offset)
    {
        switch ($this->__get('situacao')) {

            case 'andamento':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
            p.status_proposta,p.status_recusado,
            o.nome AS nome_praca
            FROM propostas AS p
            INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
            INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
            WHERE a.cod_corretor = :cod_corretor
            AND p.status_proposta = 1
            AND  p.status_recusado = 0
            AND a.inativo = 0 
            AND  p.cod_local = :cod_local
            ORDER BY p.id_proposta DESC
            LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'analise':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND (p.status_proposta = 2
                OR p.status_proposta = 5)
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'conferido':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                    p.status_proposta,p.status_recusado,
                    o.nome AS nome_praca
                    FROM propostas AS p
                    INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                    INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                    WHERE a.cod_corretor = :cod_corretor
                    AND p.status_proposta = 5
                    AND  p.status_recusado = 0
                    AND a.inativo = 0 
                    AND  p.cod_local = :cod_local
                    ORDER BY p.id_proposta DESC
                    LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'pendente':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND (p.status_proposta = 3
                OR p.status_proposta = 4)
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'aguardando_assinatura':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                        p.status_proposta,p.status_recusado,
                        o.nome AS nome_praca
                        FROM propostas AS p
                        INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                        INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                        WHERE a.cod_corretor = :cod_corretor
                        AND p.status_proposta = 6
                        AND  p.status_recusado = 0
                        AND a.inativo = 0 
                        AND  p.cod_local = :cod_local
                        ORDER BY p.id_proposta DESC
                        LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'assinado':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                            p.status_proposta,p.status_recusado,
                            o.nome AS nome_praca
                            FROM propostas AS p
                            INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                            INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                            WHERE a.cod_corretor = :cod_corretor
                            AND p.status_proposta = 7
                            AND  p.status_recusado = 0
                            AND a.inativo = 0 
                            AND  p.cod_local = :cod_local
                            ORDER BY p.id_proposta DESC
                            LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'ccb_enviada':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND p.status_proposta = 8
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'aguardando_pagamento':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                    p.status_proposta,p.status_recusado,
                    o.nome AS nome_praca
                    FROM propostas AS p
                    INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                    INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                    WHERE a.cod_corretor = :cod_corretor
                    AND p.status_proposta = 9
                    AND  p.status_recusado = 0
                    AND a.inativo = 0 
                    AND  p.cod_local = :cod_local
                    ORDER BY p.id_proposta DESC
                    LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'pago':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND p.status_proposta = 10
                AND  p.status_recusado = 0
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'recusado':
                $query = "SELECT p.id_proposta, p.cod_local, p.num_proposta, p.cod_corretor, a.nome AS nome_associado, p.data_proposta,
                p.status_proposta,p.status_recusado,
                o.nome AS nome_praca
                FROM propostas AS p
                INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
                INNER JOIN associados AS a ON (a.id_associado = p.id_associado)
                WHERE a.cod_corretor = :cod_corretor
                AND p.status_recusado = 1
                AND a.inativo = 0 
                AND  p.cod_local = :cod_local
                ORDER BY p.id_proposta DESC
                LIMIT :limite OFFSET :offset";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
                $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;
        }

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    //Retorna as proposta quando pesquisada pelo input Pesquisa  
    public function propostaPesquisaCorretor($limite, $offset)
    {
        $query = "SELECT a.cod_local, a.cod_corretor, a.nome AS nome_associado,a.cpf, a.inativo,
        o.nome AS nome_praca,
        p.id_proposta, p.num_proposta,p.data_proposta, p.status_proposta, p.status_recusado
        FROM propostas AS p
        LEFT JOIN associados AS a ON (a.id_associado = p.id_associado)
        INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
        INNER JOIN usuarios AS u ON (u.id_usuario = a.id_usuario)
        WHERE a.inativo = 0
        AND a.cod_corretor = :cod_corretor
        AND (a.nome LIKE :nome
        OR a.cpf LIKE :cpf
        OR p.num_proposta LIKE :num_proposta)
        ORDER BY id_proposta DESC
        LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limite', $limite, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':nome', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->bindValue(':cpf', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->bindValue(':num_proposta', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }
    public function recusarProposta()
    {

        $query = "UPDATE propostas
        SET status_recusado = 1,
        recusado_motivo = :recusado_motivo
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':recusado_motivo', $this->__get('recusado_motivo'));
        $stmt->bindValue(':id_proposta', $this->__get('id_proposta'));
        return $stmt->execute();
    }

    //Verifica o status da proposta
    public function statusProposta(int $id_proposta)
    {
        $query = "SELECT status_proposta
        FROM propostas
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }

    public function mudarStatusProposta($coluna, $valor, $id_proposta)
    {
        $query = "UPDATE propostas
        SET $coluna = :valor
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta, \PDO::PARAM_INT);
        $stmt->bindValue(':valor', $valor, \PDO::PARAM_INT);
        $stmt->execute();

        return $this;
    }

    //verifica se o cod_corretor é igual ao da sessão para o corretor olhar a proposta criado por ele.
    public function verificaCodCorretor(int $id_proposta)
    {
        $query = "SELECT cod_corretor
            FROM propostas
            WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $id_proposta, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }

    public function tipoAssinatura($id_proposta, $tipo_assinatura)
    {
        $query = "UPDATE propostas 
        SET tipo_assinatura = :tipo_assinatura
        WHERE id_proposta = :id_proposta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':tipo_assinatura', $tipo_assinatura);
        $stmt->bindValue(':id_proposta', $id_proposta);
        $stmt->execute();
        return $this;
    }

    //Pega o ultimo id cadastrado
    public function getlastInsertIdProposta()
    {
        return $this->id_proposta;
    }

    /**
     * Retorna o status da proposta em /inicio
     * Método executado dentro de pegarPropostaInicio()
     */
    public function statusPropostas($proposta)
    {
        // Verifica se a data da proposta é maior que '2024-01-01'
        if ($proposta['data_proposta'] <= '2024-01-01') {
            return "<span></span>";
        }

        // Verifica se o status foi recusado
        if ($proposta['status_recusado'] == 1) {
            return $this->statusPropostasRecusado();
        }

        // Usa switch para verificar o status da proposta
        switch ($proposta['status_proposta']) {
            case 1:
                return $this->statusPropostasEmAndamento();
            case 2:
                return $this->statusPropostasEmAnalise();
            case 3:
                return $this->statusPropostasPendente();
            case 4:
                return $this->statusPropostasPendenteResolvida();
            case 5:
                return $this->statusPropostasConferido();
            case 6:
                return $this->statusPropostasAguardandoAssinatura();
            case 7:
                return $this->statusPropostasAssinado();
            case 8:
                return $this->statusPropostasAguardandoCCB();
            case 9:
                return $this->statusPropostasAguardandoPagamento();
            case 10:
                return $this->statusPropostaPaga();
            default:
                return "<span></span>";
        }
    }
    public function statusPropostasEmAndamento()
    {
        return "<span class='badge' style='background-color: #DBEAFE; color: #1E40AF; border: 1px solid #DBEAFE'>
                    <i class='fas fa-spinner mr-1'></i>
                        EM ANDAMENTO
                </span>";
    }
    public function statusPropostasEmAnalise()
    {
        return "<span class='badge' style='background-color: #F3E8FF; color: #8613e4; border: 1px solid #F3E8FF'>
                    <i class='fas fa-file-lines mr-1' style='font-size: 14px;'></i>
                        EM ANALISE
                </span>";
    }
    public function statusPropostasPendente()
    {
        return "<span class='badge' style='background-color: #FEF3C7; color: #da5e13; border: 1px solid #FEF3C7'>
                    <i class='fas fa-circle-exclamation mr-1' style='font-size: 14px;'></i>
                        PENDENTE
                </span>";
    }
    public function statusPropostasPendenteResolvida()
    {
        return "<span class='badge' style='background-color: #FFEDD5; color: #9A3412; border: 1px solid #FFEDD5'>
                            <i class='fas fa-circle-check mr-1' style='font-size: 14px;'></i>
                        PENDENCIA RESOLVIDA
                </span>";
    }
    public function statusPropostasConferido()
    {
        return "<span class='badge'style='background-color: #CCFBF1; color: #115E59; border: 1px solid #CCFBF1'>
                    <i class='fas fa-clipboard-check mr-1' style='font-size: 14px;'></i>
                        CONFERIDO
                </span>";
    }
    public function statusPropostasAguardandoAssinatura()
    {
        return "<span class='badge' style='background-color: #E0E7FF; color: #3730A3; border: 1px solid #E0E7FF'>
                    <i class='fas fa-file-signature mr-2' style='font-size: 14px;'></i>
                        AGUARDANDO ASSINATURA
                </span>";
    }
    public function statusPropostasAssinado()
    {
        return "<span class='badge' style='background-color: #E0F2FE; color: #075985; border: 1px solid #E0F2FE'>
                    <i class='fas fa-file-signature mr-2' style='font-size: 14px;'></i>
                        ASSINADO
                </span>";
    }
    public function statusPropostasAguardandoCCB()
    {
        return "<span class='badge' style='background-color:#e7e7e7; color: #454545; border: 1px solid #e7e7e7'>
                    <i class='fas fa-file-signature mr-2' style='font-size: 14px;'></i>
                        CCB ENVIADA
                </span>";
    }
    public function statusPropostasAguardandoPagamento()
    {
        return "<span class='badge' style='background-color: #e5ff95; color: #3d580f; border: 1px solid #e5ff95'>
                    <i class='fas fa-dollar-sign mr-2' style='font-size: 14px;'></i>
                        AGUARDANDO PAGAMENTO
                </span>";
    }
    public function statusPropostaPaga()
    {
        return "<span class='badge' style='background-color: #D1FAE5; color: #065F46; border: 1px solid #D1FAE5'>
                    <i class='fas fa-dollar-sign mr-2' style='font-size: 14px;'></i>
                        PAGA
                </span>";
    }
    public function statusPropostasRecusado()
    {
        return "<span class='badge' style='background-color: #FEE2E2; color: #991B1B; border: 1px solid #FEE2E2'>
                    <i class='fas fa-times mr-1'></i>
                        RECUSADO
                 </span>";
    }
}
