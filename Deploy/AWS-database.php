<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$active_group = 'default';
$active_record = TRUE;
$db['default']['hostname'] = '127.0.0.1'; // <for Pagodabox Local> 
$db['default']['username'] = 'root'; // <AWSl> 
$db['default']['password'] = '03e75244!'; // <for Pagodabox Local> 
$db['default']['database'] = 'security_app'; // <for Pagodabox Local> 
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


// sudo mysqldump -P 3306 -h kumostore.cgwhbdvpmij9.us-east-1.rds.amazonaws.com -u kumostore -p KumoTeam_Live --result-file=KT_Live_1022AM630.sql


// sudo mysqldump -P 3306 -h kumostore.cgwhbdvpmij9.us-east-1.rds.amazonaws.com -u kumostore -p KumoTeam_Live --result-file=/var/www/KumoTeam_Live/backups/KT_LiveDB_`date +\%T`.sql


// mysqldump -h $DB1_HOST --port=$DB1_PORT -u $DB1_USER -p$DB1_PASS $DB1_NAME > backups/kumoteamdemo__`date +\%T`.sql