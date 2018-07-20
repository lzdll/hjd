<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Memcached settings
| -------------------------------------------------------------------------
| Your Memcached servers can be specified below.
|
|	See: https://codeigniter.com/user_guide/libraries/caching.html#memcached
|
*/
$config['redis_default'] = array(


        /* 'host' => '127.0.0.1',
        'port'     => '22121', */
		'host' => '127.0.0.1',
		'port' =>  '6379',
        'weight'   => '1',



);