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
date_default_timezone_set('asia/shanghai');

use Elasticsearch\ClientBuilder;

Logger::configure(PRO_ROOT_DIR . '/log4php.xml');
$logger = Logger::getLogger('es_query');

function init_page(&$options)
{
    $options['from'] = isset($options['from']) ? $options['from'] : 0;
    $options['size'] = isset($options['size']) ? $options['size'] : 5;
}

function init_order_by(&$options)
{
    if (isset($options['sort']) && is_array($options['sort']))
    {
        $options['sort'] = [
            $options['sort']['field'] => [
                'order' => $options['sort']['sort']
            ]
        ];
    }
}

function sub_obj($options, $op_name)
{
    $sub_obj = array();
    if (isset($options['search_condition'][$op_name])
        && $options['search_condition'][$op_name] != null
        && is_array($options['search_condition'][$op_name]))
    {
        $type = $options['search_condition'][$op_name]['type'];
        foreach ($options['search_condition'][$op_name]['data'] as $k => $v)
        {
            $sub_obj[] = [
                $type => [$k => $v]
            ];
        }
    }
    //print_r($sub_obj); exit();
    return $sub_obj;

}


function es_query($index_name, $type_name, $options=null)
{
    global $es_params, $logger;
    $client = ClientBuilder::create()->setHosts($es_params)->build();
    if ($options == null || !isset($options) || !is_array($options)) $options = array();

    init_page($options);

    init_order_by($options);

    $query = array();

    if (!isset($options['search_condition']) || $options['search_condition'] == null)
    {
        $query['match_all'] = '';
    }

    if (isset($options['select_fields'])
        && $options['select_fields'] != null)
    {
        $query['_source'] = $options['select_fields'];
    }

    if (isset($options['must'])
        && $options['must'] != null)
    {
        $must_query = array();
        foreach ($options['must']['name'] as $item)
        {
            $must_query = array_merge($must_query, sub_obj($options, $item));
        }
    }

    if (isset($options['must_not'])
        && $options['must_not'] != null)
    {
        $must_not_query = array();
        foreach ($options['must_not']['name'] as $item)
        {
            $must_not_query = array_merge($must_not_query, sub_obj($options, $item));
        }
    }

    if (isset($options['should'])
        && $options['should'] != null)
    {
        $should_query = array();
        foreach ($options['should']['name'] as $item)
        {
            $should_query = array_merge($should_query, sub_obj($options, $item));
        }
    }

    if (isset($must_query)) $query['bool']['must'] = $must_query;
    if (isset($must_not_query)) $query['bool']['must_not'] = $must_not_query;
    if (isset($should_query)) $query['bool']['should'] = $should_query;

    if (isset($options['range']) && is_array($options['range']))
    {
        $query['bool']['filter']['range'] = $options['range'];
    }

    $params = [
        'index' => $index_name,
        'type' => $type_name,
        'body' => [
            'query' => $query,
            'from' => $options['from'],
            'size' => $options['size'],
            'sort' => $options['sort']
        ]
    ];

    //print_r($params); exit();
    try {
        $response = $client->search($params);
        $logger->info('该次查询一共匹配 ' . $response['hits']['total'] . ' 条');
        $logger->info($response);
    } catch (Exception $e) {
        $logger->error($e);
    }
}