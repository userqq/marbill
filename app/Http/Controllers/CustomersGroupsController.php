<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\CustomerToGroup;

class CustomersGroupsController extends Controller
{
    /**
     * Display a listing of custoters groups
     */
    public function index(AuthManager $auth): View
    {
        return view('customers-groups.index', ['groups' => CustomerGroup::where('user_id', $auth->user()->id)->get()]);
    }

    /**
     * Store a newly created customer group
     */
    public function store(Request $request, AuthManager $auth): Response
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(CustomerGroup::class)->where(fn ($query) => $query->where('user_id', $auth->user()->id)),
            ],
        ]);

        $customerGroup = CustomerGroup::create(array_merge($request->all(), ['user_id' => $auth->user()->id]));

        return redirect()
            ->route('customers-groups-show', ['customerGroup' => $customerGroup->id])
            ->with('success', sprintf('Customers group %s successfully added', $request->name));
    }

    /**
     * Display the customer group with related customers
     */
    public function show(CustomerGroup $customerGroup, AuthManager $auth): View
    {
        return view('customers-groups.show', [
            'customerGroup' => $customerGroup,
            'customers'     => Customer::where('user_id', $auth->user()->id)
                ->whereNotExists(
                    fn ($query) => $query
                        ->from((new CustomerToGroup)->getTable())
                        ->where('user_id', $auth->user()->id)
                        ->where('customer_group_id', $customerGroup->id)
                        ->whereRaw('`customer_id` = `' . (new Customer)->getTable() . '`.`id`')
                )
                ->get(),
        ]);
    }

    /**
     * Display the customer group with related customers
     */
    public function update(CustomerGroup $customerGroup, Request $request, AuthManager $auth): Response
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::notIn([$customerGroup->name]),
                Rule::unique(CustomerGroup::class)->where(fn ($query) => $query->where('user_id', $auth->user()->id)),
            ],
        ]);

        $customerGroup->update(array_merge($request->all(), ['user_id' => $auth->user()->id]));

        return redirect()
            ->route('customers-groups-show', ['customerGroup' => $customerGroup->id])
            ->with('success', sprintf('Customers group %s successfully renamed', $request->name));
    }

    /**
     * Remove the customer group with related customers
     */
    public function delete(CustomerGroup $customerGroup, AuthManager $auth): Response
    {
        DB::transaction(function () use ($customerGroup, $auth) {
            CustomerToGroup::where('customer_group_id', $customerGroup->id)
                ->where('user_id', $auth->user()->id)
                ->delete();

            $customerGroup->delete();
        });

        return redirect()
            ->route('customers-groups')
            ->with('success', sprintf('Customers group %s successfully deleted', $customerGroup->name));
    }

    /**
     * Add the customer to the group
     */
    public function addCustomer(AuthManager $auth, Request $request): Response
    {
        $this->validate($request, [
            'customer_id' => [
                'required',
                'int',
                Rule::exists(Customer::class, 'id')->where(fn ($query) => $query->where('user_id', $auth->user()->id)),
            ],
            'customer_group_id' => [
                'required',
                'int',
                Rule::exists(CustomerGroup::class, 'id')->where(fn ($query) => $query->where('user_id', $auth->user()->id)),
                Rule::unique(CustomerToGroup::class, 'customer_group_id')
                    ->where(
                        fn ($query) => $query
                            ->where('user_id', $auth->user()->id)
                            ->where('customer_id', $request->customer_id)
                    ),
            ],
        ]);

        CustomerToGroup::create(array_merge($request->all(), ['user_id' => $auth->user()->id]));

        return redirect()
            ->route('customers-groups-show', ['customerGroup' => $request->customer_group_id])
            ->with('success', 'Customer was successfully added to group');
    }

    /**
     * Remove the customer from the group
     */
    public function removeCustomer(AuthManager $auth, Request $request)
    {
        $this->validate($request, [
            'customer_id' => [
                'required',
                'int',
                Rule::exists(Customer::class, 'id')->where(fn ($query) => $query->where('user_id', $auth->user()->id)),
            ],
            'customer_group_id' => [
                'required',
                'int',
                Rule::exists(CustomerGroup::class, 'id')->where(fn ($query) => $query->where('user_id', $auth->user()->id)),
                Rule::exists(CustomerToGroup::class, 'customer_group_id')
                    ->where(
                        fn ($query) => $query
                            ->where('user_id', $auth->user()->id)
                            ->where('customer_id', $request->customer_id)
                    ),
            ],
        ]);

        CustomerToGroup::where('user_id', $auth->user()->id)
            ->where('customer_id', $request->customer_id)
            ->where('customer_group_id', $request->customer_group_id)
            ->delete();

        return redirect()
            ->route('customers-groups-show', ['customerGroup' => $request->customer_group_id])
            ->with('success', 'Customer was removed from group');
    }
}
