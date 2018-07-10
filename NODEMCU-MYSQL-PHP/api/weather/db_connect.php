<?php
/**
 *
 */
class DB_CONNECT {

    //CONSTRUTOR
    function __construct(){
        //CONEXÃO
        $this->connect();
    }

    //DESCONSTRUTOR
    function __destruct(){
        //FECHANDO CONEXÃO COM BANCO
        $this->close();
    }

    //FUNÇÃO DE CONEXÃO COM BANCO
    function connect(){
        $filepath = realpath (dirname(__FILE__));

        require_once($filepath."/dbconfig.php");

        //CONEXÃO COM MYSQL (PHPMYADMIN) BANCO
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());

        //SELECIONANDO BANCO
        $db = mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());

        //RETORNO DA CONEXÃO
        return $con;
      }
      //Fechando CONEXÃO com BANCO
      function close(){
         mysql_close();
      }
}



 ?>
