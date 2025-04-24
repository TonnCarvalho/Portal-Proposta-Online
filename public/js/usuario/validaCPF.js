function validaCPF() {
  d = document.valida_cpf;

  var strCPF = d.cpf.value;
  const msgErroCPF = document.querySelector("#msgErroCPF");

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
    d.cpf.focus();
    return false;
  }

  Soma = 0;
  for (i = 1; i <= 10; i++)
    Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
  Resto = (Soma * 10) % 11;

  if (Resto == 10 || Resto == 11) Resto = 0;
  if (Resto != parseInt(strCPF.substring(10, 11))) {
    msgErroCPF.classList.remove("d-none");
    d.cpf.focus();
    return false;
  }
  msgErroCPF.classList.add("d-none");
  return true;
}
