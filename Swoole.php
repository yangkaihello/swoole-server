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
use yangkai\swoole\server\traits\Register;
use yangkai\swoole\server\traits\Setting;

/**
 * Class Swoole
 * @package yangkai\swoole\server
 */
class Swoole
{
    use Setting;    //配置的操作类
    use Register;   //注册swoole（事件|子端口）的操作类

    public function start()
    {
        $server = new Server($this->ip,$this->port, SWOOLE_BASE, SWOOLE_SOCK_TCP);

        $server->set($this->setting);

        $this->ports($server,$this->ports);  //注册端口

        $object = new Service();    //默认注册服务控制

        if($this->object)
        {
            $object = new $this->object();
        }

        $server = $this->onRegister($server,$object);

        $server->start();
    }



    public function close()
    {
        $client = new Client(SWOOLE_SOCK_TCP);

        if($connect = $client->connect($this->ip, $this->port, 0.5) == true)
        {
            $client->send("close");
            return $client->recv();
        }else{
            throw new \Exception("connect client not;");
        }
    }

    public function reload()
    {
        $client = new Client(SWOOLE_SOCK_TCP);

        if($connect = $client->connect($this->ip, $this->port, -1) == true)
        {
            $client->send("reload");
            return $client->recv();
        }else{
            throw new \Exception("connect client not;");
        }
    }


}
