// function createInvoice(){
//     var specialElementHandlers = {
//         '#editor': function (element, renderer) {
//             return true;
//         }
//     };

//     const doc = new jsPDF();
//     const relatorio = $("#relatorio").html();
//     doc.fromHTML(
//         relatorio,
//         15,
//         15,
//         {
//         'width': 180,'elementHandlers': specialElementHandlers
//         }
//     );
//     doc.autoTable({ html: '#table-relatorio' })
//     doc.output('dataurlnewwindow');
// }

// console.log('oi')
// const btnPdf = document.getElementById("btn-gerarpdf")
// console.log(btnPdf)
// btnPdf.onclick = () => createInvoice()

function getPDF() {
    var doc = new jsPDF("p", "pt");
   
    // We'll make our own renderer to skip this editor
    var specialElementHandlers = {
      '#getPDF': function(element, renderer){
        return true;
      },
      '.controls': function(element, renderer){
        return true;
      }
    };
  
    // All units are in the set measurement for the document
    // This can be changed to "pt" (points), "mm" (Default), "cm", "in"
    doc.fromHTML($('#relatorio').html(), 15, 15, {
      'width': 270,
      'elementHandlers': specialElementHandlers
    });
    // doc.autoTable({
    //     html: '#table-relatorio',
    //     columnStyles: {
    //       0: {cellWidth: 100},
    //       1: {cellWidth: 80},
    //       2: {cellWidth: 80},
    //     }
    //   });
  
    doc.save('dataurlnewwindow');
  }

  const btnPdf = document.getElementById("btn-gerarpdf")
  btnPdf.onclick = () => getPDF()