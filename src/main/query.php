<?php
/**
 * Created by PhpStorm.
 * User: zhulinfeng
 * Date: 2018/6/9
 * Time: 下午10:03
 */

require_once '../../bootstrap.php';
require_once PRO_INC_DIR . '/vendor/autoload.php';
require_once PRO_INC_DIR . '/log4php/Logger.php';

use Elasticsearch\ClientBuilder;

Logger::configure(PRO_ROOT_DIR . '/log4php.xml');
$logger = Logger::getLogger('es_query');

function es_query($index_name, $type_name, $options=null)
{
    global $es_params, $logger;
    $client = ClientBuilder::create()->setHosts($es_params)->build();
    $params = [
        'index' => $index_name,
        'type' => $type_name,
        'body' => $options
    ];
    try {
        $response = $client->search($params);
        $logger->info($response);
    } catch (Exception $e) {
        $logger->error($e);
    }
}