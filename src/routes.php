<?php
//######################## NAVEGACION ###############################
$app->get('/','check_session',function() use($app){
  $app->render('home.phtml');
});

$app->get('/configuracion','check_session',function() use($app){ //Verficar
  $itsOk=strpos($_SESSION["modules"], 'AGV');
  if($itsOk!==false){
    $app->render('catalogos.phtml');
  }else{
    $app->render('sinPermiso.phtml');
  }
});
//###################################################################

//###########################RESERVAS###############################
$app->get('/catReservas','check_session',function() use($app){
  $itsOk=strpos($_SESSION["modules"], 'RES');
  $app->render('catReservas.phtml');
});

$app->map('/getInfoReservas',function() use($app){
  $filtros="";
  if(!empty($_POST)){  $filtros=$_POST;  }
  //print_r($_POST);
  $resp=Modules\RESERVAS::getInfoReservas($filtros);
  $json=json_encode($resp);
  if($resp=="ERR"){
    $json="[]";
  }
  print_r($json);
})->via(['GET','POST']);
//###################################################################

//###########################AGENTES###############################
$app->get('/managment_agents','check_session',function() use($app){
  $itsOk=strpos($_SESSION["modules"], 'RES');
  $app->render('agentes.phtml');
});

$app->map('/setUserData',function() use($app){
  $resp="ERR";
  if(empty($_POST["agtEdtOpc"])){
    if(!empty($_POST["agtOpc"])){
      if($_POST["agtOpc"]=="nuevo"){ $resp=Modules\AGENTS::setAgent($_POST); }
    }
  }else{
    if($_POST["agtEdtOpc"]=="editAgent"){ $resp=Modules\AGENTS::editAgent($_POST); }
  }
  print_r($resp);
})->via(['GET','POST']);

$app->map('/getUserData',function() use($app){
  $resp=Modules\AGENTS::getList($_POST);
  $json=json_encode($resp);
  if($resp=="ERR"){
    $json="[]";
  }
  print_r($json);
})->via(['GET','POST']);

$app->map('/clearUser',function() use($app){
  print_r(Modules\AGENTS::delAgent($_POST));
})->via(['GET','POST']);

$app->map('/asingAgentToRes',function() use($app){
  $resp=Modules\RESERVAS::asingAgentToRes($_POST);
  if($resp!=1){ $resp=="ERR"; }
  print_r($resp);
})->via(['GET','POST']);

$app->map('/print/binnacle(/:codigo)',function($codigo="") use($app){

  $params["code"]=$codigo;
  $campos=Modules\EXPORTADOR::makePrintBinnacle($params);
  $registros=Modules\BITACORA::getDetBinnacle($params);
  $css='<style>@page{ size:A4;  margin: 0; size: landscape; }
  header, footer, aside, nav, form, iframe, .menu, .hero, .adslot {
    display: none;
  }
  table, th, td {
    border: 1px solid #000;
    border-collapse: collapse;
  }
  table{}
  th{ font-weight:bold; }
  td{ font-size: 8pt; }
  .tp3{ text-align: center; }
  </style>';

  echo $css;
  //echo $campos;
//  print_r($registros);
  echo '<br/><table style="width:100%; ">';
  print_r($campos);

  foreach ($registros as $key => $value) {
    echo "<tr>";
    echo "<td>".$value["fecha"]."</td>";
    echo "<td>".$value["name"]."</td>";
    echo "<td class='tp3'>".$value["pax"]."</td>";
    echo "<td>".$value["tipo"]."</td>";
    echo "<td>".$value["service"]."</td>";
    echo "<td>".$value["flinfo"]."</td>";
    echo "<td>".$value["origin"]."</td>";
    echo "<td>".$value["destination"]."</td>";
    echo "<td>".$value["conductor"]."</td>";
    echo "<td>".$value["comments"]."</td>";
    echo "<td>".$value["cordinator"]."</td>";
    echo "</tr>";

  //print_r($value["id"]);

  }


  echo '</table>';
  echo "<script>window.print()</script>";
})->via(['GET','POST']);
//###################################################################

//########################### CONDUCTORES ###############################
$app->get('/managment_drivers','check_session',function() use($app){
  $itsOk=strpos($_SESSION["modules"], 'DRV');
  $app->render('drivers.phtml');
});

$app->map('/getDriverData',function() use($app){
  $resp=Modules\DRIVERS::getList($_POST);
  if($resp=="ERR" || $resp==""){
    $json="[]";
  }else{
    $json=json_encode($resp);
  }
  print_r($json);
})->via(['GET','POST']);

$app->map('/setDriverData',function() use($app){
  $resp="ERR";
  if(empty($_POST["drvEdtOpc"])){
    if(!empty($_POST["drvOpc"])){
      if($_POST["drvOpc"]=="nuevo"){ $resp=Modules\DRIVERS::setDriver($_POST); }
    }
  }else{
    if($_POST["drvEdtOpc"]=="editDriver"){ $resp=Modules\DRIVERS::editDriver($_POST); }
  }
  print_r($resp);
})->via(['GET','POST']);

$app->map('/clearDriver',function() use($app){
  print_r(Modules\DRIVERS::delDriver($_POST));
})->via(['GET','POST']);
//###################################################################

//########################### BITACORA ###############################
$app->get('/managment_binnacle','check_session',function() use($app){
  $itsOk=strpos($_SESSION["modules"], 'DRV');
  $app->render('bitacora.phtml');
});

$app->map('/getCatBinnacle',function() use($app){
  $filtros="";
  if(!empty($_POST)){
    $filtros=$_POST;
  }
  $resp=Modules\BITACORA::getListBinnacle($_POST);
  if($resp=="ERR" || $resp==""){
    $json="[]";
  }else{
    $json=json_encode($resp);
  }
  print_r($json);
})->via(['GET','POST']);

$app->map('/asingDriverToRes',function() use($app){
  $resp=Modules\RESERVAS::asingDriverToRes($_POST);
  if($resp!=1){ $resp=="ERR"; }
  print_r($resp);
})->via(['GET','POST']);

$app->map('/setNewBinnacle',function() use($app){
  $resp=Modules\BITACORA::setNewBinnacle($_POST);
  //if($resp!=1){ $resp=="ERR"; }
  print_r($resp);
})->via(['GET','POST']);

$app->map('/getDetBinnacle',function() use($app){
  $filtros="";
  if(!empty($_POST)){ $filtros=$_POST; }
  $resp=Modules\BITACORA::getDetBinnacle($_POST);
  if($resp=="ERR" || $resp==""){
    $json="[]";
  }else{
    $json=json_encode($resp);
  }
  print_r($json);
})->via(['GET','POST']);

//###################################################################

//########################### SESSION ###############################
$app->post('/verifica', function ()use($app){
  $user=strtoupper($_POST['user']);
  $contra=$_POST['contra'];
  $resultado=Modules\AUTH::exist($user,$contra);
  switch ($resultado) {
    case '200':
      $rest=Modules\AUTH::initsess($user,$contra);
      $app->redirect('/');
    break;
    case '404':
      $errlog=4;
      $app->render('login.phtml', compact('errlog'));
    break;
    case '401':
      $errlog=3;
      $app->render('login.phtml', compact('errlog'));
    break;
  }
  //$app->render('login.phtml');
});
$app->get('/logout',function() use($app){
  $rest=Modules\AUTH::crushsesion();
  $app->render('login.phtml');
});

$app->map('/login(/:id)', function ($id="")use($app){
  $app->render('login.phtml');
})->via(['GET','POST']);
//###################################################################

//######################### SESSION #################################
$app->get('/updateSession','check_session',function() use($app){
  $_SESSION["UPTIME"]=date("Y-m-d H:i:s");
  print_r($_SESSION["UPTIME"]);
  return $_SESSION["UPTIME"];
});
//###################################################################

$app->map('/exportador(/:nomfile)(/:tipo)(/)',function($nomfile="reporte",$tipo="xls") use($app){
  if(!empty($_POST["nomfile"])){ $nomfile=$_POST["nomfile"]; }
  $errmsg="<b style='color:#ff5406'>Error al generar archivo, Verifica tus datos A</b>";
  //print_r($resp);  //print_r($_POST);
  //$module=$_POST["modulo"];
  $module="rpgeneracion";
  $nomfile="Reservas-BRWN".date('Ymd');
  if(empty($_POST["report"])){ echo $errmsg; return true; }
  if(empty($module)){ echo $errmsg; return true; }
  $cabeceras=Modules\EXPORTADOR::listCabeceras($module);
  $lstCab="";
  foreach ($cabeceras as $key => $value) {
    $lstCab.=<<<table
        <th>{$value}</th>
table;
  }

  $resp=Modules\EXPORTADOR::makeFileXls($_POST);
  if($resp=="ERR"){
    echo "<b style='color:#ff5406'>Error al generar archivo, Verifica tus datos B</b>";
    return true;
  }
  $json=json_decode($resp);

  //print_r($resp); return true;
  header ( "Content-type: application/vnd.ms-excel" );
  header ( "Content-Disposition: attachment; filename=$nomfile.$tipo" );
  echo '<table>
  <thead align="center">
    <tr align="center">
      '.$lstCab.'
    </tr>
  </thead>';
  $table="";
  foreach ($json as $key => $value) {
    $table.="<tr>";
    foreach ($value as $key2 => $value2) {
      $table.="<td>{$value2}</td>";
    }
    $table.="</tr>";
  //  echo $table;
}
  echo($table);
  echo "</table>";
  return true;
})->via(['GET','POST']);
//###################################################################

//######################### GENERALES ###############################
$app->get('/myDATAUSER','check_session',function() use($app){
  print_r($_SESSION["nick"]);

  /////// Agents

  /// Get Agentes
  //print_r(Modules\AGENTS::getList());

  /// Set Agentes
  /*
  $param["code"]="agent2";
  $param["nombre"]="Agente 2 Test";
  $param["email"]="agetne@blabla.com";
  $param["area"]="Atencion a Clientes";

  print_r(Modules\AGENTS::setAgent($param));
  */
  ///////////////////////

  /// Del Agentes
  //$param["id"]=3;
  //$param["code"]="agent2";
  //print_r(Modules\AGENTS::delAgent($param));
  ///////////////////////


  /*
  if(!empty($_SESSION["submodules"])){
    $submodulesRAW=$_SESSION["submodules"];
  }
  $submodules=json_decode($submodulesRAW);
print_r($submodules);

  $modulo="ADM";
  $nivel="AGT";
  if(!empty($submodules->$modulo)){
    $permisos=$submodules->$modulo;
    $permiso=$permisos->$nivel;
    print_r($submodules->$modulo);
    print_r($permiso);
  }*/

  ///////////////
  /* Funcion Sacar Permisos*/ ///////////////////
  $resp=Modules\AUTH::checkPermisos("ADM","AGT");
    print_r($resp);
  ///////////////

});

$app->notFound(function () use ($app) {
  //$app->render('404.phtml');
  $app->redirect('/');
});
//###################################################################
