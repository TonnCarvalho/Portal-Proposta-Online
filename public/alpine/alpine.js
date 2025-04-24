import Alpine from "./module.esm.js";
import notificacao from "./notificacao.js";

window.notificacao = notificacao();
window.Alpine = Alpine;

Alpine.start();
