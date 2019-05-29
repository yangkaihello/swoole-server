<?php
/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/5/18
 * Time: 下午3:38
 */

namespace yangkai\swoole\server;

use Swoole\Client;
use Swoole\Server;

class Swoole
{
    private const PORT =  9501;
    private const IP =  '127.0.0.1';
    private $setting = [
        'worker_num' => 1,
        'task_worker_num' => 4,
        'backlog' => 128,
        'max_request' => 255,
        'daemonize' => true,
    ];

    private $ports = [];

    public function init(array $setting,array $ports = [])
    {
        $this->setting = $setting+$this->setting;
        $this->ports = $ports;
    }

    public function start()
    {
        $serv = new Server(static::IP, static::PORT, SWOOLE_BASE, SWOOLE_SOCK_TCP);

        $serv->set($this->setting);

        foreach ($this->ports as $config)
        {
            $ServerTask = $serv->listen($config['ip'],$config['port'],$config['type'] ?? SWOOLE_SOCK_TCP);
            new $config['class']($ServerTask);
        }

        $serv->on('connect', function (Server $serv, $fd,$reactor_id){});
        $serv->on('close', function (Server $serv, $fd,$reactor_id) {});
        $serv->on('task', function (Server $serv, $task_id, $from_id, $data) {});
        $serv->on('finish', function (Server $serv, $task_id, $data) {});

        $serv->on('receive', function (Server $serv, $fd, $reactor_id, $data) {

            $data = str_replace(["\n","\r"," "],"",$data);

            $ServerPort = [];

            foreach ($serv->ports as $port)
            {
                $tcp[$port->port] = $port;
                $ServerPort[] = $port->host . ":" . $port->port;
            }
            $ServerPort = implode(" , ",$ServerPort);

            switch ($data)
            {
                case "reload":
                    $serv->reload();
                    $serv->send($fd,$ServerPort . " ---> " . $data . PHP_EOL);
                    $serv->close($fd);
                    break;
                case "close":
                    $serv->shutdown();
                    $serv->send($fd,$ServerPort . " ---> " . $data . PHP_EOL);
                    $serv->close($fd);
                    break;
                default:
                    $serv->send($fd,"not server handle;" . PHP_EOL);
                    $serv->close($fd);
                    break;
            }
        });

        $serv->start();
    }

    public function close($ip = self::IP,$port = self::PORT)
    {
        $client = new Client(SWOOLE_SOCK_TCP);

        if($connect = $client->connect($ip, $port, 0.5) == true)
        {
            $client->send("close");
            return $client->recv();
        }else{
            throw new \Exception("connect client not;");
        }
    }

    public function reload($ip = self::IP,$port = self::PORT)
    {
        $client = new Client(SWOOLE_SOCK_TCP);

        if($connect = $client->connect($ip, $port, -1) == true)
        {
            $client->send("reload");
            return $client->recv();
        }else{
            throw new \Exception("connect client not;");
        }
    }


}
