<?php
declare(strict_types=1);

namespace Budgetcontrol\Label\Controller;

use Budgetcontrol\Label\Entity\Order;
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

    /**
     * Applies the specified order to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder &$query The query builder instance.
     * @param Order $orders The order to apply.
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder instance.
     */
    public function orderBy(\Illuminate\Database\Eloquent\Builder &$query, Order $orders): \Illuminate\Database\Eloquent\Builder
    {
        if($orders->getOrder()) {
            foreach($orders->getOrder() as $key => $order) {
                $query->orderBy($key, $order);
            }
        }

        return $query;
    }


}