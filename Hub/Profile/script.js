
var btnPool = document.getElementById("btnAddPool");
var hrefPool = btnPool.getAttribute("href");
function consultaLink() {
    if (hrefPool == "") {
        btnPool.classList.add('hover:bg-red-700')
        btnPool.classList.remove('hover:bg-slate-400/[0.4]')
    }
    else {
        btnPool.classList.add('hover:bg-slate-400/[0.4]')
        btnPool.classList.remove('hover:bg-red-700')
        
    }
}
window.addEventListener('load', consultaLink())

function avisoConta() {
    if (hrefPool == "") {
        window.confirm("Não é possível adicionar novas piscinas \nPara adicionar uma nova piscina, adquira uma conta premium ou apague uma já existente!")
    }
}
