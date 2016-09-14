<?php
/**
 * Created by PhpStorm.
 * User: huynguyen
 * Date: 8/30/16
 * Time: 8:37 AM
 */

namespace Bootstrap;

use Monolog\Logger as Monolog;
use Monolog\Formatter\LineFormatter;
use Illuminate\Log\Writer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseConfigureLogging;
use Monolog\Handler\StreamHandler;

class ConfigureConsoleLogging  extends BaseConfigureLogging{
    /**
     * OVERRIDE PARENT
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureHandlers(Application $app, Writer $log)
    {

        // Stream handlers
        $logPath = env('LOG_PATH_CONSOLE', storage_path('logs').'/app-console.log');
        $logLevel = Monolog::DEBUG;
        $logStreamHandler = new StreamHandler($logPath, $logLevel);

        // Formatting
        // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
        $logFormat = "%datetime% [%level_name%] (%channel%): %message%\n";
        $formatter = new LineFormatter($logFormat);
        $logStreamHandler->setFormatter($formatter);

        // push handlers
        $logger = $log->getMonolog();
        $logger->pushHandler($logStreamHandler);
    }
}