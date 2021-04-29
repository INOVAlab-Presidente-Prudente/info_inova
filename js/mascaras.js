$("#cpf").mask('000.000.000-00', {reverse: false});
$("#rg").mask('00.000.000-A', {reverse: false});
$("#cep").mask('00000-000', {reverse: false});
$("#telefone").on("input", function() {
    if ($("#telefone").val()[4] == "9")
        $("#telefone").mask('(00)00000-0000', {reverse: false});   
    else 
        $("#telefone").mask('(00)0000-0000', {reverse: false}); 
}).trigger("input")
$("#telResponsavel").on("input", function() {
    if ($("#telResponsavel").val()[4] == "9")
        $("#telResponsavel").mask('(00)00000-0000', {reverse: false});   
    else 
        $("#telResponsavel").mask('(00)0000-0000', {reverse: false}); 
}).trigger("input")
$("#cnpj").mask('00.000.000/0000-00', {reverse: false});