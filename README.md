# Iniciando o projeto

 - Tenha um servidor php e mysql local.
 - `cd public`
 - `php -S localhost:8080`
# Sobre o projeto.
Tudo começou como uma base de estudos, porem eu achei que foi ficando tão bom que acabei mostrando ao meu chefe na empresa em que trabalho como suporte técnico em informática, e ele pediu para colocar em produção.
É um ERP que gerencia as propostas feitas pelos corretores, em uma empresa de emprestimo consignado.
Com este sistema os corretores podem cadastrar uma proposta, acompanhar os status em que essa proposta se encontra, fazer consultas de margem.

### Sobre os status da proposta.
Atualmente existem 10 status sendo eles. 
- status_proposta 0 = recusada. = Operador recusou a proposta (informa o motivo).
- status_proposta 1 = em andamento. = Corretor digitou a proposta no sistema.
- status_proposta 2 = em análise. = Operador clicou para visualizar os dados da proposta.
- status_proposta 3 = pendente. = Operador informou que algo está errado ou faltando (Envia email para o corretor).
- status_proposta 4 = pendencia corrigida. = Corretor fez uma atualização na proposta.
- status_proposta 5 = conferido. = Operador informa que a proposta esta pronta para enviar documentos de assinatura.
- status_proposta 6 = aguardando assinatura. = Operador enviou a proposta para assinatura no Click Sign.
- status_proposta 7 = assinado. = Cliente assinou pelo Click Sign, pronta para ser digitada no Sistema FIDC.
- status_proposta 8 = ccb enviada. = Proposta Digitada no FIDC e Submetida para assinatura da CCB.
- status_proposta 9 = aguardando pagamento. = Cliente assinou a CCB.
- status_proposta 10 = pago. = BMP pagou ao cliente.

Sendo que os status 6 e 7 devem ser atualizados via API do ClickSign e 8, 9 e 10 devem ser atualizados via API BMP. Atualização essas ainda não integradas ao sistema.

## Problema resolvido.
1. Clareza com os usuários para saber em que situação a proposta se encontra.
2. Eliminou o uso de planilhas pela equipe de backoffice para acompanhar a situação da proposta e também das assinaturas.
3. Permitiu que a equipe de atendimento der mais atenção e tenha mais tempo para responder aos contatos feitos por emails e whatsapp, devido a eliminação das planilhas.
4. Clareza entre os setores de atendimento, averbação e digitação, pois com os status das propostas já sabem o que devem ser feito.
5. Redução no uso de papel e movimento de funcionários para movimentar as propostas entre os setores, atendimento, averbação e digitação.

# Tecnologias utilizadas

 - Arquitetura MVC, criada com vídeos aulas de [Jorge Sant Ana](https://www.udemy.com/user/jorgetadeusantanasilva/).
- PHP puro.
- JavaScript (jQuery, AlpineJS)
	- O AlpineJS foi utilizado para deixar o sistema dinâmico com as requisições feitas pelo usuário
- Database MySQL
- AdminLTE 3

## Aprendizados deste projeto.
- Autenticação
- Melhorei meus conhecimentos sobre logica de programação e regras de negócios.
- MVC, entender melhor o que é uma Model, uma View e a Controller, como enviar a requisição gerada pela Model para a Controller e como passar dados da Controller para a View.
- Entender sobre as rotas e como elas funcionam.
- Aprendi a retornar os dados da Model em JSON usando o `json_encode()`, e fazer a requisição no front-end com JavaScript.
- Pude por em pratica o consumo de requisição usando o `fetch` do JavaScript.
- Passar dados para o modal.
- Exportar e Importar de arquivo CSV.
- Importação de dados em arquivo CSV para o banco de dados.
- Envio de email pelo PHPMailer

# Observação
Sinto que pode ser feito muito mais por esse ERP, como integrar ele os sistemas internos como o ClickSign, BMP, e até mesmo para o sistema de conciliação da empresa, evitando assim também a digitação das propostas.
Fica para um próximo estudo a criação de uma API para este projeto.

# Responsavel
[Cleiton Carvalho](https://github.com/TonnCarvalho/)
