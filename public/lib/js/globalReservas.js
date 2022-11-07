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
                { "mData": "agentAsignado",
                    mRender:function( data, type, name ){
                      if(name.agentAsignado=="NA"){
                        var iconcolor="red";
                        var lbltitle="";
                      }else{
                        var iconcolor="green";
                        var lbltitle=name.agentAsignado;
                      }
                     var enlaces='<span class="fakehrefcolorless" onclick="assingAgents(\''+name.idReserva+'\')" title="'+lbltitle+'"><i class="user '+iconcolor+' icon"></i></span>';
                     return enlaces;
                    }
                },
                { "mData": "driverAsignado",
                    mRender:function( data, type, name ){
                      if(name.driverAsignado=="NA"){
                        var iconcolor="red";
                        var lbltitle="";
                      }else{
                        var iconcolor="green";
                        var lbltitle=name.driverAsignado;
                      }
                     var enlaces='<span class="" title="'+lbltitle+'"><i class="car '+iconcolor+' icon"></i></span>';
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

function assingAgents(cual,opc=0){
  if(opc!=0){
        $("#idDrvToAsing").dropdown('set selected',opc);
  }
  $(".asignagentmod").modal('show');
  $("#asignagentlbl").html(cual);
  $("#idResAtAsign").val(cual);
}
