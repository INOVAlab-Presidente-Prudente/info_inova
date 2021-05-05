function getPDF(nome) {
    var doc = new jsPDF("p", "pt");
   
    var specialElementHandlers = {
      '#getPDF': function(element, renderer){
        return true;
      },
      '.controls': function(element, renderer){
        return true;
      }
    };
  
    doc.fromHTML($('#info-1').html(), 15, 15, {
      'width': 270,
      'elementHandlers': specialElementHandlers
    });
    doc.fromHTML($('#info-2').html(), 15, 50, {
      'width': 270,
      'elementHandlers': specialElementHandlers
    });
    doc.autoTable({
        html: '#table-relatorio',
        columnStyles: {
          0: {cellWidth: 100},
          1: {cellWidth: 80},
          2: {cellWidth: 80},
        },
        margin: {
          top:150
        },
       });
       doc.setProperties({
        title: nome});
      //  doc.output("save", nome);
      window.open(doc.output("bloburl"));
  }

  const btnPdf = document.getElementById("btn-gerarpdf");