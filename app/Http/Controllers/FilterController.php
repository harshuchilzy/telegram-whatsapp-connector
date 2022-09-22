<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencyFilters = Filter::where('type', 'currency')->paginate(15);
        $tradingFilters = Filter::where('type', 'trade')
        ->orWhere('type', 'stop-loss')
        ->orWhere('type', 'money-management')
        ->orWhere('type', 'entry')
        ->orWhere('type', 'take-profit')->paginate(15);
        return inertia()->render('Filters/Index', [
            'currencyFilters' => $currencyFilters,
            'tradingFilters' => $tradingFilters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // code
    }

    public function createTradingFilter(){
        return inertia()->render('Filters/CreateTradingFilter');
    }

    public function createCurrencyFilter(){
        return inertia()->render('Filters/CreateCurrencyFilter');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'match_case' => 'required|unique:filters',
            'type' => 'required',
        ]);
        $input = $request->all();
        Filter::create([
            'match_case' => $input['match_case'],
            'exact_match' => $input['exact_match'],
            'type' => $input['type'],
        ]);

        return redirect()->route('filters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function show(Filter $filter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function edit(Filter $filter)
    {
        if ($filter->type == 'currency') {
            return inertia()->render('Filters/EditCurrency', [
                'filter' => [
                    'id' => $filter->id,
                    'match_case' => $filter->match_case,
                    'exact_match' => $filter->exact_match,
                    'type' => $filter->type
                ]
            ]);
        } else {
            return inertia()->render('Filters/EditTrading', [
                'filter' => [
                    'id' => $filter->id,
                    'match_case' => $filter->match_case,
                    'exact_match' => $filter->exact_match,
                    'type' => $filter->type
                ]
            ]);
        }
        
       
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Filter $filter)
    {
        request()->validate([
            'match_case' => 'required|unique:filters,match_case,'.$filter->id,
            'type' => 'required',
        ]);
    
        $filter->update($request->all());
    
        return redirect()->route('filters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filter $filter)
    {
        $filter->delete();
        return redirect()->route('filters.index');
    }
}