function alpineCcbEnviada() {
  return {
    propostas: [],
    idPropostas: [],
    idcheckboxHeader: true,

    async propostaCcbEnviada() {
      try {
        const response = await fetch("/ccb-enviada/get-propostas");
        const data = await response.json();
        this.propostas = data;
      } catch (error) {
        console.error('Error')
      }
    },

    CcbAssinada(id_proposta) {
      fetch(`/ccb-enviada/post-ccb-assinada?id_proposta=${id_proposta}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.ccb_assinada) {
            this.propostaCcbEnviada();
            notificacao.sucesso("Status alterado com sucesso.");
          }
        })
        .catch((error) => {
          notificacao.erro("Falhou");
        });
    },

    todasCcbAssinadas() {
      const data = { idProposta: this.idPropostas };

      fetch("/ccb-enviada/post-todas-ccb-assinada", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.ccb_assinadas) {
            this.propostaCcbEnviada();
            notificacao.sucesso("Status alterado com sucesso.");
          }
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

  }
}