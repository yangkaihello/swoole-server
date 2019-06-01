<?php

/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/5/21
 * Time: 下午5:44
 */

namespace yangkai\swoole\server\interfaces;

use Swoole\Server;

interface SwooleTcp
{

    /**
     * SwoolePorts constructor.
     * @param \Swoole\Server $port
     * @deprecated $port 是swoole的端口对象
     * @comment content $port->on("connect",[$this,'connect']);
     * @comment content $port->on("receive",[$this,'receive']);
     * @comment content $port->on("close",[$this,'close']);
     */
    public function __construct($port);

    /**
     * Swoole 连接定义事件
     * @param Server $server
     * @param $fd
     * @param $reactor_id
     * @return mixed
     */
    public function connect(Server $server, $fd,$reactor_id);

    /**
     * Swoole 接收数据定义事件
     * @param Server $server
     * @param $fd
     * @param $reactor_id
     * @param $data
     * @return mixed
     */
    public function receive(Server $server, $fd,$reactor_id,$data);

    /**
     * Swoole 关闭定义事件
     * @param Server $server
     * @param $fd
     * @param $reactor_id
     * @return mixed
     */
    public function close(Server $server, $fd,$reactor_id);

}
