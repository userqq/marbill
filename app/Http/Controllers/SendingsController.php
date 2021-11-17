<?php

namespace App\Http\Controllers;

use ValueError;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CustomerGroup;
use App\Models\CustomerToGroup;
use App\Models\EmailTemplate;
use App\Models\SendingsCustomer;
use App\Models\SendingSchedule;

class SendingsController extends Controller
{
    /**
     * Display a listing of user sendings.
     */
    public function index(AuthManager $auth): View
    {
        return view('sendings.index', [
            'templatesCount'       => EmailTemplate::where('user_id', $auth->user()->id)->count(),
            'customersGroupsCount' => CustomerToGroup::where('user_id', $auth->user()->id)->count(),
            'sendings'             => SendingSchedule::where('user_id', $auth->user()->id)
                ->orderBy('time')
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new sending.
     */
    public function create(AuthManager $auth): View
    {
        return view('sendings.create', [
            'currentTime'     => date('Y-m-d\TH:i'),
            'templates'       => EmailTemplate::where('user_id', $auth->user()->id)->get(),
            'customersGroups' => CustomerGroup::where('user_id', $auth->user()->id)
                ->whereExists(
                    fn ($query) => $query
                        ->from((new CustomerToGroup)->getTable())
                        ->where('user_id', $auth->user()->id)
                        ->whereRaw('`customer_group_id` = `' . (new CustomerGroup)->getTable() . '`.`id`')
                )
                ->get(),
        ]);
    }

    /**
     * Store a newly schedule sending.
     */
    public function store(Request $request, AuthManager $auth): Response
    {
        $this->validate($request, [
            'email_template_id' => [
                'required',
                'int',
                Rule::exists(EmailTemplate::class, 'id')->where(fn ($query) => $query->where('user_id', $auth->user()->id)),
            ],
            'customer_group_id' => [
                'required',
                'int',
                Rule::exists(CustomerGroup::class, 'id')->where(fn ($query) => $query->where('user_id', $auth->user()->id)),
            ],
            'time' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        DB::transaction(function () use ($request, $auth) {
            $schedule = SendingSchedule::create(array_merge($request->all(), [
                'time'    => Carbon::createFromFormat('Y-m-d\TH:i', $request->time ?? date('Y-m-d\TH:i')),
                'user_id' => $auth->user()->id,
            ]));

            DB::table((new SendingsCustomer)->getTable())
                ->insertUsing(
                    ['sending_schedule_id', 'customer_id'],
                    DB::table((new CustomerToGroup)->getTable())
                        ->selectRaw('? as sending_schedule_id, customer_id', [$schedule->id])
                        ->where('customer_group_id', $schedule->customer_group_id)
                );
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Sending was successfully scheduled');
    }
}
