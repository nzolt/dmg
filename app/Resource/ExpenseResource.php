<?php

namespace App\Resource;

use App\Models\Expense;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use AvtoDev\JsonRpc\Requests\Request;
use Illuminate\Support\Facades\Validator;


class ExpenseResource
{
    /**
     * @return Collection
     */
    public static function getExpenses($deletes = false): Collection
    {
        if($deletes){
            return Expense::all();
            // TODO: Add pagination if required
        }
        return Expense::where('deleted_at', '=', null)->get();
    }

    /**
     * @param string $_id
     * @return Expense|null
     */
    public static function getExpense(string $_id): ?Expense
    {
        return Expense::find($_id);
        // TODO: Filter by Deleted if required.
    }

    /**
     * @param \stdClass $params
     * @return array
     */
    public static function addExpense(\stdClass $params):array
    {
        $validator = Validator::make([
                'description' => $params->description,
                'value' => $params->value,
            ], [
                'description' => 'required|string|max:250',
                'value' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return ['code' => 10561, 'Message' => $validator->messages()];
        } else {
            $expense = new Expense();

            $expense->fill([
                'description' => $params->description,
                'value' => $params->value,
                'info' => $params->info,
            ]);

            $expense->save();
            return ['_id' => $expense->_id];
        }

    }

    /**
     * @param string $_id
     * @return array|false[]
     */
    public static function deleteExpense(string $_id):array
    {
        $expense = Expense::find($_id);
        if($expense){
            return ['deleted' => $expense->delete()];
        }

        return ['deleted' => false];
    }

    /**
     * @param \stdClass $params
     * @return array|false[]
     */
    public static function updateExpense(\stdClass $params):array
    {
        $rules = [];
        $toValidate = [];
        $setDescriptions = false;
        $setValue = false;
        $setInfo = false;
        $update = false;
        if(property_exists($params, 'description')){
            $toValidate['description'] = $params->description;
            $rules['description'] = 'required|string|max:250';
            $setDescriptions = true;
        }
        if(property_exists($params, 'value')){
            $toValidate['value'] = $params->value;
            $rules['value'] = 'required|numeric';
            $setValue = true;
        }
        if(property_exists($params, 'info')){
            $setInfo = true;
        }

        $expense = Expense::where('deleted_at', '=', null) // Not update deleted Expense
            ->where('_id', '=', $params->_id)
            ->first();

        if(count($rules)){
            $validator = Validator::make($toValidate, $rules);
            if ($validator->fails()) {
                return ['code' => 10563, 'Message' => $validator->messages()];
            } else {

                if ($expense) {
                    if($setDescriptions){
                        $expense->description = $params->description;
                        $update = true;
                    }
                    if($setValue){
                        $expense->value = $params->value;
                        $update = true;
                    }
                }
            }

        }

        // Update Info if set
        if ($setInfo){
            $expense->info = $params->info;
            $update = true;
        }
        if($update){
            return ['updated' => $expense->save()];
        }

        return ['updated' => false];
    }

    /**
     * @param $id
     * @return bool
     */
    public static function validateId($id):bool
    {
        return ($id instanceof \MongoDB\BSON\ObjectID
            || preg_match('/^[a-f\d]{24}$/i', $id));
    }
}
