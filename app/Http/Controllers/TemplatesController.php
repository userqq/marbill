<?php

namespace App\Http\Controllers;

use ValueError;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Customer;
use App\Models\EmailTemplate;

class TemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthManager $auth): View
    {
        return view('templates.index', ['templates' => EmailTemplate::where('user_id', $auth->user()->id)->get()]);
    }

    /**
     * Show the form for creating a new template.
     */
    public function create(): View
    {
        return view('templates.create', ['placeholders' => collect(Customer::getPlacholderProperties())]);
    }

    /**
     * Store a newly created template.
     */
    public function store(Request $request, AuthManager $auth): Response
    {
        $templateValidation = function ($attribute, $value, $fail) {
            try {
                EmailTemplate::validate($value, Customer::getPlacholderProperties());
            } catch (ValueError $e) {
                $fail($e->getMessage());
            }
        };

        $this->validate($request, [
            'subject' => [
                'required',
                'string',
                'max:255',
                $templateValidation,
                Rule::unique(EmailTemplate::class)->where(fn ($query) => $query->where('user_id', $auth->user()->id))
            ],
            'body' => [
                'required',
                'string',
                'max:65535',
                $templateValidation,
            ],
        ]);

        $template = EmailTemplate::create(array_merge($request->all(), ['user_id' => $auth->user()->id]));

        return redirect()
            ->route('templates')
            ->with('success', sprintf('Customer %s successfully created', $request->subject));
    }
}
