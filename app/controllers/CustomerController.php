<?php

namespace App\Controllers;

use App\Requests\Request;
use Views\View;
use App\Models\Customer;

class CustomerController extends Controller {
    public function __construct() {
        Parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * @return 
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $customer = new Customer;
        $customers = $customer->filter($data)->paginate();

        return new View('customers', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return 
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return 
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the specified resource.
     * @return 
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @return 
     */
    public function edit(Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return 
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     * @return 
     */
    public function destroy(Request $request)
    {

    }

    /**
     * filter resources.
     *
     * @return \Illuminate\Http\
     */
    public function filter(Request $request)
    {

    }
}