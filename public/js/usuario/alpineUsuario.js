function alpineUsuario() {
  return {
    usuarioLista: [],
    pesquisaUsaurio: "",
    async listaUsuario() {
      try {
        const url = this.pesquisaUsaurio
          ? `/lista-usuario?pesquisa=${encodeURIComponent(
              this.pesquisaUsaurio
            )}`
          : `/lista-usuario`;

        const response = await fetch(url);

        if (!response.ok) {
          throw new Error("Erro na requisição");
        }

        const data = await response.json();

        this.usuarioLista = data;
      } catch (error) {
        console.log("Error");
      }
    },
    mudarSituacaoUsuario(id_usuario, event) {
      const isChecked = event.target.checked;
      fetch("/mudar-situacao-usuario", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id_usuario: id_usuario,
          checked: isChecked,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            this.listaUsuario();
            notificacao.sucesso("Usuario alterado");
          } else {
            notificacao.erro("Falhou");
          }
        })
        .catch((error) => {
          console.error("Error");
        });
    },
  };
}
