function alpinePraca() {
  return {
    pracasLista: [],
    pesquisa: "",
    async pracas() {
      try {
        const url = this.pesquisa
          ? `/todas-pracas?pesquisa=${encodeURIComponent(this.pesquisa)}`
          : `/todas-pracas`;

        const response = await fetch(url);
        if (!response.ok) {
          throw new Error("Erro na requisição"); // Lida com erros de resposta HTTP
        }

        const data = await response.json();

        this.pracasLista = data;
      } catch (error) {
        console.log("Error ao buscar praça");
      }
    },

    mudarSituacaoPraca(cod_local, event) {
      const isChecked = event.target.checked;
      fetch("/mudar-situacao-praca", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          cod_local: cod_local,
          checked: isChecked,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            this.pracas();
            notificacao.sucesso("Praça alterada");
          } else {
            notificacao.erro("Falhou");
          }
        })
        .catch((error) => {
          console.error("Error");
        });
    },
    deletaPraca(cod_local) {
      fetch(`/deleta-praca?cod_local=${cod_local}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.deleta) {
            this.pracas();
            notificacao.sucesso("Praça deletada");
          }
        })
        .catch((error) => {
          notificacao.erro("Falhou");
        });
    },
    tipoPraca() {
      const tipoPraca = document.querySelector("#tipoPraca");
      const pracaEstadoMunicipio = document.querySelector(
        "#pracaEstadoMunicipio"
      );
      const selectEstado = document.querySelector("#selectEstado");

      if (tipoPraca.value === "municipio") {
        pracaEstadoMunicipio.classList.remove("d-none");
      } else {
        pracaEstadoMunicipio.classList.add("d-none");
        selectEstado.value = "";
      }
    },
  };
}
