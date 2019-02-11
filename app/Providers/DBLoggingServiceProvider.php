<?php

namespace App\Providers;
use Illuminate\Support\Facades\DB;
use Storage;
use Illuminate\Support\ServiceProvider;

class DBLoggingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */ 
    public function boot()
    {

         DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
            // if(substr_count($query->sql,'select') == 0) {
                $path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                $sql = str_replace_array('?', $query->bindings, $query->sql);
                file_put_contents($path.'db_logs.txt', $sql.PHP_EOL , FILE_APPEND | LOCK_EX);    
            // }       
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
