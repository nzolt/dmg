<?php


namespace App\Resource\Rpc;

use AvtoDev\JsonRpc\Requests\Request;

class DetailResource
{
    /**
     * @param Request $request
     * @return array
     */
    public static function getRequestData(Request $request):array
    {
        return [
            'params'       => $request->getParams(),
            'notification' => $request->isNotification(),
            'method_name'  => $request->getMethod(),
            'request ID'   => $request->getId(),
        ];
    }
}
