<?php
// RECEBE AS CONFIGURAÇÕES
require_once 'config.php';

// REALIZA A CONEXÃO COM O BANCO POR MEIO DO PDO
class conexao{
	private static $instance;
	public static function getIntance(){

		if(!isset(self::$instance)){
			try{
				self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS,
				Array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			}catch (PDOException $e) {
				echo ("Falha ao tentar conectar: \n" . $e->getMessage());
			}
		}
		return self::$instance;
	}
	public static function prepare($sql){
		return self::getIntance()->prepare($sql);
	}
}
?>