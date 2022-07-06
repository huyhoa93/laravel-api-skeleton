<?php

namespace App\Helpers;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class Utils
{
    /**
    * create log info
    */
    public static function createLogInfo($info)
    {
        $logger = new Logger('CUSTOM_LOGS');
        $logger->pushHandler(
            new RotatingFileHandler(storage_path('logs/custom_logs_api.log'), config('app.log_max_files', 0))
        );
        if (!is_string($info)) {
            $info = json_encode($info);
        }
        $logger->info($info);
    }

    /**
    * create log error
    */
    public static function createLogError($error)
    {
        
        $logger = new Logger('CUSTOM_LOGS');
        $logger->pushHandler(
            new RotatingFileHandler(storage_path('logs/custom_logs_api.log'), config('app.log_max_files', 0))
        );
        if (!is_string($error)) {
            $error = json_encode([$error]);
        }
        $logger->error($error);
    }
}