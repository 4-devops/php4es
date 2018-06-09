<?php
/**
 * Created by PhpStorm.
 * User: zhulinfeng
 * Date: 2018/6/9
 * Time: 上午9:42
 */

require_once '../../bootstrap.php';

require_once PRO_INC_DIR . '/vendor/autoload.php';
require_once PRO_INC_DIR . '/log4php/Logger.php';
date_default_timezone_set('asia/shanghai');

Logger::configure(PRO_ROOT_DIR . '/log4php.xml');

use Elasticsearch\ClientBuilder;

function delete_es_index($es_index_name)
{
    global $es_params;
    $logger = Logger::getLogger('php4es_delete_index');
    if (isset($es_index_name))
    {
        try{
            $client = ClientBuilder::create()->setHosts($es_params)->build();
            $params = [
                'index' => $es_index_name
            ];
            $response = $client->indices()->delete($params);
            $logger->info('success to delete index ' . $es_index_name);
            $logger->info($response);
        } catch (Exception $e) {
            $logger->error('fail to delete index');
            $logger->error($e);
        }
    }
}