<?php
/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/6/11
 * Time: 下午3:38
 */
namespace yangkai\swoole\server;

include __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';
spl_autoload_register(array('Autoload', 'classLoader')); 		//自动加载

$config = json_decode($argv[1],true);

$class = new Swoole($config['dsn']);

$class->init($config['setting'],$config['ports'],$config['object']);

if(method_exists($class,'start'))
{
    return $class->start();
}