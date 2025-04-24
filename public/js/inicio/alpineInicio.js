function inicioTabelaCrud() {
  return {
    propostas: [],
    praca: "",
    situacao: "",
    pesquisa: "",
    pagina: 1,
    total_paginas: 1,
    max_paginas_visiveis: 5,
    optionSituacao: [
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

    async carregarPropostas() {
      try {
        const queryParams = [];

        if (this.pesquisa) {
          this.praca = "";
          this.situacao = "";
        }

        if (this.praca || this.situacao) {
          this.pesquisa = "";
        }

        if (this.praca) {
          queryParams.push(`cod_local=${encodeURIComponent(this.praca)}`);
        }

        if (this.situacao) {
          queryParams.push(`situacao=${encodeURIComponent(this.situacao)}`);
        }

        if (this.pesquisa) {
          queryParams.push(`pesquisa=${encodeURIComponent(this.pesquisa)}`);
        }

        queryParams.push(`pagina=${this.pagina}`); // Adiciona o parâmetro de página

        const queryString = queryParams.length
          ? `?${queryParams.join("&")}`
          : "";
        const response = await fetch(
          `/inicio/filtra-proposta-inicio${queryString}`
        );
        const data = await response.json();
        this.propostas = data.propostas;
        this.pagina = data.pagina_atual;
        this.total_paginas = data.total_paginas;
      } catch (error) {
        console.error("Erro ao carregar propostas:", error);
      }
    },

    paginaAnterior() {
      if (this.pagina > 1) {
        this.pagina--;
        this.moveTopoTabela();
        this.carregarPropostas();
      }
    },
    proximaPagina() {
      if (this.pagina < this.total_paginas) {
        this.pagina++;
        this.moveTopoTabela();
        this.carregarPropostas();
      }
    },
    mudarPagina(page) {
      this.pagina = page;
      this.moveTopoTabela();
      this.carregarPropostas();
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

    //Envia para o top da tabela
    moveTopoTabela() {
      const topTable = document.querySelector("#tabelaPropostas");

      console.log(topTable);
      if (topTable) {
        setTimeout(() => {
          const topo = topTable.getBoundingClientRect().top + window.scrollY;
          window.scrollTo({
            top: topo,
            behavior: "smooth",
          });
          console.log("encontrado: ", topo);
        }, 100); // Atraso de 100ms para garantir que o DOM esteja carregado
      }
    },

    formataDataHora(dataProposta) {
      const data = new Date(dataProposta).toLocaleDateString("pt-BR");
      const hora = new Date(dataProposta).toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
      });

      return `${data}<br>${hora}`;
    },
  };
}
