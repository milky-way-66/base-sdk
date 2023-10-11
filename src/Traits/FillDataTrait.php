<?php

namespace MilkyWay\BaseSdk\Traits;

trait FilllDataTrait {
    
    protected array $data;

    public function fill(array $data):self{
        $this->feilds();

        $result =[];
        foreach($this->feilds() as $feild){
            if(array_key_exists($feild, $data)){
                $result[$feild] = $data;
            }
        } 

        $this->data = $result;
        return $this;
    }

    public function data():array {
        return $this->data ?? [];
    }
}