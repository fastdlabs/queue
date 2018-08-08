<?php

if(!function_exists('queue')) {
    function queue()
    {
        return app()->get('queue');
    }
}