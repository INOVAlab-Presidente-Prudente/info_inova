*** Settings ***
Documentation    Teste do login e logout
Library          SeleniumLibrary            

Resource    configuracoes.robot
Resource    pages/login-page.robot
Resource    pages/main-page.robot

# Suite Setup
Test Setup        Abrir Browser         
Test Teardown     Close Browser
Suite Teardown    Close All Browsers


*** Test Cases ***
Login Como Admin
    Aguardar Tela de Login
    Logar Com Usuario "user1" e Senha "aaa"
    Esperar Pela Tela Principal
    Checar Perfil "Administrador"
    Fazer Logout
    Aguardar Tela de Login

Login Como Usuario
    Aguardar Tela de Login
    Logar Com Usuario "outrouser" e Senha "bbb"
    # TODO
