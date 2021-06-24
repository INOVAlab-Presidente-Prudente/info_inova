*** Variables ***
${APP URL}    http://127.0.0.1
${BROWSER}    Chrome
# Usar a opcao abaixo para executar headless
# ${BROWSER}    headlesschrome

*** Keywords ***
Abrir Browser
    Open Browser                ${APP URL}    ${BROWSER}
    Maximize Browser Window
