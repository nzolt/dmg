<?php

namespace App\Http\Controllers\Rpc;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Product;
use App\Resource\ExpenseResource;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use AvtoDev\JsonRpc\Requests\RequestInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Resource\Rpc;

class JsonRpcController extends Controller
{
    /**
     * Get info from request.
     *
     * @param RequestInterface $request
     *
     * @return mixed[]
     */
    public function _showInfo(RequestInterface $request): array
    {
        return Rpc\DetailResource::getRequestData($request);
    }

    /**
     * @param RequestInterface $request
     * @return Collection
     */
    public function _list(RequestInterface $request): Collection
    {
        $deletes = false;
        $params = $request->getParams();
        if(property_exists($params, 'withDeleted')){
            $deletes = $params->withDeleted;
        }
        return ExpenseResource::getExpenses($deletes);
    }

    /**
     * @param RequestInterface $request
     * @return Expense|null
     */
    public function _byId(RequestInterface $request): ?Expense
    {
        $params = $request->getParams();
        if(property_exists($params, '_id') && ExpenseResource::validateId($params->_id)) {
            return ExpenseResource::getExpense($params->_id);
        }
        return null;
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    public function _addExpense(RequestInterface $request):array
    {
        $params = $request->getParams();
        return ExpenseResource::addExpense($params);
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    public function _deleteExpense(RequestInterface $request):array
    {
        $params = $request->getParams();
        if(property_exists($params, '_id') && ExpenseResource::validateId($params->_id)) {
            return ExpenseResource::deleteExpense($params->_id);
        }
    }

    /**
     * @param RequestInterface $request
     * @return false[]
     */
    public function _updateExpense(RequestInterface $request)
    {
        $params = $request->getParams();
        if(property_exists($params, '_id') && ExpenseResource::validateId($params->_id)) {
            return ExpenseResource::updateExpense($params);
        }
    }
}
