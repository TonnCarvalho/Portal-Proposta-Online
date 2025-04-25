# Proposta online.
É um projeto que criei para uma empresa onde trabalhei como suporte de informática e no tempo vago era desenvolvedor, com esse projeto eu aprendi PHP, Orientação a Objeto, MVC, Query SQL, Transformar dados em JSON, Consumo de dados JSON no front-end, e por em prática muitas e muitas coisas.
O projeto ainda tem o que acrescentar como integrações com o ClickSign e o Banco que faz o pagamento dos empréstimos e assim está atualizando os status automaticamente, atualmente do status 6 a 10 é manual.

# Sobre o projeto.
É um projeto "ERP"/Portal onde os corretores fazem um pedido de empréstimo consignado, e por ele os corretores podem acompanhar os status dessa proposta.

# Sobre os status
• status_proposta 0 = recusada. O operador recusou a proposta (informa o motivo). <br>
• status_proposta 1 = em andamento. O Corretor digitou a proposta no sistema.<br>
• status_proposta 2 = em análise. O operador clicou para visualizar os dados da proposta.<br>
• status_proposta 3 = pendente. O operador informou que algo está errado ou faltando (Envia email para o corretor).<br>
• status_proposta 4 = pendência corrigida. O Corretor fez uma atualização na proposta.<br>
• status_proposta 5 = conferido. O operador informa que a proposta está pronta para enviar documentos de assinatura.<br>
• status_proposta 6 = aguardando assinatura. O operador enviou a proposta para assinatura no Click Sign (assinatura eletrônica).<br>
• status_proposta 7 = assinado. O cliente assinou pelo documento pelo Click Sign.<br>
• status_proposta 8 = ccb enviada. A CCB foi enviada para assinatura.<br>
• status_proposta 9 = aguardando pagamento. O cliente assinou a CCB.<br>
• status_proposta 10 = pago. O cliente recebeu o empréstimo.<br>
