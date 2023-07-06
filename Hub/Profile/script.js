
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

function deletePool(divPai, button) {
    if (divPai.innerText.trim() === "") {
        button.classList.add('invisible');
        button.classList.remove('visible');
    } else {
        button.classList.add('visible');
        button.classList.remove('invisible');
    }
}

//remove e adiciona a classe truncate no nav bar
// truncate: não deixa o texto vazar da div pai
function addTruncate() {
    document.getElementById("email").classList.add("truncate");
}

function removeTruncate() {
    document.getElementById("email").classList.remove("truncate");
}

window.addEventListener('load', consultaLink())
window.addEventListener('load', deletePool(document.getElementById("pool1"), document.getElementById("btnPool1")))
window.addEventListener('load', deletePool(document.getElementById("pool2"), document.getElementById("btnPool2")))
window.addEventListener('load', deletePool(document.getElementById("pool1"), document.getElementById("editBtn1")))
window.addEventListener('load', deletePool(document.getElementById("pool2"), document.getElementById("editBtn2")))

function avisoConta() {
    if (hrefPool == "") {
        window.confirm("Não é possível adicionar novas piscinas \nPara adicionar uma nova piscina, adquira uma conta premium ou apague uma já existente!")
    }
}

