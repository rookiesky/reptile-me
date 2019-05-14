<?php

namespace App\Active;

use App\Models\Loc;
use App\Tools\Log;

/**
 * Class ReptileList
 *
 * @package \App\Active
 */
class ReptileList
{
    public function boot()
    {
        $web = Loc::boot()->select('web','*',[
            'status' => 0
        ]);
        if(empty($web)){
            Log::boot()->info('web is empty');
            return false;
        }
    }

    protected function start($web)
    {
        foreach ($web as $item){

        }
    }

}
