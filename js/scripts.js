//verificar depois
function activeElemts(){
    const optElem = document.getElementsByTagName("<a></a>");
    
    if(elemento.classList)
        optElem.classList.add("active");
    else
        optElem.className += " active";

}

function getOffset(el) {
    const rect = el.getBoundingClientRect();
    return {
      left: rect.left + window.scrollX,
      top: rect.top + window.scrollY
    };
  }