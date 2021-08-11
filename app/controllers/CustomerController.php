<?php

namespace App\Controllers;

use App\Requests\Request;
use Views\View;
use App\Models\Customer;

class CustomerController extends Controller {
    public function __construct() {
        Parent::__construct();  // Call parent class constructor
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return object
     */
    public function index(Request $request)
    {
        // Get request as an associative array
        $data = $request->all();

        // Create an instance of Customer class;
        $customer = new Customer;
        // Call filter function of Customer class instance to filter data and then paginate it
        $customers = $customer->filter($data)->paginate();

        // Return an object of view class and pass template name and associative array of required view variables
        return new View('customers', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return 
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return 
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the specified resource.
     * @param Request $request
     * @param int $id
     * @return 
     */
    public function show(Request $request, $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @param int $id
     * @return 
     */
    public function edit(Request $request, $id)
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
     * @param Request $request
     * @return 
     */
    public function destroy(Request $request)
    {

    }
}