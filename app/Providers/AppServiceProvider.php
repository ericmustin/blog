<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $logger = \Log::getMonolog();
        $logger->pushProcessor(function ($record) {
              $span = \DDTrace\GlobalTracer::get()->getActiveSpan();
              if (null === $span) {
                  return $record;
              }
              $record['message'] .= sprintf(
                  ' [dd.trace_id=%d dd.span_id=%d]',
                  $span->getTraceId(),
                  $span->getSpanId()
              );
              return $record;
          });
    }
}
