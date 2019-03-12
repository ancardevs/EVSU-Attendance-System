function InitOverviewDataTable()
{
  oOverviewTable =$('#HelpdeskOverview').dataTable(
  {
    "bPaginate": true,
    "bJQueryUI": true,  // ThemeRoller-stöd
    "bLengthChange": false,
    "bFilter": false,
    "bSort": false,
    "bInfo": true,
    "bAutoWidth": true,
    "bProcessing": true,
    "iDisplayLength": 10,
    "sAjaxSource": '/Helpdesk/ActiveCases/noacceptancetest'
  });
}

function RefreshTable(tableId, urlData)
{
  $.getJSON(urlData, null, function( json )
  {
    table = $(tableId).dataTable();
    oSettings = table.fnSettings();
    
    table.fnClearTable(this);

    for (var i=0; i<json.aaData.length; i++)
    {
      table.oApi._fnAddData(oSettings, json.aaData[i]);
    }

    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
    table.fnDraw();
  });
}

function AutoReload(tableId, urlData)
{
  RefreshTable(tableId, urlData);
 
  setTimeout(function(){AutoReload();}, 2000);
}

$(document).ready(function () {
  InitOverviewDataTable();
  setTimeout(function(){AutoReload();}, 2000);
});