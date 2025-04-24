<?php

namespace App\Models;

use MF\Model\Model;

class Consulta extends Model
{
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    //Mostra as consultas em /consultas
    public function getTodasConsultas()
    {
        $query = "SELECT c.id_consulta,u.cod_corretor, c.praca, c.status_consulta, c.data_criado
                    FROM consultas AS c
                    INNER JOIN usuarios AS u ON u.id_usuario = c.id_usuario
                    ORDER BY c.id_consulta DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    //Mostra a consulta do corretor.
    public function getConsultaCorretor()
    {
        $query = "SELECT *
        FROM consultas
        WHERE id_usuario = :id_usuario
        ORDER BY id_consulta DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    //Mostra a consulta em /consulta?codigo=id 
    public function showConsultaId()
    {
        $query = "SELECT c.*, cr.*
                FROM consultas AS c
                LEFT JOIN consultas_respostas AS cr ON cr.id_consulta = c.id_consulta
                WHERE c.id_consulta = :id_consulta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_consulta', $this->__get('id_consulta'));
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    public function postConsulta()
    {
        $query = "INSERT INTO consultas
        (id_usuario, email, praca, nome1, cpf1, matricula1, data_nasc1, nome2, cpf2, matricula2, data_nasc2, nome3, cpf3, matricula3, data_nasc3, nome4, cpf4, matricula4, data_nasc4, nome5, cpf5, matricula5, data_nasc5, nome6, cpf6, matricula6, data_nasc6, nome7, cpf7, matricula7, data_nasc7, nome8, cpf8, matricula8, data_nasc8, nome9, cpf9, matricula9, data_nasc9, nome10, cpf10, matricula10, data_nasc10, data_criado)
        VALUES
        (:id_usuario, :email, :praca, :nome1, :cpf1, :matricula1, :data_nasc1, :nome2, :cpf2, :matricula2, :data_nasc2, :nome3, :cpf3, :matricula3, :data_nasc3, :nome4, :cpf4, :matricula4, :data_nasc4, :nome5, :cpf5, :matricula5, :data_nasc5, :nome6, :cpf6, :matricula6, :data_nasc6, :nome7, :cpf7, :matricula7, :data_nasc7, :nome8, :cpf8, :matricula8, :data_nasc8, :nome9, :cpf9, :matricula9, :data_nasc9, :nome10, :cpf10, :matricula10, :data_nasc10, :data_criado)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':praca', $this->__get('praca'));
        $stmt->bindValue(':data_criado', $this->__get('data_criado'));

        for ($i = 1; $i <= 10; $i++) {
            $nome = $this->__get('nome' . $i);
            $cpf = $this->__get('cpf' . $i);
            $matricula = $this->__get('matricula' . $i);
            $data_nasc = $this->__get('data_nasc' . $i);

            // Verifica se a propriedade existe antes de fazer o bind
            if ($nome !== '') {
                $stmt->bindValue(':nome' . $i, $nome);
            } else {
                $stmt->bindValue(':nome' . $i, null); // ou um valor padrão
            }

            if ($cpf !== '') {
                $stmt->bindValue(':cpf' . $i, $cpf);
            } else {
                $stmt->bindValue(':cpf' . $i, null); // ou um valor padrão
            }

            if ($matricula !== '') {
                $stmt->bindValue(':matricula' . $i, $matricula);
            } else {
                $stmt->bindValue(':matricula' . $i, null); // ou um valor padrão
            }

            if ($data_nasc !== '') {
                $stmt->bindValue(':data_nasc' . $i, $data_nasc);
            } else {
                $stmt->bindValue(':data_nasc' . $i, null); // ou um valor padrão
            }
        }

        $stmt->execute();

        return $this;
    }

    //Responde consulta
    public function postRespostaConsulta()
    {
        $query = "INSERT INTO consultas_respostas (id_consulta, id_usuario,	resposta1, resposta2, resposta3, resposta4, resposta5, resposta6, resposta7, resposta8, resposta9, resposta10, data_resposta) VALUES (:id_consulta, :id_usuario, :resposta1, :resposta2, :resposta3, :resposta4, :resposta5, :resposta6, :resposta7, :resposta8, :resposta9, :resposta10, :data_resposta)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_consulta', $this->__get('id_consulta'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':resposta1', $this->__get('resposta1'));
        $stmt->bindValue(':resposta2', $this->__get('resposta2'));
        $stmt->bindValue(':resposta3', $this->__get('resposta3'));
        $stmt->bindValue(':resposta4', $this->__get('resposta4'));
        $stmt->bindValue(':resposta5', $this->__get('resposta5'));
        $stmt->bindValue(':resposta6', $this->__get('resposta6'));
        $stmt->bindValue(':resposta7', $this->__get('resposta7'));
        $stmt->bindValue(':resposta8', $this->__get('resposta8'));
        $stmt->bindValue(':resposta9', $this->__get('resposta9'));
        $stmt->bindValue(':resposta10', $this->__get('resposta10'));
        $stmt->bindValue(':data_resposta', $this->__get('data_resposta'));
        $stmt->execute();

        return $this;
    }

    //Muda o status da consulta
    public function mudarStatusConsulta($coluna, $valor, $id_consulta)
    {
        $query = "UPDATE consultas
            SET $coluna = :valor
            WHERE id_consulta = :id_consulta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_consulta', $id_consulta, \PDO::PARAM_INT);
        $stmt->bindValue(':valor', $valor, \PDO::PARAM_INT);
        $stmt->execute();

        return $this;
    }

    //Verifica o status da proposta
    public function statusConsulta(int $id_consulta)
    {
        $query = "SELECT status_consulta
            FROM consultas
            WHERE id_consulta = :id_consulta";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_consulta', $id_consulta, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }
}
