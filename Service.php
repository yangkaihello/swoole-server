<?php
/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/6/6
 * Time: 下午6:01
 */

namespace yangkai\swoole\server;

use Swoole\Server;

class Service
{
    public function connect(Server $server, $fd, $reactor_id)
    {

    }

    public function close(Server $server, $fd, $reactor_id)
    {

    }

    public function receive(Server $server, $fd, $reactor_id, $data)
    {

        $_Data = str_replace(["\n","\r"," "],"",$data);

        $_ServerPort = [];

        foreach ($server->ports as $port)
        {
            $_ServerPort[] = $port->host . ":" . $port->port;
        }
        $_ServerPort = implode(" , ",$_ServerPort);

        switch ($_Data)
        {
            case "reload":
                $server->reload();
                $server->send($fd,$_ServerPort . " ---> " . $_Data . PHP_EOL);
                $server->close($fd);
                break;
            case "close":
                $server->shutdown();
                $server->send($fd,$_ServerPort . " ---> " . $_Data . PHP_EOL);
                $server->close($fd);
                break;
        }

        if(get_class($this) == 'yangkai\swoole\server\Service')
        {
            $server->send($fd,"not server handle;" . PHP_EOL);
            $server->close($fd);
        }

    }

}