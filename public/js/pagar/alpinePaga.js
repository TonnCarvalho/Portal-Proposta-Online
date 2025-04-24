function alpinePaga() {
  return {
    propostas: [],
    pesquisa: "",
    data: '',
    idPropostas: [],
    checkboxHeaderStatus: false,
    async carregarProposta() {
      const queryParams = [];

      if (this.pesquisa) {
        queryParams.push(`pesquisa=${encodeURIComponent(this.pesquisa)}`)
      }
      if (this.data) {
        queryParams.push(`data=${encodeURIComponent(this.data)}`)
      }

      const queryString = queryParams.length
        ? `?${queryParams.join("&")}`
        : "";

      try {
        const response = await fetch(`/paga/paga-get-propostas${queryString}`);
        const data = await response.json();
        this.propostas = data;

      } catch (error) {
        console.log('Error')
      }
    },

    formatoValor(valor) {
      return Number(valor).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
      })
    },

    propostaPaga(id_proposta) {
      fetch(`/paga/paga-post-proposta?id_proposta=${id_proposta}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.paga) {
            this.carregarProposta();
            notificacao.sucesso("Status alterado com sucesso.");
          }
        })
        .catch((error) => {
          notificacao.erro("Falhou");
        });
    },

    propostasPagas() {
      const data = { idProposta: this.idPropostas };

      fetch("/paga/paga-post-propostas", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.pagas) this.carregarProposta();
          notificacao.sucesso("Status alterado com sucesso.");
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },

    mudarEstadoCheckBoxHeader() {
      const inputCheckboxHeader = document.querySelector('.checkboxHeader');
      if (inputCheckboxHeader.checked) {
        this.checkboxHeaderStatus = false;
        inputCheckboxHeader.checked = !inputCheckboxHeader.checked
      }
    },
    mudarEstadoCheckBoxBody() {
      this.checkboxHeaderStatus = !this.checkboxHeaderStatus;

      const inputCheckboxBody = document.querySelectorAll('.checkboxBody');
      inputCheckboxBody.forEach((checkbox) => {
        checkbox.checked = this.checkboxHeaderStatus
        const value = checkbox.value;

        if (this.checkboxHeaderStatus) {
          if (!this.idPropostas.includes(value)) {
            this.idPropostas.push(value)
          }
        } else {
          this.idPropostas = this.idPropostas.filter((id) => id !== value)
        }
      })

    }
  }
}