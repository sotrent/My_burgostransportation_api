<?php
function check_session(){
  session_start();
  if(!isset($_SESSION['code'])){
    $app=\Slim\Slim::getInstance();
    $app->redirect('/login');
  }
}
