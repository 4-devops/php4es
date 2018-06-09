<?php
/**
 * Created by PhpStorm.
 * User: zhulinfeng
 * Date: 2018/6/9
 * Time: 上午8:39
 */

require_once('../../bootstrap.php');
require_once(PRO_MAIN_DIR . '/create.php');
date_default_timezone_set('asia/shanghai');

$mappings = [
    'f1' => [
       'type' => 'text'
    ],
    'f2' => [
        'type' => 'integer'
    ]
];

create_es_index('test', 'test', $mappings);