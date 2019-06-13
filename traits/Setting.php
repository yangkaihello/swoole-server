<?php
/**
 * Created by PhpStorm.
 * User: yangkai
 * Date: 2019/6/10
 * Time: 下午5:38
 */
namespace yangkai\swoole\server\traits{

    trait Setting{
        private $ip;
        private $port;

        private $setting = [
            'worker_num' => 1,
            'backlog' => 128,
            'max_request' => 255,
            'daemonize' => true,
        ];
        private $object = null;

        private $ports = [];

        public function __construct($dsn)
        {
            if(is_string($dsn))
            {
                $arr = array_flip(array_flip(explode(";",$dsn)));
                foreach ($arr as $value)
                {
                    $value = explode(":",$value);
                    $dsn[$value[0]] = $value[1];
                }
            }

            foreach ($dsn as $key=>$value)
            {
                if(property_exists($this,$key))
                {
                    $this->$key = $value;
                }
            }

        }

        public function init(array $setting,array $ports = [],$object = null)
        {
            if($object)
            {
                $this->object = $object;
            }
            $this->setting = $setting+$this->setting;
            $this->ports = $ports;
        }


    }

}