<?php
class Autoload{
    public static function useClass($class)
	{
	    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	    $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . $path . '.class.php';
	    if (file_exists($file)) {
	        require_once $file;
	    }
	}
	
	public static function classLoader($class)
	{
        $class = self::psr4($class);
	    $path = str_replace('\\', DIRECTORY_SEPARATOR , $class);

	    $file = $path . '.php';
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $file)) {
            include_once __DIR__ . DIRECTORY_SEPARATOR . $file;
	    }
	}

	public static function psr4($class)
    {
        $composer = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "composer.json");
        $comopser = json_decode($composer,true);
        $psr = array_keys($comopser['autoload']['psr-4']);

        return str_replace($psr,"",$class);
    }

	
}

