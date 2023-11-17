<?php

if((empty($_SERVER['SERVER_NAME']) && php_sapi_name() == 'cli') || (!empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost'))
{
	/** database config **/
	define('DBTYPE', 'pgsql'); //mysql,pgsql
	define('DBNAME', 'firstdecisiondt'); //db_name
	define('DBHOST', 'pgsql'); //docker_container
	define('DBUSER', 'postgres');
	define('DBPASS', '123456');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://localhost/firstdecision_dt/desafioFD/public');

} else {
	/** database config **/
	define('DBTYPE', 'pgsql'); //mysql,pgsql
	define('DBNAME', 'my_db');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.meuwebsite.com');

}

define('APP_NAME', "First Decision Desafio Tecnico");
define('APP_DESC', "PHP Back-end + Postgresql");

/** true means show errors **/
define('DEBUG', true);
