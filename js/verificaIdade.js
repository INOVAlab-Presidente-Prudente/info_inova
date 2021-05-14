function calculate_age(dob) { 
    var diff_ms = Date.now() - dob.getTime();
    var age_dt = new Date(diff_ms); 

    return Math.abs(age_dt.getUTCFullYear() - 1970);
}
function verificaIdade(dt) {
    var nd = new Date(dt.value.split("-"));
    var idade = calculate_age(nd);
    document.getElementById('idade').value = idade;
    if(idade<18) {
        document.getElementById('responsavel').style.display="flex";
    } else{
        document.getElementById('responsavel').style.display="none";
        document.getElementById('nomeResponsavel').value="";
        document.getElementById('telResponsavel').value="";
    }
        
}

verificaIdade(dataNascimento) // id dataNascimento