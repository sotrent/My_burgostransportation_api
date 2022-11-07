var bitacora={"reservas":[],"inicio":"","fin":"","nombre":"","comentarios":"","stat":""};
var codebinactual="";
function cleanObjBitacora(){
  bitacora={"reservas":[],"inicio":"","fin":"","nombre":"","comentarios":"","stat":""};
}

function addToBinnacle(cual,quien){
  if(document.getElementById("chk_"+cual).checked == true){
    bitacora.reservas.push(quien);
  }else{
    bitacora.reservas = bitacora.reservas.filter(item => item !== quien);
  }
  console.log(bitacora);
}

function changeViewBin(cual){
  switch (cual) {
    case 'construir':
      $(".groupsections").hide();
      $("#sectionSelRes").show();
    break;
    case 'catalogo':
      $(".groupsections").hide();
      $("#sectionListBin").show();
    break;
    case 'detalle':
      $(".groupsections").hide();
      $("#sectionDetBin").show();
    break;
  }
}

function showListBin(cual="",filter=""){
  var modeList='default';
  $.ajax({
    url: "getCatBinnacle",
    type: "POST",
    data: { "tipo":cual ,"info" : filter, "modeVersion":modeList},
    success: function(result){
       aaData = jQuery.parseJSON(result);
       table = $('#listadoBitacoras').dataTable({
           "bProcessing" : true,
           "destroy": true,
           "sPaginationType": "full_numbers",
           "aaData": aaData,
           "order" : [[ 0, "desc" ]],
           "columnDefs":[ { className: 'dt-body-center' } ],
           "aoColumns": [
               { "mData": "code",
                   mRender:function( data, type, name ){
                    var enlaces="<div class='fakehref' onclick='editBin(\'"+name.code+"\')'>"+name.code+"</div>";
                    return enlaces;
                   }
               },
               { "mData": "nameBinnacle"},
               { "mData": "dateStart",
                    mRender:function( data, type, name ){
                      if(name.dateStart=="0000-00-00"){
                        var enlaces='NA';
                      }else{
                        var enlaces=name.dateStart;
                      }
                     return enlaces;
                    }
               },
               { "mData": "dateEnd",
                    mRender:function( data, type, name ){
                      if(name.dateStart=="0000-00-00"){
                        var enlaces='NA';
                      }else{
                        var enlaces=name.dateStart;
                      }
                     return enlaces;
                    }
               },
               { "mData": "status"},
               { "mData": "comment"},
               { "mData": "ownerCode"},
               { "mData": "driverAsignado",
                    mRender:function( data, type, name ){
                     var enlaces='<div class="fakehrefcolorless subtitleBlue" title="Detalles" align="center" onclick="showDetailsBin(\''+name.code+'\')"><i class="eye icon"></i></div>';
                     return enlaces;
                    }
               }
           ]
       });
       //endCarga();
    },
    error: function(result){
        console.log(result);
    }
  });
}

function showDetailBin(cual="",filter=""){
  var modeList='default';
  $.ajax({
    url: "getDetBinnacle",
    type: "POST",
    data: { "code":cual ,"info" : filter},
    success: function(result){
       aaData = jQuery.parseJSON(result);
       table = $('#idBitacoraDetalle').dataTable({
           "bProcessing" : true,
           "destroy": true,
           "sPaginationType": "full_numbers",
           "aaData": aaData,
           "order" : [[ 0, "desc" ]],
           "columnDefs":[ { className: 'dt-body-center' } ],
           "aoColumns": [
               { "mData": "codeBinnacle"},
               { "mData": "fecha"},
               { "mData": "name"},
               { "mData": "pax"},
               { "mData": "tipo"},
               { "mData": "service"},
               { "mData": "flinfo"},
               { "mData": "origin"},
               { "mData": "destination"},
               { "mData": "conductor"},
               //{ "mData": "codeBinnacle"},
               { "mData": "comments"},
               { "mData": "cordinator"}
           ]
       });
       //endCarga();
    },
    error: function(result){
        console.log(result);
    }
  });
}


function showDetailsBin(cual){
  codebinactual=cual;
  showDetailBin(cual);
  $("#identificadorDetBin").html(cual);
  changeViewBin('detalle');

}


function showList(cual,filter){
  var modeList='default';
  $.ajax({
    url: "getInfoReservas",
    type: "POST",
    data: { "tipo":cual ,"info" : filter, "modeVersion":modeList},
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
               { "mData": "idReserva",
                   mRender:function( data, type, name ){
                    var enlaces="<input type='checkbox' onclick='addToBinnacle("+name.id+",\""+name.idReserva+"\")' id='chk_"+name.id+"'>";
                    return enlaces;
                   }
               },
               { "mData": "idReserva",
                   mRender:function( data, type, name ){
                    var enlaces="<div class='fakehref' onclick='showRegister("+name.id+")'>"+name.idReserva+"</div>";
                    return enlaces;
                   }
               },
               { "mData": "firstName",
                   mRender:function( data, type, name ){
                    var enlaces=name.nombre+' '+name.apellido;
                    return enlaces;
                   }
               },
               { "mData": "email"},
               { "mData": "mobile"},
               { "mData": "servicio"},
               { "mData": "origenA",
                   mRender:function( data, type, name ){
                     if(name.servicio=="One Way"){
                       if (name.isAirlineArr==0 && name.isAirlineDep==1){
                         var enlaces=name.origenB;
                       }else{
                         var enlaces=name.origenA;
                       }
                     }else{
                       var enlaces=name.origenA;
                     }
                    return enlaces;
                   }
               },
               { "mData": "destinoA",
                   mRender:function( data, type, name ){
                     if(name.servicio=="One Way"){
                       if (name.isAirlineArr==0 && name.isAirlineDep==1){
                         var enlaces=name.destinoB;
                       }else{
                         var enlaces=name.destinoA;
                       }
                     }else{
                       var enlaces=name.destinoA;
                     }
                     return enlaces;
                   }
               },
               { "mData": "vcode"},
               { "mData": "seats"},
               { "mData": "pickupA",
                   mRender:function( data, type, name ){
                     if(name.servicio=="One Way"){
                       if (name.isAirlineArr==0 && name.isAirlineDep==1){
                         var enlaces=name.pickupB;
                       }else{
                         var enlaces=name.pickupA;
                       }
                     }else{
                       var enlaces=name.pickupA;
                     }
                     return enlaces;
                   }
                },

               { "mData": "isPrepay",
                   mRender:function( data, type, name ){
                     if(name.isPrepay==1){
                       var enlaces="<div align='center'><i class='credit card green icon'></i></div>";
                     }else{
                       var enlaces="<div align='center'><i class='money bill alternate icon'></i></div>";
                     }
                    return enlaces;
                   }
                },

                { "mData": "total",
                   mRender:function( data, type, name ){
                    var enlaces="<div align='right'><b>$"+name.total+" USD</b></div>";
                    return enlaces;
                   }
                },
                { "mData": "driverAsignado",
                    mRender:function( data, type, name ){
                      if(name.driverAsignado=="NA"){
                        var iconcolor="red";
                        var lbltitle="";
                        var activateEditfilter="";
                      }else{
                        var iconcolor="green";
                        var lbltitle=name.driverAsignado;
                        var activateEditfilter=",'"+name.driverAsignado+"'";
                      }
                     var enlaces='<span class="fakehrefcolorless" onclick="assingDriver(\''+name.idReserva+'\' '+activateEditfilter+' )" title="'+lbltitle+'"><i class="car '+iconcolor+' icon"></i></span>';
                     return enlaces;
                    }
                }
           ]
       });
       //endCarga();
    },
    error: function(result){
        console.log(result);
    }
  });
}

function assingDriver(cual,opc=0){
  if(opc!=0){
        $("#idDrvToAsing").dropdown('set selected',opc);
  }
  $(".asigndrivermod").modal('show');
  $("#asigndriverlbl").html(cual);
  $("#idResAtAsign").val(cual);
}

function showRegister(cual){
  var modeList='default';
  $.ajax({
    url: "getInfoReservas",
    type: "POST",
    data: { "tipo":"especific" ,"info" : cual, "modeVersion":modeList},
    success: function(result){
      if(result=="ERR"){

      }else{
        setViewData(result);
        showReserva();
      }
    },
    error: function(result){
        console.log(result);
    }
  });

}

function setViewData(data){
  datos=JSON.parse(data);
  datos=datos[0];
  //console.log(datos);
  $("#inIdRes").html(datos.idReservation);
  $("#inZona").html(datos.zoneName);
  $("#inServicio").html(datos.typeService);
  $("#inVehicle").html(datos.vehicleName);
  $("#inAdults").html(datos.adults);
  $("#inKids").html(datos.kids);
  $("#inClie").html(datos.fisrtName+' '+datos.lastName);
  $("#inEmail").html(datos.email);
  $("#inTel").html(datos.mobile);

  $("#inArrOrigen").html(datos.originOnArrival);
  $("#inArrDestino").html(datos.destinationOnArrival);
  $("#inDtArrPickup").html(datos.dateOnArrival);
  $("#inArrAirline").html(datos.airlineArrival);
  $("#inArrFlight").html(datos.flightArrival);
  $("#inDtArrAirPick").html(datos.dateAirlineArrival);

  $("#inDepOrigen").html(datos.originOnDeparture);
  $("#inDepDestino").html(datos.destinationOnDeparture);
  $("#inDtDepPickup").html(datos.dateOnDeparture);

  $("#inDepAirline").html(datos.airlineDeparture);
  $("#inDepFlight").html(datos.flightDeparture);
  $("#inDtDepAirPick").html(datos.dateAirlineDeparture);

  $("#inTotal").html(datos.total);

  if(datos.isStop==1){
    var tempInfo="Si";
  }else{
    var tempInfo="No";
  }
  $("#inStop").html(tempInfo);
  $("#inChildSeat").html(datos.carSeat);
  $("#inBoosterSeat").html(datos.boosterSeat);

  if(datos.isComplete==1){
    $("#inEstatusADD").html("Concluida");
  }else{
    $("#inEstatusADD").html("No Concluida");
  }

  if(datos.isPrepay==1){
    $("#inEstatusPAY").html("Prepago");
  }else{
    $("#inEstatusPAY").html("Sitio");
  }


}
