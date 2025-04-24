<?php

use App\Helper\Contadores;
?>
<div class="row justify-content-around ">
    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #DBEAFE; color: #1E40AF">
            <i class="fas fa-spinner"></i>
            Em andamento
            <span class="info-box-number">
                <?= Contadores::propostaAndamentoContador() ?>
            </span>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #F3E8FF; color: #8613e4">
            <i class="fas fa-file-lines"></i>
            Em analise
            <span class="info-box-number">
                <?= Contadores::propostaAnaliseContador() ?>
            </span>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #FEF3C7; color: #da5e13">
            <i class="fas fa-circle-exclamation"></i>
            Pendente
            <span class="info-box-number">
                <?= Contadores::propostaPendenteContador() ?>
            </span>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #FFEDD5; color: #9A3412">
            <i class="fas fa-circle-check"></i>
            Pendencia Resolvida
            <span class="info-box-number">
                <?= Contadores::propostaPendenciaResolvidaContador() ?>
            </span>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #CCFBF1; color: #115E59">
            <i class="fas fa-clipboard-check"></i>
            Conferido
            <span class="info-box-number">
                <?= Contadores::propostaConferidoContador() ?>
            </span>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #E0E7FF; color: #3730A3">
            <i class="fas fa-file-signature"></i>
            <span>
                Aguardando Assinatura
            </span>
            <span class="info-box-number">
                <?= Contadores::propostaAguardandoAssinaturaContador() ?>
            </span>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #E0F2FE; color: #075985">
            <i class="fas fa-file-signature"></i>
            Assinado
            <span class="info-box-number">
                <?= Contadores::propostaAssinadoContador() ?>
            </span>
        </div>
    </div>
    
    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #FEE2E2; color: #991B1B">
            <i class="fas fa-times"></i>
            Recusado
            <span class="info-box-number">
                <?= Contadores::propostaRecusadoContador() ?>
            </span>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="info-box flex-column align-items-center" style="background-color: #D1FAE5; color: #065F46">
            <i class="fas fa-file-circle-check"></i>
            Aguardando CCB
            <span class="info-box-number">
                <?= Contadores::propostaAguardandoCCBContador() ?>
            </span>
        </div>
    </div>

</div>