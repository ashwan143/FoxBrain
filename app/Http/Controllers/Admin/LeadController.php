<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLeadRequest;
use App\Http\Requests\Admin\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\Program;
use App\Models\SalesEmployee;
use App\Services\Admin\LeadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function __construct(
        private readonly LeadService $leadService
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless(
            auth()->user()->hasPermission('leads.view'),
            403,
            'You do not have permission to view leads.'
        );

        $leads = $this->leadService->paginate(
            perPage: 15,
            search: $request->input('search'),
            status: $request->input('status'),
            priority: $request->input('priority'),
            assignedSalesEmployeeId: $request->integer(
                'assigned_sales_employee_id'
            ) ?: null
        );

        $statistics = $this->leadService->statistics();

        $salesEmployees = SalesEmployee::query()
            ->with('user')
            ->where('status', 'active')
            ->orderBy('employee_code')
            ->get();

        return view(
            'admin.leads.index',
            compact(
                'leads',
                'statistics',
                'salesEmployees'
            )
        );
    }

    public function create(): View
    {
        abort_unless(
            auth()->user()->hasPermission('leads.create'),
            403,
            'You do not have permission to create leads.'
        );

        $leadSources = LeadSource::where(
            'is_active',
            true
        )
            ->orderBy('name')
            ->get();

        $programs = Program::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        $salesEmployees = SalesEmployee::query()
            ->with('user')
            ->where('status', 'active')
            ->orderBy('employee_code')
            ->get();

        return view(
            'admin.leads.create',
            compact(
                'leadSources',
                'programs',
                'salesEmployees'
            )
        );
    }

    public function store(
        StoreLeadRequest $request
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('leads.create'),
            403,
            'You do not have permission to create leads.'
        );

        $lead = $this->leadService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.leads.show', $lead)
            ->with(
                'success',
                'Lead created successfully.'
            );
    }

    public function show(Lead $lead): View
    {
        abort_unless(
            auth()->user()->hasPermission('leads.view'),
            403,
            'You do not have permission to view leads.'
        );

        $lead->load([
            'leadSource',
            'requiredProgram',
            'assignedSalesEmployee.user',
            'assignedSalesEmployee.manager.user',
            'creator',
            'convertedSchool',
            'activities.salesEmployee.user',
            'activities.user',
            'followups.salesEmployee.user',
            'followups.createdBy',
            'proposals',
        ]);

        return view(
            'admin.leads.show',
            compact('lead')
        );
    }

    public function edit(Lead $lead): View
    {
        abort_unless(
            auth()->user()->hasPermission('leads.edit'),
            403,
            'You do not have permission to edit leads.'
        );

        $leadSources = LeadSource::where(
            'is_active',
            true
        )
            ->orderBy('name')
            ->get();

        $programs = Program::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        $salesEmployees = SalesEmployee::query()
            ->with('user')
            ->where('status', 'active')
            ->orderBy('employee_code')
            ->get();

        return view(
            'admin.leads.edit',
            compact(
                'lead',
                'leadSources',
                'programs',
                'salesEmployees'
            )
        );
    }

    public function update(
        UpdateLeadRequest $request,
        Lead $lead
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('leads.edit'),
            403,
            'You do not have permission to edit leads.'
        );

        $this->leadService->update(
            $lead,
            $request->validated()
        );

        return redirect()
            ->route('admin.leads.show', $lead)
            ->with(
                'success',
                'Lead updated successfully.'
            );
    }

    public function destroy(
        Lead $lead
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('leads.delete'),
            403,
            'You do not have permission to delete leads.'
        );

        try {
            $this->leadService->delete($lead);

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'success',
                    'Lead deleted successfully.'
                );
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error',
                    'Unable to delete the lead.'
                );
        }
    }
}