<?php
/**
 * Created by PhpStorm.
 * User: zhulinfeng
 * Date: 2018/6/9
 * Time: 上午8:39
 */

require_once('../../bootstrap.php');
require_once(PRO_MAIN_DIR . '/create.php');

$mappings = [
    'f1' => [
       'type' => 'text'
    ],
    'f2' => [
        'type' => 'integer'
    ]
];

create_es_index('test1', 'test1', $mappings);