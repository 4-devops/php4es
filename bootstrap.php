<?php
/**
 * Created by PhpStorm.
 * User: zhulinfeng
 * Date: 2018/5/29
 * Time: 下午3:50
 */

define('PRO_ROOT_DIR', dirname(__FILE__));
define('PRO_TEST_DIR', PRO_ROOT_DIR . '/src/test');
define('PRO_MAIN_DIR', PRO_ROOT_DIR . '/src/main');
define('PRO_INC_DIR', PRO_ROOT_DIR . '/include');
require_once(PRO_INC_DIR . '/vendor/autoload.php');
require_once(PRO_INC_DIR . '/log4php/Logger.php');


$es_params = [
    'hosts' => [
        '192.168.253.12:9200'
    ]
];

