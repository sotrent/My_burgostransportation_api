<?php
namespace Modules;

class EXPORTADOR{

  static function listCabeceras($opc){
    switch ($opc) {
      case 'rpgeneracion':
        $cabaceras=["idReservation",
        "Nombre",
        "Email",
        "Telefono",
        "Servicio",
        "Origen",
        "Destino",
        "Vehiculo",
        "Asientos",
        "Fecha",
        "Subtotal",
        "Tax",
        "Total",
        "Fecha Solicitud"
        ];
      break;
      default:
        $cabaceras=["NA"];
        break;
    }
    return $cabaceras;
  }


  static function makeFileXls($params){
    $campos='idReservation,CONCAT(fisrtName," ",lastName),email,mobile,typeService,originOnArrival,destinationOnArrival,vcode,pax,dateOnArrival,subtotal,tax,total,creationDate';
    switch ($params["report"]) {
      case 'generacion':
        $filtro="";
        if(!empty($params["btInicio"]) ){ $filtro=" WHERE `creationDate` >= '".$params["btInicio"]."'"; }
        if(!empty($params["btFin"])){
          if($filtro==""){
            $filtro=" WHERE `creationDatec` <= '".$params["btFin"]."'";
          }else{
            $filtro.=" and `creationDate` <= '".$params["btFin"]."'";
          }
        }
        $sql="SELECT $campos FROM `lst_reservations` $filtro";
      break;
      default:
        return "ERRs";
      break;
    }
    $result=DB::procesedQueryClear($sql);
    if(!$result){
      return "ERR";
    }
    $fixresult=json_encode($result);
    return $fixresult;
  }


  static function makePrintBinnacle($params){
    $campos=array('Fecha','Cliente','PAX','Tipo','Services','Flight Info','From','Destination','Conductor','Comentarios','Coordinador');
      $drawcampos="<tr>";
      foreach ($campos as $key => $value) {
        $drawcampos.="<th>".$value."</th>";
      }
      $drawcampos.="</tr>";
    return $drawcampos;
  }

}


?>
