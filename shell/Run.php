<?php
/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/6/11
 * Time: 下午3:24
 */
namespace yangkai\swoole\server\shell{

    use yangkai\swoole\server\Swoole;

    class Run{

        /**
         * @var
         * [
         *      'dsn' => ['ip' => '0.0.0.0','port' => 9501],
         *      'setting' => [
         *          'daemonize' => false,
         *          'worker_num' => 1,
         *      ],
         *      'ports' => [
         *          ["ip" => "0.0.0.0","port" => 9502,"type" => SWOOLE_SOCK_TCP,"class" => "\\console\\server\\swoole\\SwooleTask" ],
         *          ["ip" => "0.0.0.0","port" => 9503,"type" => SWOOLE_SOCK_UDP,"class" => "\\console\\server\\swoole\\SwooleGo" ],
         *      ],
         *      'object' => "\\yangkai\\swoole\\server\\Service",
         * ]
         */
        private $config;

        /**
         * 必填参数名称
         * @var array
         */
        private $configFieldPrivate = [
            'dsn','setting'
        ];

        /**
         * 非必填参数名称（必须给定一个默认值）
         * @var array
         */
        private $configFieldPublic = [
            'ports' => [],
            'object' => null,
        ];

        public function loadConfig($config)
        {
            $this->config = $config;
        }


        public function run()
        {
            foreach ($this->config as $config)
            {
                /**
                 * 配置验证（必填）
                 */
                foreach ($this->configFieldPrivate as $value)
                {
                    if( !isset($config[$value]) )
                    {
                        throw new \Exception("{$value} Nonexistent configuration;");
                    }
                }

                /**
                 * 配置验证（非必填）
                 */
                foreach ($this->configFieldPublic as $key=>$value)
                {
                    if( !isset($config[$key]) )
                    {
                        $config[$key] = $value;
                    }
                }

                $config = json_encode($config);

                exec("php ". dirname(__DIR__)  . DIRECTORY_SEPARATOR . "Script.php '{$config}'");
            }




        }


    }


}
