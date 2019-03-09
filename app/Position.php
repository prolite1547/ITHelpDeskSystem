<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'position',
        'department_id'
    ];

    protected $appends = ['group'];

    public function setPositionAttribute($value){
        return $this->attributes['position'] = cleanInputs($value);
    }

    public function getGroupAttribute(){
        if(array_key_exists('position',$this->attributes)) {
            switch (true) {
                case strpos(strtolower(($this->attributes['position'])), 'support') !== false:
                    return 1;
                case strpos(strtolower(($this->attributes['position'])), 'technical') !== false:
                    return 2;
                default:
                    return 0;
            }
        }else{
            return 0;
        }
    }
}
