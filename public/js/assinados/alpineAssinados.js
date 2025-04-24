function alpineAssinados() {
  return {
    propostas: [],
    idPropostas: [],
    checkboxHeaderStatus: false,

    async propostaAssinadas() {
      try {
        const response = await fetch("/propostas-assinados");

        const data = await response.json();

        this.propostas = data;
      } catch (error) {
        console.log("Error");
      }
    },

    propostaAprovadaDigitada(id_proposta) {
      fetch(`assinados-digitado?id_proposta=${id_proposta}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.digitada) {
            this.propostaAssinadas();
            notificacao.sucesso("Status alterado com sucesso.");
          }
        })
        .catch((error) => {
          notificacao.erro("Falhou");
        });
    },

    todasPropostasAprovadasDigitadas() {
      const data = { idProposta: this.idPropostas };

      fetch("/assinados-aprovados", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.atualizado) this.propostaAssinadas();
          notificacao.sucesso("Status alterado com sucesso.");
        })
        .catch((error) => {
          notificacao.erro("Falhou");
        });
    },

    mudarEstadoCheckBoxHeader() {

      const inputCheckboxHeader = document.querySelector(".checkboxHeader");
      if (inputCheckboxHeader.checked) {
        this.checkboxHeaderStatus = false;
        inputCheckboxHeader.checked = !inputCheckboxHeader.checked;
      }
    },

    mudarEstadoCheckBoxBody() {
      // Alternar o estado geral do header
      this.checkboxHeaderStatus = !this.checkboxHeaderStatus;

      // Iterar pelos checkboxes e atualizar o estado de cada um
      const inputCheckboxBody = document.querySelectorAll(".checkboxBody");
      inputCheckboxBody.forEach((checkbox) => {
        checkbox.checked = this.checkboxHeaderStatus; // Atualiza visualmente
        const value = checkbox.value;

        if (this.checkboxHeaderStatus) {
          // Adiciona o valor ao array `idPropostas` se não estiver presente
          if (!this.idPropostas.includes(value)) {
            this.idPropostas.push(value);
          }
        } else {
          // Remove o valor do array `idPropostas`
          this.idPropostas = this.idPropostas.filter((id) => id !== value);
        }
      });
    }
  };
}
