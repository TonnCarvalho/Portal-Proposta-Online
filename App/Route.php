<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap
{

	protected function initRoutes()
	{
		//****************************************************** */
		//AUTENTICAÇÃO
		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);
		$routes['/-login'] = array(
			'route' => '/',
			'controller' => 'AuthController',
			'action' => 'index'
		);
		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'AuthController',
			'action' => 'index'
		);
		$routes['logout'] = array(
			'route' => '/logout',
			'controller' => 'AuthController',
			'action' => 'logout'
		);
		$routes['recuperar_senha'] = array(
			'route' => '/recuperar-senha',
			'controller' => 'AuthController',
			'action' => 'recuperarSenha'
		);
		$routes['recuperar_senha_enviar_token'] = array(
			'route' => '/recuperar-senha/enviar-token',
			'controller' => 'AuthController',
			'action' => 'enviarToken'
		);
		//================================================================
		//INICIO
		$routes['painel'] = array(
			'route' => '/painel',
			'controller' => 'indexController',
			'action' => 'painel'
		);
		$routes['inicio'] = array(
			'route' => '/inicio',
			'controller' => 'indexController',
			'action' => 'inicio'
		);
		$routes['filtraPropostaInicio'] = array(
			'route' => '/inicio/filtra-proposta-inicio',
			'controller' => 'indexController',
			'action' => 'filtraPropostaInicio'
		);

		$routes['proposta_mudar_situacao'] = array(
			'route' => '/proposta-mudar-situacao',
			'controller' => 'IndexController',
			'action' => 'propostaMudarSituacao'
		);
		//================================================================
		//ASSINADOS
		$routes['assinados'] = array(
			'route' => '/assinados',
			'controller' => 'AssinadosController',
			'action' => 'index'
		);
		$routes['get_propostas_assinadas'] = array(
			'route' => '/propostas-assinados',
			'controller' => 'AssinadosController',
			'action' => 'propostasAssinadas'
		);
		$routes['assinados_digitado'] = array(
			'route' => '/assinados-digitado',
			'controller' => 'AssinadosController',
			'action' => 'propostaAprovadaDigitada'
		);
		$routes['post_propostas_aprovadas'] = array(
			'route' => '/assinados-aprovados',
			'controller' => 'AssinadosController',
			'action' => 'todasPropostasAprovadasDigitadas'
		);
		//================================================================
		//ACOMPANHAMENTO
		$routes['acompanhamento_index'] = array(
			'route' => '/acompanhamento',
			'controller' => 'AcompanhamentoController',
			'action' => 'index'
		);
		$routes['acompanhamento_get_proposta'] = array(
			'route' => '/acompanhamento-propostas',
			'controller' => 'AcompanhamentoController',
			'action' => 'getProposta'
		);
		//================================================================
		//CCB ENVIADA
		$routes['ccb_enviada'] = array(
			'route' => '/ccb-enviada',
			'controller' => 'CCBEnviadaController',
			'action' => 'index'
		);
		$routes['ccb_enviada_get_propostas'] = array(
			'route' => '/ccb-enviada/get-propostas',
			'controller' => 'CCBEnviadaController',
			'action' => 'getCcbEnviadas'
		);
		$routes['post_ccb_assinada'] = array(
			'route' => '/ccb-enviada/post-ccb-assinada',
			'controller' => 'CCBEnviadaController',
			'action' => 'postPropostaCcbAssinada'
		);
		$routes['post_todas_ccb_assinada'] = array(
			'route' => '/ccb-enviada/post-todas-ccb-assinada',
			'controller' => 'CCBEnviadaController',
			'action' => 'postTodasPropostaCcbAssinada'
		);
		//================================================================
		//A PAGAR
		$routes['a_paga'] = array(
			'route' => '/paga',
			'controller' => 'PagaController',
			'action' => 'index'
		);
		$routes['a_paga_get_proposta'] = array(
			'route' => '/paga/paga-get-propostas',
			'controller' => 'PagaController',
			'action' => 'getPropostas'
		);
		$routes['a_paga_post_paga'] = array(
			'route' => '/paga/paga-post-proposta',
			'controller' => 'PagaController',
			'action' => 'postPagaProposta'
		);
		$routes['a_paga_post_pagas'] = array(
			'route' => '/paga/paga-post-propostas',
			'controller' => 'PagaController',
			'action' => 'postPagaTodasPropostas'
		);
		//================================================================
		//BAIXAR DOCUMENTO
		$routes['documento_assinatura'] = array(
			'route' => '/baixar-documento',
			'controller' => 'BaixarDocumentoController',
			'action' => 'gerarDocumento'
		);
		//================================================================
		//PROPOSTA
		$routes['proposta_cadastro'] = array(
			'route' => '/proposta-cadastro',
			'controller' => 'PropostaController',
			'action' => 'propostaCadastro'
		);
		$routes['proposta_cadastrar'] = array(
			'route' => '/proposta-cadastrar',
			'controller' => 'PropostaController',
			'action' => 'propostaCadastrar'
		);
		$routes['proposta_edita'] = array(
			'route' => '/proposta-edita',
			'controller' => 'PropostaController',
			'action' => 'propostaEdita'
		);
		$routes['proposta_atualizar'] = array(
			'route' => '/proposta-atualizar',
			'controller' => 'PropostaController',
			'action' => 'propostaAtualizar'
		);

		$routes['juntar_img_em_pdf'] = array(
			'route' => '/juntar-img-pdf',
			'controller' => 'PropostaController',
			'action' => 'juntarImagensPDF'
		);

		$routes['remove_documento'] = array(
			'route' => '/remove-documento',
			'controller' => 'PropostaController',
			'action' => 'removerDocumento'
		);
		$routes['conferir_proposta'] = array(
			'route' => '/conferir-proposta',
			'controller' => 'PropostaController',
			'action' => 'conferirProposta'
		);
		$routes['proposta_assinada'] = array(
			'route' => '/proposta-assinada',
			'controller' => 'PropostaController',
			'action' => 'propostaAssinada'
		);
		$routes['recusar_proposta'] = array(
			'route' => '/recusar-proposta',
			'controller' => 'PropostaController',
			'action' => 'recusarProposta'
		);
		$routes['reativar_proposta'] = array(
			'route' => '/reativar-proposta',
			'controller' => 'PropostaController',
			'action' => 'reativarProposta'
		);
		//================================================================
		//PENDENCIA
		$routes['pendencia'] = array(
			'route' => '/criar-pendencia',
			'controller' => 'PendenciaController',
			'action' => 'pendenciaCriar'
		);
		$routes['pendencia_editar'] = array(
			'route' => '/edita-pendencia',
			'controller' => 'PendenciaController',
			'action' => 'pendenciaEditar'
		);
		//================================================================
		//CLICK SIGN
		$routes['clicksign'] = array(
			'route' => '/clicksign',
			'controller' => 'ClickSignController',
			'action' => 'index'
		);
		$routes['clicksign_assinatura_proposta'] = array(
			'route' => '/clicksign-assinatura-proposta',
			'controller' => 'ClickSignController',
			'action' => 'mostraPropostaClickSign'
		);
		$routes['clicksign_assinatura_proposta_total'] = array(
			'route' => '/clicksign-assinatura-proposta-total',
			'controller' => 'ClickSignController',
			'action' => 'filtraClickSignTotal'
		);
		$routes['clicksign_adicionar'] = array(
			'route' => '/assinar-proposta',
			'controller' => 'ClickSignController',
			'action' => 'enviarParaClickSign'
		);
		$routes['clicksign_remover'] = array(
			'route' => '/clicksign-remover',
			'controller' => 'ClickSignController',
			'action' => 'remover'
		);
		$routes['clicksign_adicionar_refin'] = array(
			'route' => '/clicksign-adicionar-refin',
			'controller' => 'ClickSignController',
			'action' => 'adicionarRefin'
		);
		$routes['clicksign_edita_refin'] = array(
			'route' => '/clicksign-edita-refin',
			'controller' => 'ClickSignController',
			'action' => 'editaRefin'
		);
		$routes['clicksign_apaga_refin'] = array(
			'route' => '/clicksign-apaga-refin',
			'controller' => 'ClickSignController',
			'action' => 'apagaRefin'
		);
		$routes['clicksign_gerar_excel'] = array(
			'route' => '/clicksign-gerar-excel',
			'controller' => 'ClickSignController',
			'action' => 'gerarExcel'
		);
		//================================================================
		//CONSULTA
		$routes['consultas'] = array(
			'route' => '/consultas',
			'controller' => 'ConsultaController',
			'action' => 'index'
		);
		$routes['consulta_visualiza'] = array(
			'route' => '/consulta',
			'controller' => 'ConsultaController',
			'action' => 'consultaVisualiza'
		);
		$routes['consulta_adicionar'] = array(
			'route' => '/consulta-adicionar',
			'controller' => 'ConsultaController',
			'action' => 'consultaAdicionar'
		);
		$routes['consulta_enviar'] = array(
			'route' => '/consulta-enviar',
			'controller' => 'ConsultaController',
			'action' => 'postConsulta'
		);
		$routes['consulta_resonder'] = array(
			'route' => '/consulta-responder',
			'controller' => 'ConsultaController',
			'action' => 'postConsultaResponder'
		);
		//================================================================
		//ESTOQUE
		$routes['estoque'] = array(
			'route' => '/estoque-consulta',
			'controller' => 'EstoqueController',
			'action' => 'index'
		);
		$routes['estoque_adicionar'] = array(
			'route' => '/estoque-adicionar',
			'controller' => 'EstoqueController',
			'action' => 'adicionarEstoque'
		);
		$routes['estoque_sucesso'] = array(
			'route' => '/estoque-sucesso',
			'controller' => 'EstoqueController',
			'action' => 'estoqueSucesso'
		);
		$routes['estoque_enviar'] = array(
			'route' => '/estoque-enviar',
			'controller' => 'EstoqueController',
			'action' => 'enviarEstoque'
		);
		$routes['estoque_buscar_associado'] = array(
			'route' => '/estoque-buscar-associado',
			'controller' => 'EstoqueController',
			'action' => 'buscarEstoqueAssociado'
		);
		//================================================================
		//ARQUIVO QUITAÇÃO
		$routes['quitacao_gerar_arquivo'] = array(
			'route' => '/gerar-arquivo-quitacao',
			'controller' => 'QuitacaoController',
			'action' => 'gerarArquivoQuitacao'
		);
		//================================================================
		//PRESTAMISTA
		$routes['prestamista_adicionar'] = array(
			'route' => '/prestamista',
			'controller' => 'PrestamistaController',
			'action' => 'index'
		);
		$routes['prestamista_enviar'] = array(
			'route' => '/prestamista-enviar',
			'controller' => 'PrestamistaController',
			'action' => 'enviarPrestamista'
		);
		//================================================================
		//ROTEIRO OPERACIONAL
		$routes['roteiro'] = array(
			'route' => '/roteiro-operacional',
			'controller' => 'RoteiroOperacionalController',
			'action' => 'index'
		);
		//================================================================
		//SIMULADOR VALORES
		$routes['simulador'] = array(
			'route' => '/simulador-valores',
			'controller' => 'SimuladorValoresController',
			'action' => 'index'
		);
		//================================================================
		//ORGÃOS
		$routes['orgaos'] = array(
			'route' => '/orgaos',
			'controller' => 'OrgaosController',
			'action' => 'index'
		);
		$routes['orgaos_filtro'] = array(
			'route' => '/orgaos/filtro-orgao',
			'controller' => 'OrgaosController',
			'action' => 'filtroOrgaos'
		);
		$routes['adicionar_orgao'] = array(
			'route' => '/adicionar-orgao',
			'controller' => 'OrgaosController',
			'action' => 'adicionarOrgao'
		);
		$routes['mudar_situacao_orgao'] = array(
			'route' => '/mudar-situacao-orgao',
			'controller' => 'OrgaosController',
			'action' => 'mudarSituacaoOrgao'
		);
		$routes['edita_orgao'] = array(
			'route' => '/edita-orgao',
			'controller' => 'OrgaosController',
			'action' => 'editaOrgao'
		);
		$routes['deleta_orgao'] = array(
			'route' => '/deleta-orgao',
			'controller' => 'OrgaosController',
			'action' => 'deletaOrgao'
		);
		//================================================================
		//PRAÇA
		$routes['praca'] = array(
			'route' => '/praca',
			'controller' => 'PracaController',
			'action' => 'index'
		);
		$routes['todas_pracas'] = array(
			'route' => '/todas-pracas',
			'controller' => 'PracaController',
			'action' => 'pracas'
		);
		$routes['mudar_situacao_praca'] = array(
			'route' => '/mudar-situacao-praca',
			'controller' => 'PracaController',
			'action' => 'mudarSituacaoPraca'
		);
		$routes['adicionar_praca'] = array(
			'route' => '/adicionar-praca',
			'controller' => 'PracaController',
			'action' => 'adicionarPraca'
		);
		$routes['edita_praca'] = array(
			'route' => '/edita-praca',
			'controller' => 'PracaController',
			'action' => 'editaPraca'
		);
		$routes['deleta_praca'] = array(
			'route' => '/deleta-praca',
			'controller' => 'PracaController',
			'action' => 'deletaPraca'
		);
		//================================================================
		//ÚSUARIO
		$routes['usuario'] = array(
			'route' => '/usuario',
			'controller' => 'UsuarioController',
			'action' => 'index'
		);
		$routes['login-atualizar_usuario'] = array(
			'route' => '/atualizar-usuario',
			'controller' => 'UsuarioController',
			'action' => 'loginAtualizarDados'
		);
		$routes['atualizar_dados_usuario'] = array(
			'route' => '/atualizar-usuario-login',
			'controller' => 'UsuarioController',
			'action' => 'postAtualizarUsuarioLogin'
		);
		$routes['usuario_lista'] = array(
			'route' => '/lista-usuario',
			'controller' => 'UsuarioController',
			'action' => 'listaUsuario'
		);

		$routes['mudar_situacao_usuario'] = array(
			'route' => '/mudar-situacao-usuario',
			'controller' => 'UsuarioController',
			'action' => 'mudarSituacaoUsuario'
		);
		$routes['adicionar_usuario'] = array(
			'route' => '/adicionar-usuario',
			'controller' => 'UsuarioController',
			'action' => 'adicionarUsuario'
		);
		$routes['edita_usuario'] = array(
			'route' => '/edita-usuario',
			'controller' => 'UsuarioController',
			'action' => 'editaUsuario'
		);
		$routes['altera_senha_usuario'] = array(
			'route' => '/altera-seha-usuario',
			'controller' => 'UsuarioController',
			'action' => 'alteraSenhaUsuario'
		);
		$this->setRoutes($routes);
	}
}
