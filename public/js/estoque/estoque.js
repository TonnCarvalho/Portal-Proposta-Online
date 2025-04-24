//ALPINE
function tabelaEstoqueAssociado() {
  return {
    estoque: [],
    parcela: 1,
    num_proposta: "",
    nome: "",
    cpf: "",
    numPropostaAssociado: "",
    valor_presente: "",
    valor_refinanciamento: "",
    valor_medio_presente: "",

    async carregarEstoque() {
      // Exemplo de requisição Ajax usando Fetch API
      await fetch(`estoque-buscar-associado?num_proposta=${this.num_proposta}`)
        .then((response) => response.json())
        .then((data) => {
          // Atualiza o array com os dados recebidos da requisição
          this.estoque = data;
          this.nome = data[0]["nome"] || "";
          this.cpf = data[0]["cpf"] || "";
          this.numPropostaAssociado = data[0]["num_proposta"] || "";

          notificacao.sucesso("Estoque encontrado");
          // Chama a função para iniciar os valores
          this.iniciarValores();
        })
        .catch((error) => {
          console.error("Erro ao carregar o estoque:", error);
          this.nome = "";
          this.cpf = "";
          this.numPropostaAssociado = "";
          this.valor_presente = "";
          this.valor_refinanciamento = "";
          this.valor_medio_presente = "";
          notificacao.erro("Estoque não encontrato");
        });
    },
    formatoData(dataEstoque) {
      const data = new Date(dataEstoque).toLocaleDateString("pt-BR");
      return data;
    },
    removerSuffix(numPoposta) {
      const regex = /_.*$/;
      return numPoposta.replace(regex, "");
    },
    // Função que deixa os valores no formato pt-BR
    formatarValor(valor) {
      return Number(valor).toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      });
    },
    // Função para calcular a média do valor presente
    calcularMediaValorPresente() {
      var somaValores = 0;
      var quantidadeMarcados = this.contarCheckboxesMarcados();

      if (quantidadeMarcados === 0) {
        return 0;
      }

      document
        .querySelectorAll(".checkboxBody:checked")
        .forEach((checkbox) => {
          var row = checkbox.closest("tr");
          var valorPresenteText = row.cells[3].innerText;
          var valorPresente = parseFloat(
            valorPresenteText.replace(".", "").replace(",", ".")
          );

          somaValores += valorPresente;
        });

      return somaValores / quantidadeMarcados;
    },

    contarCheckboxesMarcados() {
      return document.querySelectorAll(".checkboxBody:checked").length;
    },

    // Função para atualizar os valores e a média
    atualizarValores() {
      var valorTotalPresente = 0;
      var valorTotalRefim = 0;

      document
        .querySelectorAll(".checkboxBody:checked")
        .forEach((checkbox) => {
          var row = checkbox.closest("tr");
          var valorPresenteText = row.cells[3].innerText;
          var valorPresente = parseFloat(
            valorPresenteText.replace(".", "").replace(",", ".")
          );

          valorTotalPresente += valorPresente;
          valorTotalRefim += valorPresente * 1.05;
        });

      // Atualiza os valores no estado do AlpineJS
      this.valor_presente = this.formatarValor(valorTotalPresente);
      this.valor_refinanciamento = this.formatarValor(valorTotalRefim);
      this.valor_medio_presente = this.formatarValor(
        this.calcularMediaValorPresente()
      );
    },

    iniciarValores() {
      let totalPresente = 0;
      let totalRefinanciamento = 0;

      // Itera sobre os itens recebidos da requisição para calcular os valores
      this.estoque.forEach((item) => {
        totalPresente += parseFloat(item.valor_presente);
        totalRefinanciamento += parseFloat(item.valor_presente) * 1.05; // Exemplo de cálculo
      });

      // Calcula a média
      let mediaPresente =
        this.estoque.length > 0 ? totalPresente / this.estoque.length : 0;

      // Atualiza os valores no estado
      this.valor_presente = this.formatarValor(totalPresente);
      this.valor_refinanciamento = this.formatarValor(totalRefinanciamento);
      this.valor_medio_presente = this.formatarValor(mediaPresente);
    },

    toggleAllCheckboxes() {
      let checked = document.getElementById("checkboxHead").checked;
      document.querySelectorAll(".checkboxBody").forEach((checkbox) => {
        checkbox.checked = checked;
      });
      this.atualizarValores();
    },
  };
}
