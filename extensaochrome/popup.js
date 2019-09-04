oTabela = document.createElement('table');
aData = [];
$('input[name^="container:listaPontosContainer"]').each(function (index, el) {

  var oTr = $(el).closest('tr');
  var oTable = $(oTr).closest('table');
  var oTrData = '';
  var bSairForeach = false;
  $(oTable).find('tr').each(function (index2, el) {
    if ($(el).hasClass('folhaponto-header') && !bSairForeach) {
      oTrData = el;
    }
    if ($(oTr).index() == $(el).index()) {
      bSairForeach = true;
    }
  });
  var sPontoHora = $(el).val();
  var sPontoDia = $('td > span', oTrData).get(1).innerHTML;
  oTrTabela = document.createElement('tr');
  oTdTabela1 = document.createElement('td');
  oTdTabela1.innerHTML = sPontoDia;
  oTdTabela2 = document.createElement('td');
  oTdTabela2.innerHTML = sPontoHora;
  oTrTabela.appendChild(oTdTabela1);
  oTrTabela.appendChild(oTdTabela2);
  oTabela.appendChild(oTrTabela);
  aData.push([{v: sPontoDia, t: 's'}, {v: sPontoHora, t: 's'}]);
});
$('#minha-tabela-teste').detach();
oTabela.id = 'minha-tabela-teste';
document.body.appendChild(oTabela);
var oTableXlsx2 = $('#minha-tabela-teste').tableExport({
  formats: ['xlsx'],
  exportButtons: false
});

console.log(aData);
oTableXlsx2.export2file(aData, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'pontos', ' xlsx');
$('#minha-tabela-teste').detach();
