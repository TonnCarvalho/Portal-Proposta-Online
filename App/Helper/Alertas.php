<?php

namespace App\Helper;

class Alertas
{
    public static function alertaSucesso($titulo, $mensagem)
    {
        return "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h5><i class='icon fas fa-check'></i> $titulo</h5>
                    $mensagem.
                </div>";
    }
    public static function alertaErro($titulo, $mensagem)
    {
        return "<div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h5><i class='icon fas fa-ban'></i> $titulo</h5>
                    $mensagem.
                </div>";
    }
    public static function alertaRefinSucesso($titulo, $mensagem)
    {
        return "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h5><i class='icon fas fa-check'></i> $titulo</h5>
                    $mensagem.
                </div>";
    }
    public static function alertaRefinError($mensagem)
    {
        return "<div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h5><i class='icon fas fa-check'></i> Erro!</h5>
                    $mensagem.
                </div>";
    }

    public static function alertaPendencia($titulo, $mensagem)
    {
        return "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h5><i class='icon fas fa-check'></i> $titulo </h5>
                    $mensagem
                </div>";
    }

    public static function alertaPendenciaResolvida()
    {
        return "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h5><i class='icon fas fa-check'></i> Obrigado!</h5>
                    Obrigado por nos informar
                </div>";
    }
    public static function alertaPraca($cor,$titulo, $mensagem)
    {
        return "<div class='alert alert-$cor alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h5><i class='icon fas fa-check'></i> $titulo</h5>
                    $mensagem
                </div>";
    }
}
