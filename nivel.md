# STATUS PROPOSTA
Sobre os status das propostas no banco de dados com a coluna “status_proposta”.

    Utilizado no CRUD em /inicio

• status_proposta 0 = recusada. = Operador recusou a proposta (informa o motivo).
• status_proposta 1 = em andamento. = Corretor digitou a proposta no sistema.
• status_proposta 2 = em análise. = Operador clicou para visualizar os dados da proposta.
• status_proposta 3 = pendente. = Operador informou que algo está errado ou faltando (Envia email para o corretor).
• status_proposta 4 = pendencia corrigida. = Corretor fez uma atualização na proposta.
• status_proposta 5 = conferido. = Operador informa que a proposta esta pronta para enviar documentos de assinatura.
• status_proposta 6 = aguardando assinatura. = Operador enviou a proposta para assinatura no Click Sign.
• status_proposta 7 = assinado. = Cliente assinou pelo Click Sign (status deve ser atualizado via API Click Sign), pronta para ser digitada no Sistema FIDC.
• status_proposta 8 = ccb enviada. = Proposta Digitada no FIDC e Submetida para assinatura da CCB.
• status_proposta 9 = aguardando pagamento. = Cliente assinou a CCB (atualizar via API).
• status_proposta 10 = pago. = BMP pagou ao cliente.

# CLICK SIGN / ASSINATURA
status_proposta = 5 CONFERIDO //Para ir ao ClickSign
status_assinatura = 0 NÃO ENVIADO. 
status_assinatura = 1 AGUARDANDO ENVIO.
status_assinatura = 2 ENVIADO.

# NIVEL DE USUARIOS.

ADMIN MASTER 100
• Acompanhamento – tudo
• Click Sign – tudo
• Estoque – tudo
• Pendencia - tudo
• Proposta - tudo
ADMIN 90
• Acompanhamento – tudo
• Click Sign – tudo
• Estoque – tudo
• Pendencia - tudo
• Proposta – tudo, exceto edita (praça)

DIGITAÇÃO 40 / ADM 45
• Acompanhamento – tudo
• Click Sign – tudo
• Estoque – tudo
• Pendencia - tudo
• Proposta – tudo, exceto edita (praça)

OPERAÇÃO 30 / O ADM 35
• Acompanhamento – edita.
• Click Sign – inclui, remove.
• Estoque – acesso.
• Pendencia – acesso.
• Proposta – cadastro, edita, remove.
ATENDIMENTO 20 / A ADM 25
• Acompanhamento – edita.
• Click Sign – acesso.
• Estoque – acesso.
• Pendencia – inclui, responde, remove.
• Proposta – cadastro, edita, remove.
CORRETOR 10
• Acompanhamento – sem acesso.
• Click Sign – sem acesso.
• Estoque – sem acesso.
• Pendencia – acesso, responder.
• Proposta – cadastro.
