<?php
/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/6/10
 * Time: 下午6:18
 */
namespace yangkai\swoole\server\traits{

    use Swoole\Server;

    trait Register{

        public function ports(Server $server,$ports)
        {
            foreach ($ports as $config)
            {
                $ServerTask = $server->listen($config['ip'],$config['port'],$config['type'] ?? SWOOLE_SOCK_TCP);
                new $config['class']($ServerTask);
            }
        }

        public function onRegister(Server $server,$object)
        {
            if(method_exists($object,'connect'))
            {
                $server->on('connect', [$object,'connect']);
            }

            if(method_exists($object,'close'))
            {
                $server->on('close', [$object,'close']);
            }

            if(method_exists($object,'task'))
            {
                $server->on('task', [$object,'task']);
            }

            if(method_exists($object,'finish'))
            {
                $server->on('finish', [$object,'finish']);
            }

            if(method_exists($object,'receive'))
            {
                $server->on('receive', [$object,'receive']);
            }
            return $server;
        }

    }

}