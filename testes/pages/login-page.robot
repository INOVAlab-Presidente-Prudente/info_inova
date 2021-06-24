*** Variables ***

*** Keywords ***

Aguardar Tela de Login
    Wait Until Page Contains            InfoInova
    Wait Until Page Contains Element    name=usuario
    Wait Until Page Contains Element    name=senha
    Wait Until Page Contains Element    name=entrar

Logar Com Usuario "${usuario}" e Senha "${senha}"
    Input Text        name=usuario    ${usuario}
    Input Password    name=senha      ${senha}
    Click Button      name=entrar