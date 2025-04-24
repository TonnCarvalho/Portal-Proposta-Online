<?php

namespace App\Helper;

use MF\Controller\Action;
use MF\Model\Container;

class Contadores extends Action
{
    public static function propostaAndamentoContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoAndamento = $contadoresModel->propostaAndamentoContador();

        return $resultadoAndamento;
    }

    public static function propostaAnaliseContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoAnalise = $contadoresModel->propostaAnaliseContador();

        return $resultadoAnalise;
    }

    public static function propostaPendenteContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoPendente = $contadoresModel->propostaPendenteContador();

        return $resultadoPendente;
    }

    public static function propostaPendenciaResolvidaContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoPendenciaResolvida = $contadoresModel->propostaPendenciaResolvidaContador();

        return $resultadoPendenciaResolvida;
    }

    public static function propostaConferidoContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoConferido = $contadoresModel->propostaConferidoContador();

        return $resultadoConferido;
    }

    public static function propostaAguardandoAssinaturaContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoAguardandoAssinatura = $contadoresModel->propostaAguardandoAssinaturaContador();

        return $resultadoAguardandoAssinatura;
    }

    public static function propostaAssinadoContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoAssinado = $contadoresModel->propostaAssinadoContador();

        return $resultadoAssinado;
    }

    public static function propostaAguardandoCCBContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoAguardandoCCB = $contadoresModel->propostaAguardandoCCBContador();

        return $resultadoAguardandoCCB;
    }

    public static function propostaPagaContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoPago = $contadoresModel->propostaPagaContador();

        return $resultadoPago;
    }

    public static function propostaRecusadoContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoReprovado = $contadoresModel->propostaRecusadoContador();

        return $resultadoReprovado;
    }

    public static function ClickSignContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoClickSign = $contadoresModel->clickSignContador();

        return $resultadoClickSign;
    }
    public static function ConsultaContador()
    {
        $contadoresModel = Container::getModel('Contadores');
        $resultadoConsulta = $contadoresModel->consultaContador();

        return $resultadoConsulta;
    }



}
