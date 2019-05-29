<?php

/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/5/21
 * Time: 下午5:44
 */

namespace console\factory\project\base;

use Swoole\Server;

interface SwoolePorts
{

    /**
     * SwoolePorts constructor.
     * @param $port
     * @deprecated $port 是swoole的端口对象
     */
    public function __construct($port);

    /**
     * Swoole 连接定义事件
     * @param Server $serv
     * @param $fd
     * @param $reactor_id
     * @return mixed
     */
    public function connect(Server $serv, $fd,$reactor_id);

    /**
     * Swoole 接收数据定义事件
     * @param Server $serv
     * @param $fd
     * @param $reactor_id
     * @param $data
     * @return mixed
     */
    public function receive(Server $serv, $fd,$reactor_id,$data);

    /**
     * Swoole 关闭定义事件
     * @param Server $serv
     * @param $fd
     * @param $reactor_id
     * @return mixed
     */
    public function close(Server $serv, $fd,$reactor_id);

}