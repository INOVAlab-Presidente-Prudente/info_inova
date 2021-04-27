let cpf = document.getElementById("cpf")
let cep = document.getElementById("cep")
let rg = document.getElementById("rg")
let cnpj = document.getElementById("cnpj")
let telefone = document.getElementById("telefone")
if (cpf)
    cpf.onkeyup = () => cpf.value = cpf.value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/,"$1.$2.$3-$4")
if (cep)
    cep.onkeyup = () => cep.value = cep.value.replace(/^(\d{5})(\d{3}).*/,"$1-$2")
if (rg)
    rg.onkeyup = () => rg.value = rg.value.replace(/^(\d{2})(\d{3})(\d{3})(\d{1}).*/,"$1.$2.$3-$4")
if (cnpj)
    cnpj.onkeyup = () => cnpj.value = cnpj.value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2}).*/,"$1.$2.$3/$4-$5")
if (telefone)
    telefone.onkeyup = () => telefone.value = telefone.value.replace(/^(\d{2})(\d{5})(\d{4}).*/,"($1)$2-$3")