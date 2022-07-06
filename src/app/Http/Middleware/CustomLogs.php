<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class CustomLogs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->path();
        $params = $request->all();
        $token = $request->header('Authorization');

        $logRequestData = json_encode([
            'uri' => $uri,
            'params' => $params
        ], JSON_UNESCAPED_UNICODE);
        $this->createLogInfo($logRequestData, $token);

        return $next($request);
    }

    /**
     * create log info
     */
    private function createLogInfo($info, $token)
    {
        $logger = new Logger('CUSTOM_LOGS');
        $logger->pushHandler(
            new RotatingFileHandler(storage_path('logs/custom_logs_api.log'), config('app.log_max_files', 0))
        );
        if (!empty($token)) {
            $info = $info . "[$token]";
        }
        $logger->info($info);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        $logResponseData = [];
        if (method_exists($response, 'getData')) {
            $logResponseData = json_encode($response->getData(), JSON_UNESCAPED_UNICODE);
        }
        $token = $request->header('Authorization');
        $this->createLogInfo($logResponseData, $token);
    }
}