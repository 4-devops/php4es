<?php
/**
 * Created by PhpStorm.
 * User: zhulinfeng
 */

require_once(PRO_ROOT_DIR . '/bootstrap.php');
Logger::configure(PRO_ROOT_DIR . '/log4php.xml');
$logger = Logger::getLogger('php4es');
use Elasticsearch\ClientBuilder;

function init_settings(&$settings)
{
    global $logger;
    if (!is_array($settings) || !isset($settings) || $settings == null)
    {
        $logger -> warn('settings is invalid or null, default settings will be used');
        $settings = array();
    }
    if(!isset($settings['number_of_shards']) || $settings['number_of_shards'] == null)
    {
        $settings['number_of_shards'] = 5;
    }

    if(!isset($settings['number_of_replicas']) || $settings['number_of_replicas'] == null)
    {
        $settings['number_of_shards'] = 2;
    }
}

function init_mappings(&$mappings)
{
    global $logger;
}

function create_es_index($es_index_name, $es_type_name, $mappings, $settings = null)
{
    global $es_params, $logger;

    if (isset($es_index_name) && isset($es_type_name) && isset($mappings))
    {

        init_settings($settings);
        init_mappings($mappings);
        $client = ClientBuilder::create()->setHosts($es_params)->build();
        $params = [
            'index' => $es_index_name,
            'type' => $es_type_name,
            'body' => [
                'settings' => $settings,
                'mappings' => $mappings
            ]
        ];
        $response = $client->indices()->create($params);
        $logger->info($response);
    }
}