function showList(cual="full",filter=""){
  $("#datamaster").html('');
  $.ajax({
    url: "getDriverData",
    type: "POST",
    data: { "mode":cual ,"info" : filter},
    success: function(result){
      if(result=="[]"){
         $('#datamaster').html('<tr><td colspan="5" class="negative">Sin Informacion...</td></tr>');
       }else{
         aaData = jQuery.parseJSON(result);
         table = $('#example').dataTable({
           "bProcessing" : true,
           "destroy": true,
           "sPaginationType": "full_numbers",
           "aaData": aaData,
           "order" : [[ 0, "desc" ]],
           "columnDefs":[ { className: 'dt-body-center' } ],
           "aoColumns": [
             { "mData": "codeDriver",
             mRender:function( data, type, name ){
               var enlaces="<div class='fakehref' onclick='editDriver("+name.id+")'>"+name.codeDriver+"</div>";
               return enlaces;
             }
             },
             { "mData": "name"},
             { "mData": "email"},
             { "mData": "celphone"},
             { "mData": "status",
                 mRender:function( data, type, name ){
                   var enlaces="Activo";
                   if(name.status!=1){
                     var enlaces="Inactivo";
                   }
                   return enlaces;
                 }
             }
           ]
         });

       }
    },
    error: function(result){
        console.log(result);
    }
  });
}

function delAgent(cual){
  var confirmado=confirm("Seguro desea eliminar el conductor?");
  if(confirmado==true){
    console.log(userTarget);
    var campos={"id":userTarget,"code":$("#drvEdtCode").val()};
    $.ajax({
      url: "clearDriver",
      type: "POST",
      data: campos,
      success: function(result){
        console.log(result);
        if(result==1){
          tostadora(1,"Conductor eliminado correctamente");
          showList();
          $('.ui.viewEditDrvr.modal').modal('hide');
        }else{
          tostadora(4,"No se ejecuto la operacion, verifique su informacion");
        }
      },
      error: function(result){
        console.log(result);
      }
    });
  }else{
    console.log("Cancelado");
  }
}

function getInfoDriver(cual){
  $.ajax({
    url: "getDriverData",
    type: "POST",
    data: { "mode":"unique" ,"id" : cual},
    success: function(result){
        console.log(result);
        var datos=JSON.parse(result);
        datos=datos[0];
        $("#drvEdtCode").val(datos.codeDriver);
        $("#lbldrvEdtCode").html(datos.codeDriver);
        $("#drvEdtName").val(datos.name);
        $("#drvEdtEmail").val(datos.email);
        $("#drvEdtTel").val(datos.celphone);;
        $("#drvEdtStat").dropdown('set selected',datos.status);
    },
    error: function(result){
        console.log(result);
    }
  });

}
