<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLeadFollowupRequest;
use App\Http\Requests\Admin\UpdateLeadFollowupRequest;
use App\Models\Lead;
use App\Models\LeadFollowup;
use App\Models\SalesEmployee;
use App\Services\Admin\LeadFollowupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadFollowupController extends Controller
{
    public function __construct(
        private readonly LeadFollowupService $leadFollowupService
    ) {
    }

    public function index(Lead $lead): View
    {
        abort_unless(
            auth()->user()->hasPermission('leads.view'),
            403,
            'You do not have permission to view lead follow-ups.'
        );

        $followups = $this->leadFollowupService->paginate(
            $lead,
            15
        );

        return view(
            'admin.lead-followups.index',
            compact('lead', 'followups')
        );
    }

    public function create(Lead $lead): View
    {
        abort_unless(
            auth()->user()->hasPermission('leads.create'),
            403,
            'You do not have permission to create lead follow-ups.'
        );

        $salesEmployees = SalesEmployee::query()
            ->where('status', 'active')
            ->with('user')
            ->orderBy('employee_code')
            ->get();

        return view(
            'admin.lead-followups.create',
            compact('lead', 'salesEmployees')
        );
    }

    public function store(
        StoreLeadFollowupRequest $request,
        Lead $lead
    ): RedirectResponse {
        $this->leadFollowupService->create(
            $lead,
            $request->validated()
        );

        return redirect()
            ->route('admin.leads.followups.index', $lead)
            ->with(
                'success',
                'Lead follow-up created successfully.'
            );
    }

    public function edit(
        Lead $lead,
        LeadFollowup $followup
    ): View {
        abort_unless(
            auth()->user()->hasPermission('leads.edit'),
            403,
            'You do not have permission to edit lead follow-ups.'
        );

        abort_unless(
            $followup->lead_id === $lead->id,
            404
        );

        $salesEmployees = SalesEmployee::query()
            ->where('status', 'active')
            ->with('user')
            ->orderBy('employee_code')
            ->get();

        return view(
            'admin.lead-followups.edit',
            compact(
                'lead',
                'followup',
                'salesEmployees'
            )
        );
    }

    public function update(
        UpdateLeadFollowupRequest $request,
        Lead $lead,
        LeadFollowup $followup
    ): RedirectResponse {
        abort_unless(
            $followup->lead_id === $lead->id,
            404
        );

        $this->leadFollowupService->update(
            $followup,
            $request->validated()
        );

        return redirect()
            ->route('admin.leads.followups.index', $lead)
            ->with(
                'success',
                'Lead follow-up updated successfully.'
            );
    }

    public function destroy(
        Lead $lead,
        LeadFollowup $followup
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('leads.delete'),
            403,
            'You do not have permission to delete lead follow-ups.'
        );

        abort_unless(
            $followup->lead_id === $lead->id,
            404
        );

        $this->leadFollowupService->delete($followup);

        return redirect()
            ->route('admin.leads.followups.index', $lead)
            ->with(
                'success',
                'Lead follow-up deleted successfully.'
            );
    }
}