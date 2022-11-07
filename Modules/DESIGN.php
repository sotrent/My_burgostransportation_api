<?php
namespace Modules;
//use \mysqli;
class DESIGN{

  static function renderMenuDesk($quien){
    $activos=[];
    for ($i=0; $i <=7 ; $i++) {
      $activos[$i]="";
    }
    $activos[$quien]="active";
    //print_r($activos);
    $nick="USER";
    if(!empty($_SESSION["nick"])){
      $nick=$_SESSION["nick"];
    }
    if(!empty($_SESSION["submodules"])){
      $submodulesRAW=$_SESSION["submodules"];
    }
    $submodules=json_decode($submodulesRAW);
    //print_r($submodules);

    $seccADM='';
    $admAGT="";
    $smADM=AUTH::checkPermisos("ADM","AGT");
    if($smADM=="W" || $smADM=="L"){
      $admAGT='<a href="/managment_agents" target="principal" class="borderless item"><span class="standarItem"> <i class="cogs subtitleBlue icon"></i></span></a>';
    }
    $seccADM=$admAGT;

    $seccDRV='';
    $smDRV=AUTH::checkPermisos("DRV","CAT");
    if($smDRV=="W" || $smDRV=="L"){
      $seccDRV='<a href="/managment_drivers" target="principal" class="borderless item"><span class="standarItem"> <i class="car large icon"></i></span>Conductores</a>';
    }

    $seccBIN='';
    $smBIN=AUTH::checkPermisos("BIN","OPC");
    if($smBIN=="W" || $smBIN=="L"){
      $seccBIN='<a href="/managment_binnacle" target="principal" class="borderless item"><span class="standarItem"> <i class="clipboard large icon"></i></span>Bitacora</a>';
    }





    $menu=<<<cad
      <div class="ui top fixed menu">
        <div class="left  menu">
          <div class="ui simple dropdown borderless item itemsMenuPpal">
            <i class="ui bars large subtitleBlue icon"></i>
            <div class="menu">
              <a href="/catReservas" target="principal" class="borderless item">
                <span class="standarItem"> <i class="address book large icon"></i>Reservas</span>
              </a>
              $seccDRV
              $seccBIN
            </div>
          </div>
        </div>
        <div class="center borderless item">
          <img src="https://brownsprivateservices.com/wp-content/uploads/2018/10/Browns-Private-Services-Icon.png" style="width:20px;max-width:20px">
          <span class="subtitleBlack">&ensp;Administracion</span>
        </div>
        <div class="right menu">
          <!--<a class="borderless item" title="Notificaciones">&ensp;<i class="ui bell grey icon"></i></a>-->
          <a class="borderless item" title="Configuracion">&ensp;<i class="ui user subtitleBlue icon"></i><b class="subtitleBlue">&ensp;$nick&ensp;</b></a>
          $seccADM
          <a href="/logout" class="borderless item" title="Cerrar Session">&ensp;<i class="ui power off grey icon"></i></a>
        </div>
      </div>

cad;

  return $menu;
  }

  static function getBasicLibrary(){
    $libarys=<<<cad
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="/lib/sem/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="/lib/css/general.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Source+Sans+Pro" rel="stylesheet">
    <script src="/lib/js/jquery-3.1.1.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
    <script src="/lib/sem/semantic.min.js"></script>
    <script src="/lib/js/general.js"></script>
cad;
    return $libarys;
  }

  static function getExtendedLibrary(){
    $libs=<<<libs
      <script src="/lib/js/global.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
      <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
      <link href="/lib/css/toastr.min.css" rel="stylesheet"/>
      <script src="/lib/js/toastr.min.js"></script>
      <script src="/lib/js/calendas.js"></script>
libs;
  return $libs;
  }

    static function getExtendedLibraryNotGlobal(){
      $libs=<<<libs
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <link href="/lib/css/toastr.min.css" rel="stylesheet"/>
        <script src="/lib/js/toastr.min.js"></script>
        <script src="/lib/js/calendas.js"></script>
  libs;
    return $libs;
    }




}

?>
