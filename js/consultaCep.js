function consultaCEP(CEP){
    if(CEP.length==9){
        document.getElementById('bairro').value = "...";
        document.getElementById('endereco').value = "...";
        document.getElementById('municipio').value = "...";

        var elemento = document.createElement('script');
        elemento.src = 'https://viacep.com.br/ws/'+ CEP + '/json/?callback=meu_callback';
        document.body.appendChild(elemento);
        console.log(elemento)
    }
}

function meu_callback(retorno){
    if(!("erro" in retorno)){
    document.getElementById('bairro').value = (retorno.bairro);
    document.getElementById('endereco').value = (retorno.logradouro);
    document.getElementById('municipio').value = (retorno.localidade);
    document.getElementById('estado').value = (retorno.uf);
    }else{
    document.getElementById('bairro').value = "";
    document.getElementById('endereco').value = "";
    document.getElementById('municipio').value = "";
    document.getElementById('estado').value = "";
    }
    
}


const geraSelects = (result, estado) => {
    var elem, indexAtual;
    var i = 0;
    const comboEstados = document.getElementById("estado");
    for(var j = 0; j < result.length; j++){
        elem = document.createElement("option");
        elem.value = result[j].sigla;
        elem.text = result[j].nome;
        if(result[j].sigla == estado)
          elem.selected = 'selected';
        comboEstados.add(elem, comboEstados.options[i++]);
    }
    comboEstados.value = estado;
}

function carregaEstados(estado){
    const options = {
        method: 'GET',
        mode: 'cors',
        cache: 'default'
    }

    fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome`, options)
    .then(response => {
        response.json()
        .then( data => {
            geraSelects(data, estado);
        } )
    })
    .catch(e => console.log('Deu erro: '+ e.message));
}