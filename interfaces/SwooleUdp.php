<?php

/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/5/21
 * Time: 下午5:44
 */

namespace yangkai\swoole\server\interfaces;

use Swoole\Server;

interface SwooleUdp
{

    /**
     * SwoolePorts constructor.
     * @param \Swoole\Server $port
     * @deprecated $port 是swoole的端口对象
     * @comment content $port->on("packet",[$this,'packet']);
     */
    public function __construct($port);

    /**
     * 接收到UDP数据包时回调此函数
     * @param Server $server
     * @param string $data
     * @param array $client_info
     */
    public function packet(Server $server, string $data, array $clientInfo);

}
