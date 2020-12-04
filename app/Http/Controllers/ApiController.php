<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Resource\ExpenseResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class ApiController
 * @package App\Http\Controllers
 * TODO: Add Swagger API doc
 */
class ApiController extends Controller
{
    /**
     * @param Request $request
     * @param bool $deletes
     * @return Collection
     */
    public function _list(Request $request, bool $deletes = false): Collection
    {
        return ExpenseResource::getExpenses($deletes);
        // TODO: Make more specific $deletes, now everything is TRUE
    }

    /**
     * @param Request $request
     * @param string $_id
     * @return Expense|null
     */
    public function _byId(Request $request, string $_id): ?Expense
    {
        if(ExpenseResource::validateId($_id)) {
            return ExpenseResource::getExpense($_id);
        }
        return null;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function _addExpense(Request $request):array
    {
        $params = json_decode($request->getContent());
        return ExpenseResource::addExpense($params);
    }

    /**
     * @param Request $request
     * @param string $_id
     * @return array
     */
    public function _deleteExpense(Request $request, string $_id):array
    {
        if(ExpenseResource::validateId($_id)) {
            return ExpenseResource::deleteExpense($_id);
        }

        return [];
    }

    /**
     * @param Request $request
     * @param string $_id
     * @return false[]
     */
    public function _updateExpense(Request $request, string $_id):array
    {
        $params = json_decode($request->getContent());
        if(ExpenseResource::validateId($_id)) {
            return ExpenseResource::updateExpense($params);
        }

        return [];
    }
}
