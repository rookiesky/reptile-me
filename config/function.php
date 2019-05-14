<?php

if(! function_exists('dd')){

    function dd($data)
    {
        dump($data);
        exit();
    }

}

