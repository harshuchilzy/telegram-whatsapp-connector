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
        $tradingFilters = Filter::where('type', 'trade')->paginate(15);

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
        return inertia()->render('Filters/Create');
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
            'match_case' => 'required',
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
        return inertia()->render('Filters/Edit', [
            'filter' => [
                'id' => $filter->id,
                'match_case' => $filter->match_case,
                'exact_match' => $filter->exact_match,
                'type' => $filter->type
            ]
        ]);
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
            'match_case' => 'required',
            'exact_match' => 'required',
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