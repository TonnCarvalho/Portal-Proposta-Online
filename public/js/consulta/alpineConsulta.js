function alpineConsulta() {
  return {
    consultas: Array.from({ length: 10 }, (_, index) => ({
      index: index + 1, // Índice da consulta
      nome: "",
      cpf: "",
      matricula: "",
      dataNascimento: "",
    })),
    praca: "",
  };
}
