<?php
/**
 * Created by PhpStorm.
 * User: zhulinfeng
 * Date: 2018/6/9
 * Time: 下午10:20
 */

require_once '../../bootstrap.php';
require_once PRO_MAIN_DIR . '/query.php';

/*$options = [
    'search_condition' => [
        'name1' => [
            'type' => 'term',
            'data' => [
                'type' => 'act',
                //'line_id' => 14032
            ]
        ],
        'name2' => [
            'type' => 'match',
            'data' => [
                'type' => 'a'
            ]
        ],
        'name3' => [
            'type' => 'match_phrase',
            'data' => [
                'text_entry' => 'ACT III'
            ]
        ],
    ],
    'must' => [
        'name' => ['name1']
    ],
    'must_not' => [
        'name' => ['name3']
    ],
    'range' => [
        'line_id' => [
            'lte' => 10000
        ]
    ],
    'sort' => [
        'field' => 'line_id',
        'sort' => 'desc'
    ],
    //'_source' => ['line_id', 'type']
];

es_query('shakespeare','record', $options);*/

$value = ['speaker' => 'kong'];
es_fuzzy_query('shakespeare','record', $value);