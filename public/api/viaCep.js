const cep = document.querySelector("#cep");
const estado = document.querySelector("#uf");
const municipio = document.querySelector("#municipio");
const bairro = document.querySelector("#bairro");
const endereco = document.querySelector("#endereco");

// const cepTextValid = document.querySelector("[data-validCep]");

cep.addEventListener("focusout", async () => {
  const endPoint = `http://viacep.com.br/ws/${cep.value}/json/`;
  const dados = await fetch(endPoint);
  const enderecoCEP = await dados.json();

  console.log(cep.value.length);
  if (enderecoCEP.hasOwnProperty("erro")) {
    estado.value = "";
    municipio.value = "";
    bairro.value = "";
    endereco.value = "";
    cep.classList.add("border-danger");
    // cepTextValid.classList.remove("d-none");
  } else {
    preencherFormulario(enderecoCEP);
    cep.classList.remove("border-danger");
    // cepTextValid.classList.add("d-none");
  }
});

const preencherFormulario = (enderecoCEP) => {
  estado.value = enderecoCEP.uf;
  municipio.value = enderecoCEP.localidade;
  bairro.value = enderecoCEP.bairro;
  endereco.value = enderecoCEP.logradouro;
};

// Limpar campos se CEP for fazio
cep.addEventListener("focusout", () => {
  if (cep.value == "") {
    estado.value = "";
    municipio.value = "";
    bairro.value = "";
    endereco.value = "";
  }
});