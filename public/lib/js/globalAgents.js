function showList(cual="full",filter=""){
  $("#datamaster").html('');
  $.ajax({
    url: "getUserData",
    type: "POST",
    data: { "mode":cual ,"info" : filter},
    success: function(result){
       aaData = jQuery.parseJSON(result);
       table = $('#example').dataTable({
           "bProcessing" : true,
           "destroy": true,
           "sPaginationType": "full_numbers",
           "aaData": aaData,
           "order" : [[ 0, "desc" ]],
           "columnDefs":[ { className: 'dt-body-center' } ],
           "aoColumns": [
               { "mData": "user",
                   mRender:function( data, type, name ){
                     var enlaces="<div class='fakehref' onclick='editAgent("+name.id+")'>"+name.user+"</div>";
                     return enlaces;
                   }
               },
               { "mData": "name"},
               { "mData": "email"},
               { "mData": "tipo"},
               { "mData": "modules",
                    mRender:function( data, type, name ){
                      var permisos=name.modules;
                      var lstpermisos=permisos.split(";");
                      console.log(lstpermisos);
                      var checkicon="";
                      var cadena='<i class="check circle green icon"></i>';
                        for (var key in lstpermisos) {
                          if(lstpermisos[key]=="RES"){ cadena+=checkicon+'Reservas,&ensp;'; }
                          if(lstpermisos[key]=="ADM"){ cadena+=checkicon+'Administracion,&ensp;'; }
                          if(lstpermisos[key]=="DRV"){ cadena+=checkicon+'Conductores,&ensp;'; }
                          if(lstpermisos[key]=="BIN"){ cadena+=checkicon+'Bitacora,&ensp;'; }
                        }
                      return cadena;
                    }
               },
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
    },
    error: function(result){
        console.log(result);
    }
  });
}

function delAgent(cual){
  var confirmado=confirm("Seguro desea eliminar el usuario?");
  if(confirmado==true){
    console.log(userTarget);
    var campos={"id":userTarget,"code":$("#agtEdtCode").val()};
    $.ajax({
      url: "clearUser",
      type: "POST",
      data: campos,
      success: function(result){
        console.log(result);
        if(result==1){
          tostadora(1,"Usuario eliminado correctamente");
          showList();          
          $('.ui.viewEditAgnt.modal').modal('hide');
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

function getInfoAgent(cual){
  $.ajax({
    url: "getUserData",
    type: "POST",
    data: { "mode":"unique" ,"id" : cual},
    success: function(result){
        console.log(result);
        var datos=JSON.parse(result);
        datos=datos[0];
        $("#agtEdtCode").val(datos.user);
        $("#lblAgtEdtCode").html(datos.user);
        $("#agtEdtName").val(datos.name);
        $("#agtEdtEmail").val(datos.email);
        $("#agtEdtPass").val("******");
        $("#agtEdtTipo").dropdown('set selected',datos.tipo);
        $("#agtEdtStat").dropdown('set selected',datos.status);
    },
    error: function(result){
        console.log(result);
    }
  });

}
