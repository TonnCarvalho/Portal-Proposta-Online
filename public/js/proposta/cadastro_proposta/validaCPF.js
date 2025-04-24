function validaCPF() {
  d = document.busca_cpf;

  var strCPF = d.cpfCadastro.value;
  const msgErroCPF = document.querySelector("#msgErroCPF");
  console.log(msgErroCPF);

  exp = /\.|\-/g;
  strCPF = strCPF.toString().replace(exp, "");

  var Soma;
  var Resto;
  Soma = 0;
  if (strCPF == "00000000000") return false;

  for (i = 1; i <= 9; i++)
    Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

  if (Resto == 10 || Resto == 11) Resto = 0;
  if (Resto != parseInt(strCPF.substring(9, 10))) {
    msgErroCPF.classList.remove("d-none");
    d.cpfCadastro.focus();
    return false;
  }

  Soma = 0;
  for (i = 1; i <= 10; i++)
    Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
  Resto = (Soma * 10) % 11;

  if (Resto == 10 || Resto == 11) Resto = 0;
  if (Resto != parseInt(strCPF.substring(10, 11))) {
    msgErroCPF.classList.remove("d-none");
    d.cpfCadastro.focus();
    return false;
  }

  const pracas = document.querySelector("#pracaCadastro");

  if (pracas.value == "") {
    pracas.classList.add("border-danger");
    return false;
  }

  return true;
}
