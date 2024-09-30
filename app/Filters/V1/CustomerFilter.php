<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
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

    public function transform(Request $request)
    {
        $eloQuery = parent::transform($request);

        $this->addNameFilter($eloQuery, $request->filter_value);

        return $eloQuery;
    }

    private function addNameFilter(&$eloQuery, $filterValue)
    {
        if (!empty($filterValue)) {
            $eloQuery[] = ['name', 'LIKE', "%{$filterValue}%"];
        }
    }

}
