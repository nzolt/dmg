<?php


namespace App\Resource\Rpc;


class ArrayResource
{
    public static function arraySum(array $rns, int $r = null):array
    {
        $sum = (int) \array_sum($rns);
        if($sum == $r) {
            return ["sum" => true];
        }
        return ["sum" => false, "result" => $sum];
    }
}
