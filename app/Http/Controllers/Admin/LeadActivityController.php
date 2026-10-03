<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLeadActivityRequest;
use App\Http\Requests\Admin\UpdateLeadActivityRequest;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\SalesEmployee;
use App\Services\Admin\LeadActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadActivityController extends Controller
{
    public function __construct(
        private readonly LeadActivityService $leadActivityService
    ) {
    }

    public function index(Lead $lead): View
    {
        abort_unless(
            auth()->user()->hasPermission('leads.view'),
            403,
            'You do not have permission to view lead activities.'
        );

        $activities = $this->leadActivityService->paginate(
            $lead,
            15
        );

        return view(
            'admin.lead-activities.index',
            compact('lead', 'activities')
        );
    }

    public function create(Lead $lead): View
    {
        abort_unless(
            auth()->user()->hasPermission('leads.create'),
            403,
            'You do not have permission to create lead activities.'
        );

        $salesEmployees = SalesEmployee::query()
            ->where('status', 'active')
            ->with('user')
            ->orderBy('employee_code')
            ->get();

        return view(
            'admin.lead-activities.create',
            compact('lead', 'salesEmployees')
        );
    }

    public function store(
        StoreLeadActivityRequest $request,
        Lead $lead
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('leads.create'),
            403,
            'You do not have permission to create lead activities.'
        );

        $this->leadActivityService->create(
            $lead,
            $request->validated()
        );

        return redirect()
            ->route('admin.leads.activities.index', $lead)
            ->with(
                'success',
                'Lead activity created successfully.'
            );
    }

    public function edit(
        Lead $lead,
        LeadActivity $activity
    ): View {
        abort_unless(
            auth()->user()->hasPermission('leads.edit'),
            403,
            'You do not have permission to edit lead activities.'
        );

        abort_unless(
            $activity->lead_id === $lead->id,
            404
        );

        $salesEmployees = SalesEmployee::query()
            ->where('status', 'active')
            ->with('user')
            ->orderBy('employee_code')
            ->get();

        return view(
            'admin.lead-activities.edit',
            compact(
                'lead',
                'activity',
                'salesEmployees'
            )
        );
    }

    public function update(
        UpdateLeadActivityRequest $request,
        Lead $lead,
        LeadActivity $activity
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('leads.edit'),
            403,
            'You do not have permission to edit lead activities.'
        );

        abort_unless(
            $activity->lead_id === $lead->id,
            404
        );

        $this->leadActivityService->update(
            $activity,
            $request->validated()
        );

        return redirect()
            ->route('admin.leads.activities.index', $lead)
            ->with(
                'success',
                'Lead activity updated successfully.'
            );
    }

    public function destroy(
        Lead $lead,
        LeadActivity $activity
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('leads.delete'),
            403,
            'You do not have permission to delete lead activities.'
        );

        abort_unless(
            $activity->lead_id === $lead->id,
            404
        );

        $this->leadActivityService->delete($activity);

        return redirect()
            ->route('admin.leads.activities.index', $lead)
            ->with(
                'success',
                'Lead activity deleted successfully.'
            );
    }
}