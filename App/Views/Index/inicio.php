<?php include(__DIR__ . '/modal/situacao.php'); ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1>Inicio</h1>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title text-primary">
            <i class="far fa-file-alt"></i>
            Propostas
          </h3>
        </div>
        <div class="card-body p-0">

          <div x-data="inicioTabelaCrud" x-init="carregarPropostas">

            <?php include(__DIR__ . '/componentes/filtro.php')?>
            <div class="col-12">
              <?php
              if (isset($this->view->alerta)) {
                echo $this->view->alerta;
              }
              ?>
            </div>

            <div class="">
              <div class="table-responsive">
                <table class="table" id="tabelaPropostas">
                  <thead class="table-primary">
                    <tr>
                      <th class="">Proposta</th>
                      <th class="col-3">Associado</th>
                      <?php if ($_SESSION['nivel'] > 10): ?>
                        <th class="col-0 text-center">Corretor</th>
                      <?php endif; ?>
                      <th class="text-center">Praça</th>
                      <th class="text-center">Situação</th>
                      <th class="text-center">Data</th>
                      <?php if ($_SESSION['nivel'] > 10): ?>
                        <th class="text-center">Opções</th>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tbody>
                    <template x-for="proposta in propostas" :key="proposta.id_proposta">
                      <tr>
                        <td class="align-middle" x-text="proposta.num_proposta"></td>
                        <td class="text-uppercase align-middle">
                          <a x-html="proposta.nome_associado"
                            :href="'proposta-edita?proposta=' + proposta.id_proposta">
                          </a>
                        </td>
                        <?php if ($_SESSION['nivel'] > 10): ?>
                          <td class="text-center align-middle" x-text="proposta.cod_corretor"></td>
                        <?php endif; ?>
                        <td class="text-center align-middle" x-html="proposta.nome_praca"></td>
                        <td class="text-center align-middle" x-html="proposta.status"></td>

                        <td class="text-center align-middle" x-html="formataDataHora(proposta.data_proposta)"></td>

                        <?php if ($_SESSION['nivel'] >= 90): ?>
                          <td class="text-center align-middle">
                            <div class="dropdown">
                              <button class="btn btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item btn" data-toggle="modal" data-target="#situacao" :data-nome="proposta.nome_associado" :data-id-proposta="proposta.id_proposta" :data-status-proposta="proposta.status_proposta"
                                  :data-status-recusado="proposta.status_recusado" :data-status-assinatura="proposta.status_assinatura" :data-status-refin="proposta.status_refin">
                                  <i class="fas fa-gear text-secondary mr-1"></i>
                                  Situação
                                </a>

                              </div>
                            </div>
                          </td>
                        <?php endif ?>
                      </tr>
                    </template>
                  </tbody>
                </table>

                <div>
                  <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                      <!-- Link para a página anterior -->
                      <li class="page-item" :class="{ disabled: pagina <= 1 }">
                        <a class="page-link" href="" @click.prevent="paginaAnterior()" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>
                      <!-- Link de página atual -->
                      <template x-for="page in paginasVisiveis()" :key="page">
                        <li class="page-item" :class="{ active: page === pagina }">
                          <a class="page-link" href="" @click.prevent="mudarPagina(page)" x-text="page"></a>
                        </li>
                      </template>

                      <!-- Link para a próxima página -->
                      <li class="page-item" :class="{ disabled: pagina >= total_paginas }">
                        <a class="page-link" href="" @click.prevent="proximaPagina()" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="/plugins/jquery/jquery.min.js"></script>
  <script src="/plugins/toastr/toastr.min.js"></script>
  <script src="/js/inicio/inicio.js"></script>
  <script src="js/inicio/alpineInicio.js?v=<?= filemtime('js/inicio/alpineInicio.js')?>"></script>