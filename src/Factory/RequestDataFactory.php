<?php

namespace App\Factory;

use SebastianBergmann\Type\ObjectType;
use Slim\Psr7\Request;

/**
 * RequestDataFactory.
 */
final class RequestDataFactory
{

    /**
     * @param Request $request The request object
     */
    public function createData(Request $request)
    {   
        $requestData = (object)[];
        $requestData->attribs = (object)$request->getAttributes() ?? null;
        $requestData->params = (object)$request->getQueryParams() ?? null;
        $requestData->body = (object)$request->getParsedBody() ?? null;

        return $requestData;
    }

}

?>