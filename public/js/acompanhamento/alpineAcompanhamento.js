function alpineAcompanhamento(idUsuario) {
  return {
    idUsuario: idUsuario,
    pesquisa: '',
    situacao: '',
    clicksign: '',
    selectSituacao: [
      { titulo: 'Em Andamento', value: 'andamento' },
      { titulo: 'Em Análise', value: 'analise' },
      { titulo: 'Conferido', value: 'conferido' },
      { titulo: 'Pendente', value: 'pendente' },
      { titulo: 'Aguardando Assinatura', value: 'aguardando_assinatura' },
      { titulo: 'Assinado', value: 'assinado' },
      { titulo: 'Recusado', value: 'recusado' },
      { titulo: 'CCB Enviada', value: 'ccb_enviada' },
      { titulo: 'Aguardando Pagamento', value: 'aguardando_pagamento' },
      { titulo: 'Pago', value: 'pago' }
    ],
    selectClickSign: [
      { titulo: 'Não Enviado', value: 'nao_enviado' },
      { titulo: 'Aguardando Envio', value: 'aguardando_envio' },
      { titulo: 'Aguardando Assinatura', value: 'aguardando_assinatura' },
      { titulo: 'Assinado', value: 'assinado' }
    ],
    propostas: [],
    pagina: 1,
    total_paginas: 1,
    max_paginas_visiveis: 5,
    async propostasAcompanhamento() {
      try {
        const queryParams = [];

        queryParams.push(`pagina=${this.pagina}`);

        if (this.pesquisa != '') {
          queryParams.push(`pesquisa=${encodeURIComponent(this.pesquisa)}`);
        }
        if (this.situacao != '') {
          queryParams.push(`situacao=${encodeURIComponent(this.situacao)}`)
        }
        if (this.clicksign != '') {
          queryParams.push(`clicksign=${encodeURIComponent(this.clicksign)}`)
        }

        const queryString = queryParams.length
          ? `?${queryParams.join("&")}`
          : "";

        const response = await fetch(
          `/acompanhamento-propostas${queryString}`
        );

        const data = await response.json();
        this.propostas = data.propostas;
        this.pagina = data.pagina_atual;
        this.total_paginas = data.total_paginas;

      } catch (error) {
        console.log("Erro:" + error);
      }
    },
    atualizarPagina() {
      setTimeout(() => {
        window.location.href = '/acompanhamento';
      }, 2000);
    },
    propostaAssinada(id_proposta) {
      fetch(`proposta-assinada?id_proposta=${id_proposta}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.propostaAssinada) {
            this.propostasAcompanhamento();
            notificacao.sucesso("Status alterado com sucesso.");
          }
        })
        .catch((error) => {
          notificacao.erro("Falhou", error);
          console.log(error);
        });
    },
    enviarParaClickSign(id_proposta) {
      fetch(`/assinar-proposta?id_proposta=${id_proposta}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.assinando) {
            this.propostasAcompanhamento();
            notificacao.sucesso("Enviado");
          }
        })
        .catch((error) => {
          console.log("Error");
          notificacao.erro("Falhou");
        });
    },
    //REATIVAR PROPOSTA
    reativarProposta(id_proposta) {
      fetch(`/reativar-proposta?id_proposta=${id_proposta}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.reativado) {
            this.propostasAcompanhamento();
            notificacao.sucesso("Reativado");
          }
        })
        .catch((error) => {
          console.log("Error");
          notificacao.erro("Falhou");
        });
    },
    removerSobreNome(nome) {
      return nome.split(" ", 1);
    },
    paginaAnterior() {
      if (this.pagina > 1) {
        this.pagina--;
        this.propostasAcompanhamento();
      }
    },
    proximaPagina() {
      if (this.pagina < this.total_paginas) {
        this.pagina++;
        this.propostasAcompanhamento;
        this.propostasAcompanhamento();
      }
    },
    mudarPagina(page) {
      this.pagina = page;
      this.propostasAcompanhamento;
      this.propostasAcompanhamento();
    },
    paginasVisiveis() {
      const paginas = [];
      const inicio = Math.max(
        1,
        this.pagina - Math.floor(this.max_paginas_visiveis / 2)
      );
      const fim = Math.min(
        this.total_paginas,
        inicio + this.max_paginas_visiveis - 1
      );

      for (let i = inicio; i <= fim; i++) {
        paginas.push(i);
      }

      return paginas;
    },
    statusClickSign(status_proposta_p, status_assinatura) {
      if (status_proposta_p <= 5 && status_assinatura === 0) {
        return `<span class='badge' style='background-color: #FEE2E2; color: #991B1B; border: 1px solid #FEE2E2'>
                          <i class='fas fa-times mr-1'></i>
                              NÃO ENVIADO
                        </span>`;
      }
      if (status_proposta_p === 5 && status_assinatura === 1) {
        return `<span class='badge' style='background-color: #DBEAFE; color: #1E40AF; border: 1px solid #DBEAFE'>
                         <i class='fas fa-spinner mr-1'></i>
                              AGUARDANDO ENVIO
                      </span>`;
      }
      if (status_proposta_p === 6 && status_assinatura === 2) {
        return `<span class='badge' style='background-color: #E0E7FF; color: #3730A3; border: 1px solid #E0E7FF'>
                        <i class='fas fa-file-signature mr-2' style='font-size: 14px;'></i>
                            AGUARDANDO ASSINATURA
                    </span>`;
      }
      if (status_proposta_p >= 7 && status_assinatura === 2) {
        return `<span class='badge' style='background-color: #D1FAE5; color: #065F46; border: 1px solid #D1FAE5'>
                            <i class='fas fa-file-circle-check mr-2' style='font-size: 14px;'></i>
                                ASSINADO
                        </span>`;
      }
    },
    tipoPropostaReplace(string) {
      return string.replace(/_/g, " ");
    },
    valorFormato(valor) {
      return Number(valor).toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
      });
    },
  };
}
