<?php

namespace App\Models;

use MF\Model\Model;

class Acompanhamento extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function getPropostas($limit, $offset)
    {
        $query = "SELECT 
            a.nome,
            a.cpf,
            ac.id_conferencia,
            ac.id_conferente,
            ac.id_usuario,
            ac.status_proposta as status_proposta_pc,
            DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
            u.nome AS nome_conferente,
            u.nivel,
            o.nome AS praca_nome,
            p.id_proposta,
            p.num_proposta,
            p.cod_corretor,
            p.tipo_proposta,
            p.valor_mensalidade,
            DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
            p.status_proposta as status_proposta_p,
            p.status_assinatura,
            p.status_recusado,
            p.valor_financiado,
            p.valor_liberado,
            p.taxa
        FROM propostas AS p
        INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
        INNER JOIN origem AS o ON a.cod_local = o.cod_local
        RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
        LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
        WHERE ac.data_status = (
            SELECT MAX(ac2.data_status)
            FROM acompanhamento AS ac2
            WHERE ac2.id_proposta = p.id_proposta)
        ORDER BY ac.id_proposta DESC
        LIMIT $limit
        OFFSET $offset";
        $resultado = $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);

        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }
    public function getFiltroPesquisa($limit, $offset)
    {
        $query = "SELECT 
            a.nome,
            a.cpf,
            ac.id_conferencia,
            ac.id_conferente,
            ac.id_usuario,
            ac.status_proposta as status_proposta_pc,
            DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
            u.nome AS nome_conferente,
            u.nivel,
            o.nome AS praca_nome,
            p.id_proposta,
            p.num_proposta,
            p.cod_corretor,
            p.tipo_proposta,
            p.valor_mensalidade,
            DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
            p.status_proposta as status_proposta_p,
            p.status_assinatura,
            p.status_recusado,
            p.valor_financiado,
            p.valor_liberado,
            p.taxa
        FROM propostas AS p
        INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
        INNER JOIN origem AS o ON a.cod_local = o.cod_local
        RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
        LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
        WHERE ac.data_status = (
            SELECT MAX(ac2.data_status)
            FROM acompanhamento AS ac2
            WHERE ac2.id_proposta = p.id_proposta
        )
        AND (a.nome LIKE :nome
        OR a.cpf LIKE :cpf
        OR p.num_proposta LIKE :num_proposta)
        ORDER BY ac.id_proposta DESC
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':nome', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->bindValue(':cpf', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->bindValue(':num_proposta', '%' . $this->__get('pesquisa') . '%', \PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostas($propostas);
        });

        return $resultado;
    }

    public function getFiltroSituacao($limit, $offset)
    {
        switch ($this->__get('situacao')):
            case 'andamento':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_proposta = 1
                AND p.status_recusado = 0)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'analise':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_proposta = 2
                AND p.status_recusado = 0)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'conferido':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_proposta = 5
                AND p.status_recusado = 0)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'pendente':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_proposta = 3
                AND p.status_recusado = 0)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'aguardando_assinatura':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_proposta = 4
                AND p.status_recusado = 0)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'assinado':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_proposta = 7
                AND p.status_recusado = 0)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'recusado':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_recusado = 1)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'ccb_enviada':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_proposta = 8
                AND p.status_recusado = 0)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;
                case 'aguardando_pagamento':
                    $query = "SELECT 
                    a.nome,
                    a.cpf,
                    ac.id_conferencia,
                    ac.id_conferente,
                    ac.id_usuario,
                    ac.status_proposta as status_proposta_pc,
                    DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                    u.nome AS nome_conferente,
                    u.nivel,
                    o.nome AS praca_nome,
                    p.id_proposta,
                    p.num_proposta,
                    p.cod_corretor,
                    p.tipo_proposta,
                    p.valor_mensalidade,
                    DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                    p.status_proposta as status_proposta_p,
                    p.status_assinatura,
                    p.status_recusado,
                    p.valor_financiado,
                    p.valor_liberado,
                    p.taxa
                    FROM propostas AS p
                    INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                    INNER JOIN origem AS o ON a.cod_local = o.cod_local
                    RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                    LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                    WHERE ac.data_status = (
                        SELECT MAX(ac2.data_status)
                        FROM acompanhamento AS ac2
                        WHERE ac2.id_proposta = p.id_proposta
                        )
                    AND (p.status_proposta = 9
                    AND p.status_recusado = 0)
                    ORDER BY ac.id_proposta DESC
                    LIMIT :limit OFFSET :offset";
    
                    $stmt = $this->db->prepare($query);
    
                    $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                    $stmt->execute();
                    $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
                    array_walk($resultado, function (&$propostas) {
                        $propostas['status'] = $this->statusPropostas($propostas);
                    });
    
                    return $resultado;
                    break;

            case 'pago':
                $query = "SELECT 
                    a.nome,
                    a.cpf,
                    ac.id_conferencia,
                    ac.id_conferente,
                    ac.id_usuario,
                    ac.status_proposta as status_proposta_pc,
                    DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                    u.nome AS nome_conferente,
                    u.nivel,
                    o.nome AS praca_nome,
                    p.id_proposta,
                    p.num_proposta,
                    p.cod_corretor,
                    p.tipo_proposta,
                    p.valor_mensalidade,
                    DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                    p.status_proposta as status_proposta_p,
                    p.status_assinatura,
                    p.status_recusado,
                    p.valor_financiado,
                    p.valor_liberado,
                    p.taxa
                    FROM propostas AS p
                    INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                    INNER JOIN origem AS o ON a.cod_local = o.cod_local
                    RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                    LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                    WHERE ac.data_status = (
                        SELECT MAX(ac2.data_status)
                        FROM acompanhamento AS ac2
                        WHERE ac2.id_proposta = p.id_proposta
                        )
                    AND (p.status_proposta = 10
                    AND p.status_recusado = 0)
                    ORDER BY ac.id_proposta DESC
                    LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

        endswitch;
    }


    public function getFiltroClickSign($limit, $offset)
    {
        switch ($this->__get('clicksign')):
            case 'nao_enviado':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_assinatura = 0)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'aguardando_envio':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_assinatura = 1)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'aguardando_assinatura':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_assinatura = 2
                AND p.status_proposta = 6)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;

            case 'assinado':
                $query = "SELECT 
                a.nome,
                a.cpf,
                ac.id_conferencia,
                ac.id_conferente,
                ac.id_usuario,
                ac.status_proposta as status_proposta_pc,
                DATE_FORMAT(ac.data_status, '%H:%i') AS hora_status,
                u.nome AS nome_conferente,
                u.nivel,
                o.nome AS praca_nome,
                p.id_proposta,
                p.num_proposta,
                p.cod_corretor,
                p.tipo_proposta,
                p.valor_mensalidade,
                DATE_FORMAT(p.data_proposta,'%d/%m/%Y') AS data_proposta,
                p.status_proposta as status_proposta_p,
                p.status_assinatura,
                p.status_recusado,
                p.valor_financiado,
                p.valor_liberado,
                p.taxa
                FROM propostas AS p
                INNER JOIN associados AS a ON a.id_associado = p.id_associado AND a.cod_local = p.cod_local
                INNER JOIN origem AS o ON a.cod_local = o.cod_local
                RIGHT JOIN acompanhamento AS ac ON p.id_proposta = ac.id_proposta
                LEFT JOIN usuarios AS u ON u.id_usuario = ac.id_conferente
                WHERE ac.data_status = (
                    SELECT MAX(ac2.data_status)
                    FROM acompanhamento AS ac2
                    WHERE ac2.id_proposta = p.id_proposta
                    )
                AND (p.status_assinatura = 2
                AND p.status_proposta >= 7)
                ORDER BY ac.id_proposta DESC
                LIMIT :limit OFFSET :offset";

                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                array_walk($resultado, function (&$propostas) {
                    $propostas['status'] = $this->statusPropostas($propostas);
                });

                return $resultado;
                break;
        endswitch;
    }

    public function contaPropostasCompanhamento()
    {

        $query = "SELECT COUNT(*) AS total
        FROM propostas AS p
        LEFT JOIN acompanhamento AS c ON (c.id_proposta = p.id_proposta)
        WHERE c.data_status = (
            SELECT MAX(c2.data_status)
            FROM acompanhamento AS c2
            WHERE c2.id_proposta = p.id_proposta)";

        $resultado = $this->db->query($query)->fetch(\PDO::FETCH_ASSOC);

        return $resultado['total'];
    }

    public function statusPropostas($proposta)
    {
        $proposta_data = $proposta['data_proposta'];
        if ($proposta_data <= '01-01-2024') {
            return "<span></span>";
        }

        if ($proposta['status_recusado'] == 1) {
            return $this->statusPropostasRecusado();
        }

        $status = $proposta['status_proposta_p'];

        switch ($status) {
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
                return "<span>Sem status</span>";
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
