<?php

namespace App\Models;



class Chance extends \Dot\Chances\Models\Chance
{
    public function getPathAttribute(){
        return route('chances.show', ['id' => $this->id]);
    }
}
