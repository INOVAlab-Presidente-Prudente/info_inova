*** Variables ***
${MAIN_dados_pessoais}    xpath=//a[text()='Alterar Dados Pessoais']
${MAIN_alterar_senha}     xpath=//a[text()='Alterar Senha']
${MAIN_menu_usuario}      xpath=//a[@data-toggle='dropdown']
${MAIN_menu_sair}         xpath=//a[contains(text(),'Sair do sistema')]

*** Keywords ***
Esperar Pela Tela Principal
    Wait Until Page Contains    Seja bem-vindo ao InfoInova.

Checar Perfil "${perfil}"
    Clicar Menu Usuario
    Element Should Contain    xpath=//span/u    ${perfil}
    Sair Menu Usuario

Clicar Menu Usuario
    Click Element                    ${MAIN_menu_usuario}      
    Wait Until Element Is Visible    ${MAIN_dados_pessoais}
    Wait Until Element Is Visible    ${MAIN_alterar_senha}

Sair Menu Usuario
    Click Element                        ${MAIN_menu_usuario}
    Wait Until Element Is Not Visible    ${MAIN_dados_pessoais}
    Wait Until Element Is Not Visible    ${MAIN_alterar_senha}

Fazer Logout
    Clicar Menu Usuario
    Click Element          ${MAIN_menu_sair}