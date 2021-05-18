//verificar depois
function activeElemts(){
    const optElem = document.getElementsByTagName("<a></a>");
    
    if(elemento.classList)
        optElem.classList.add("active");
    else
        optElem.className += " active";

}

const geraSelects = (result) => {
    var elem;
    var i = 0;
    const comboEstados = document.getElementById("estado");
    for(var j = 0; j < result.length; j++){
        elem = document.createElement("option");
        elem.value = result[j].sigla;
        elem.text = result[j].nome;
        comboEstados.add(elem, comboEstados.options[i++]);
    }
}

function carregaEstados(){
    const options = {
        method: 'GET',
        mode: 'cors',
        cache: 'default'
    }

    fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome`, options)
    .then(response => {
        response.json()
        .then( data => {
            geraSelects(data);
        } )
    })
    .catch(e => console.log('Deu erro: '+ e.message));
}