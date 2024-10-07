<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerFilter extends ApiFilter
{
    protected $safeParams = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt']
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];


    protected $columns = ['name', 'email', 'city', 'state', 'address', 'postal_code'];

    public function search(Request $request)
    {
        $filterItems = parent::transform($request);

        $query = Customer::query();

        if ($request->has('filter_value')) {
            $query->where(function ($query) use ($request) {
                foreach ($this->columns as $column) {
                    $query->orWhere($column, 'like', "%{$request->filter_value}%");
                }
            });
        }

        if ($request->has('sort')) {
            $query->orderBy($request->sort, $request->order ?? 'asc');
        }

        $query->when($request->query('includeInvoices'), function ($query) {
            return $query->with('invoices');
        })->where($filterItems);   

        return $query;
    }
}
