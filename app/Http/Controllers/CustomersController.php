<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Customer;

class CustomersController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(AuthManager $auth): View
    {
        return view('customers.index', ['customers' => Customer::where('user_id', $auth->user()->id)->get()]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create(): View
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request, AuthManager $auth): Response
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'sex'        => ['nullable', 'int', Rule::in([Customer::SEX_FEMALE, Customer::SEX_MALE])],
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique(Customer::class)->where(fn ($query) => $query->where('user_id', $auth->user()->id))
            ],
        ]);

        $customer = Customer::create(array_merge($request->all(), ['user_id' => $auth->user()->id]));

        return redirect()
            ->route('customers')
            ->with('success', sprintf('Customer %s %s successfully added', $request->first_name, $request->last_name));
    }
}
