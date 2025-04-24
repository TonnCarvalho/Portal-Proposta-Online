function alpineClickSign() {
  return {
    propostas: [],
    totalProposta: 0,
    checkboxHeader: true,
    async propostaClickSign() {
      try {
        const response = await fetch("/clicksign-assinatura-proposta");
        const data = await response.json();
        this.propostas = data;
        this.totalPropostaClickSign();
      } catch (error) {
        console.log("Error ");
      }
    },
    async totalPropostaClickSign() {
      try {
        const response = await fetch("/clicksign-assinatura-proposta-total");
        const data = await response.json();
        this.totalProposta = data;
      } catch (error) {
        console.log("Error ", error);
      }
    },
    valorFormato(valor) {
      return Number(valor).toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
      });
    },
    apagaRefin(id_proposta, id_refin) {
      fetch(
        `/clicksign-apaga-refin?id_proposta=${id_proposta}&id_refin=${id_refin}`,
        {
          method: "POST",
        }
      )
        .then((response) => response.json())
        .then((data) => {
          if (data.apagado) {
            this.propostaClickSign();
            notificacao.sucesso("Refin apagado");
          }
        })
        .catch((error) => {
          notificacao.erro("Falhou");
        });
    },
    remover(id_proposta) {
      fetch(`/clicksign-remover?id_proposta=${id_proposta}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.remover) {
            this.propostaClickSign();
            notificacao.sucesso("Removido");
          }
        })
        .catch((error) => {
          notificacao.erro("Falhou");
        });
    },

    mudarEstadoCheckBoxHeader() {
      const inputCheckboxHeader = document.querySelector(".checkboxHeader");

      if (inputCheckboxHeader.checked) {
        this.checkboxHeader = false;

        inputCheckboxHeader.checked = !inputCheckboxHeader.checked;
      }
    },

    mudarEstadoCheckBoxBody() {
      this.checkboxHeader = !this.checkboxHeader;

      const inputCheckboxBody = document.querySelectorAll(".checkboxBody");

      inputCheckboxBody.forEach((checkbox) => {
        checkbox.checked = this.checkboxHeader;
      });
    },
  };
}
