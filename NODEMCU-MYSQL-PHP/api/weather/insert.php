<?php
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//ARRAY JSON
$response = array();

//VERIFICANDO VARIÁVEIS RECEBIDAS
if (isset($_GET['temp']) && isset($_GET['hum'])){

  $temp = $_GET['temp'];
  $hum = $_GET['hum'];

  //INCLUINDO CONEXÃO COM A class CONEXÃO
  $filepath = realpath (dirname(__FILE__));
  require_once($filepath."/db_connect.php");

  //CONECTANDO COM BANCO
  $db = new DB_CONNECT();

  //SQL PARA INSERIR NA TABELA weather
  $result = mysql_query("INSERT INTO weather(temp,hum)values('$temp','$hum')");

  //VERIFICANDO SE QUERY INSERIDA COM SUCESSO
  if ($result){
    //INSERIDO COM SUCESSO
    $response["success"] = 1;
    $response["message"] = "Weather successfully creaded.";

    //RESPOSTA JSON
    echo json_encode($response);

  }else {
    //FALHA NO INSERT NO BANCO
    $response["success"] = 0;
    $response["success"] = "Something sas been wrong";

    //RESPOSTA DO JSON
    echo json_encode($response);

  }
  /*
  else{
    //SE PARAMETRO PERDIDO
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";

    //MOSTRA JSON RESPONSE
    echo json_encode($response);

  }
    */

}

?>
