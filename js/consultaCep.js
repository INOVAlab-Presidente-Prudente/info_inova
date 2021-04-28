
function consultaCEP(CEP){
    if(CEP.length==9){
        document.getElementById('bairro').value = "...";
        document.getElementById('endereco').value = "...";
        document.getElementById('municipio').value = "...";

        var elemento = document.createElement('script');
        elemento.src = 'https://viacep.com.br/ws/'+ CEP + '/json/?callback=meu_callback';
        document.body.appendChild(elemento);
    }
}

function meu_callback(retorno){
    if(!("erro" in retorno)){
    document.getElementById('bairro').value = (retorno.bairro);
    document.getElementById('endereco').value = (retorno.logradouro);
    document.getElementById('municipio').value = (retorno.localidade);
    }else{
    document.getElementById('bairro').value = "";
    document.getElementById('endereco').value = "";
    document.getElementById('municipio').value = "";
    }
    
}
