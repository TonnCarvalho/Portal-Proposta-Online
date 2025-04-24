function alpineOrgaos() {
  return {
    orgaosLista: [],
    pesquisa: "",
    cod_local: this.cod_local,
    async selectOrgaos() {
      try {
        const response = await fetch(
          `orgaos/filtro-orgao?cod_local=${this.cod_local}`
        );

        if (!response.ok) {
          throw new Error("Erro na requisição"); // Lida com erros de resposta HTTP
        }

        const data = await response.json();

        this.orgaosLista = data;
      } catch (error) {
        console.log("Error ao buscar praça");
      }
    },

    mudarSituacaoOrgao(id_orgao, event) {
      const isChecked = event.target.checked;
      fetch("/mudar-situacao-orgao", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id_orgao: id_orgao,
          checked: isChecked,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            this.selectOrgaos();
            notificacao.sucesso("Orgão alterado");
          } else {
            notificacao.erro("Falhou");
          }
        })
        .catch((error) => {
          console.error("Error");
        });
    },

    deletaOrgao(id_orgao) {
      fetch(`/deleta-orgao?id_orgao=${id_orgao}`, {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.deleta) {
            this.selectOrgaos();
            notificacao.sucesso("Órgão deletado");
          }
        })
        .catch((error) => {
          notificacao.erro("Falhou");
        });
    },

    //em adicionar orgão, se tiver código de órgão, abre o input
    possuiCodigo() {
      const possuiCodigo = document.querySelector("#possui_codigo");
      const orgaoCodigo = document.querySelector("#orgao_codigo");
      const codigo = document.querySelector("#codigo");

      if (possuiCodigo.value === "s") {
        orgaoCodigo.classList.remove("d-none");
      } else {
        orgaoCodigo.classList.add("d-none");
        codigo.value = "";
      }
    },
  };
}
