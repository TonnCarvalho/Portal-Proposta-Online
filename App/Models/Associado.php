<?php

namespace App\Models;

use MF\Model\Model;

class Associado extends Model
{
    private $id_associado;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    //Busca associado pelo cpf na primeira etapa do cadastro e mostra os dados na segunda etapa.
    public function getAssociadoCadastroProposta($cpfCadastro)
    {
        $query = "SELECT a.id_usuario, a.cod_corretor, a.nome, a.cpf, a.mat, a.rg, a.orgao_exp, a.email,a.cod_local, a.data_nasc, a.cod_orgao, a.setor, a.cargo,a.ocupacao, a.data_admissao, a.nat, a.nome_mae, a.nome_pai, a.endereco, a.bairro, a.municipio, a.uf, a.cep, a.endereco, a.estado_civil, a.tel, a.cel, a.sexo, a.banco, a.agencia, a.conta, a.banco_pagamento, a.agencia_pagamento, a.conta_pagamento, a.tipo_bancario 
        FROM associados AS a
        WHERE a.cpf = :cpf
        AND a.inativo = 0";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', $cpfCadastro, \PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Verifica se já existe registro do associado no cod_local com o corretor
    public function pegaCpfAssociadoCodCorretor($cpf, $cod_corretor, $cod_local)
    {
        $query = "SELECT a.cpf, a.cod_corretor
        FROM associados AS a
        WHERE a.cpf = :cpf
        AND a.cod_corretor = :cod_corretor
        AND a.cod_local = :cod_local";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', $cpf);
        $stmt->bindValue(':cod_corretor', $cod_corretor);
        $stmt->bindValue(':cod_local', $cod_local);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Verifica se a matricula é diferente. (RETORNA A MATRICULA)
    public function verificaMatricula($cpf, $cod_corretor, $cod_local, $matricula)
    {
        $query = "SELECT mat
                    FROM associados
                    WHERE cpf = :cpf
                    AND cod_corretor = :cod_corretor
                    AND cod_local = :cod_local
                    AND mat = :matricula";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', $cpf);
        $stmt->bindValue(':cod_corretor', $cod_corretor);
        $stmt->bindValue(':cod_local', $cod_local);
        $stmt->bindValue(':matricula', $matricula);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Cadastra o associado
    public function cadastrarAssociado()
    {
        $query = "INSERT INTO associados (id_usuario, cod_local, cod_corretor, nome, cpf, rg, orgao_exp, data_nasc, nat, sexo, estado_civil, tel, cel, email, nome_pai, nome_mae, mat, cod_orgao, setor, cargo, ocupacao, data_admissao, cep, uf, municipio, bairro, endereco, banco, conta, agencia, banco_pagamento, conta_pagamento, agencia_pagamento,  tipo_bancario ) VALUES (:id_usuario, :cod_local, :cod_corretor, :nome, :cpf, :rg, :orgao_exp, :data_nasc, :nat, :sexo, :estado_civil, :tel, :cel, :email, :nome_pai, :nome_mae, :mat, :cod_orgao, :setor, :cargo, :ocupacao, :data_admissao, :cep, :uf, :municipio, :bairro, :endereco, :banco, :conta, :agencia, :banco_pagamento, :conta_pagamento, :agencia_pagamento, :tipo_bancario )";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':nome', $this->__get('nome'), \PDO::PARAM_STR);
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':rg', $this->__get('rg'));
        $stmt->bindValue(':orgao_exp', $this->__get('orgao_exp'));
        $stmt->bindValue(':data_nasc', $this->__get('data_nasc'));
        $stmt->bindValue(':nat', $this->__get('nat'));
        $stmt->bindValue(':sexo', $this->__get('sexo'));
        $stmt->bindValue(':estado_civil', $this->__get('estado_civil'));
        $stmt->bindValue(':tel', $this->__get('tel'));
        $stmt->bindValue(':cel', $this->__get('cel'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':nome_pai', $this->__get('nome_pai'));
        $stmt->bindValue(':nome_mae', $this->__get('nome_mae'));
        $stmt->bindValue(':mat', $this->__get('mat'));
        $stmt->bindValue(':cod_orgao', $this->__get('cod_orgao'));
        $stmt->bindValue(':setor', $this->__get('setor'));
        $stmt->bindValue(':cargo', $this->__get('cargo'));
        $stmt->bindValue(':ocupacao', $this->__get('ocupacao'));
        $stmt->bindValue(':data_admissao', $this->__get('data_admissao'));
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':municipio', $this->__get('municipio'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':banco', $this->__get('banco'));
        $stmt->bindValue(':conta', $this->__get('conta'));
        $stmt->bindValue(':agencia', $this->__get('agencia'));
        $stmt->bindValue(':banco_pagamento', $this->__get('banco_pagamento'));
        $stmt->bindValue(':conta_pagamento', $this->__get('conta_pagamento'));
        $stmt->bindValue(':agencia_pagamento', $this->__get('agencia_pagamento'));
        $stmt->bindValue(':tipo_bancario', $this->__get('tipo_bancario'));

        $stmt->execute();

        $this->id_associado = $this->db->lastInsertId();

        return $this;
    }

    //Atualiza a proposta do associado.
    public function atualizarAssociadoProposta()
    {
        $query = "UPDATE associados
        SET
        id_usuario = :id_usuario,
        cod_local = :cod_local,
        nome = :nome,
        rg = :rg,
        orgao_exp = :orgao_exp,
        data_nasc = :data_nasc,
        nat = :nat,
        sexo = :sexo,
        estado_civil = :estado_civil,
        tel = :tel,
        cel = :cel,
        email = :email,
        nome_pai = :nome_pai,
        nome_mae = :nome_mae,
        mat = :mat,
        cod_orgao = :cod_orgao,
        setor = :setor,
        cargo = :cargo,
        ocupacao = :ocupacao,
        data_admissao = :data_admissao,
        cep = :cep,
        uf = :uf,
        municipio = :municipio,
        bairro = :bairro,
        endereco = :endereco,
        banco = :banco,
        conta = :conta,
        agencia = :agencia,
        banco_pagamento = :banco_pagamento,
        conta_pagamento = :conta_pagamento,
        agencia_pagamento = :agencia_pagamento,
        tipo_bancario  = :tipo_bancario
        WHERE id_associado = :id_associado";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_associado', $this->__get('id_associado'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':cod_local', $this->__get('cod_local'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':rg', $this->__get('rg'));
        $stmt->bindValue(':orgao_exp', $this->__get('orgao_exp'));
        $stmt->bindValue(':data_nasc', $this->__get('data_nasc'));
        $stmt->bindValue(':nat', $this->__get('nat'));
        $stmt->bindValue(':sexo', $this->__get('sexo'));
        $stmt->bindValue(':estado_civil', $this->__get('estado_civil'));
        $stmt->bindValue(':tel', $this->__get('tel'));
        $stmt->bindValue(':cel', $this->__get('cel'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':nome_pai', $this->__get('nome_pai'));
        $stmt->bindValue(':nome_mae', $this->__get('nome_mae'));
        $stmt->bindValue(':mat', $this->__get('mat'));
        $stmt->bindValue(':cod_orgao', $this->__get('cod_orgao'));
        $stmt->bindValue(':setor', $this->__get('setor'));
        $stmt->bindValue(':cargo', $this->__get('cargo'));
        $stmt->bindValue(':ocupacao', $this->__get('ocupacao'));
        $stmt->bindValue(':data_admissao', $this->__get('data_admissao'));
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':municipio', $this->__get('municipio'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':banco', $this->__get('banco'));
        $stmt->bindValue(':conta', $this->__get('conta'));
        $stmt->bindValue(':agencia', $this->__get('agencia'));
        $stmt->bindValue(':banco_pagamento', $this->__get('banco_pagamento'));
        $stmt->bindValue(':conta_pagamento', $this->__get('conta_pagamento'));
        $stmt->bindValue(':agencia_pagamento', $this->__get('agencia_pagamento'));
        $stmt->bindValue(':tipo_bancario', $this->__get('tipo_bancario'));

        $stmt->execute();

        $this->id_associado = $this->db->lastInsertId();
        return $this;
    }

    //Pega o ID do associado para cadastra os valores da proposta.
    public function getIdAssociadoCorretor()
    {
        $query = "SELECT id_associado
        FROM associados
        WHERE cpf = :cpf
        AND cod_corretor = :cod_corretor
        AND cod_local = :cod_local
        AND mat = :mat
        AND inativo = 0
        LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', $this->__get('cpf'), \PDO::PARAM_STR);
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'), \PDO::PARAM_INT);
        $stmt->bindValue(':cod_local', $this->__get('cod_local'), \PDO::PARAM_INT);
        $stmt->bindValue(':mat', $this->__get('mat'), \PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchColumn();
        return $resultado;
    }

    public function getIdAtualizarAssociado()
    {
        $query = "SELECT id_associado
                    FROM propostas
                    WHERE id_proposta = :id_proposta";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_proposta', $this->__get('id_proposta'));
        $stmt->execute();
        $resultado = $stmt->fetchColumn();
        return $resultado;
    }

    //Pega o ultimo id cadastrado
    public function getlastInsertIdCliente()
    {
        return $this->id_associado;
    }
}
