<?php
declare(strict_types=1);

namespace Budgetcontrol\Label\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Controller {


    public function monitor(Request $request, Response $response)
    {
        return response([
            'success' => true,
            'message' => 'Entries service is up and running'
        ]);
    }


}