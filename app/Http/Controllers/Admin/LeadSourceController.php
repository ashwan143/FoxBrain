<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLeadSourceRequest;
use App\Http\Requests\Admin\UpdateLeadSourceRequest;
use App\Models\LeadSource;
use App\Services\Admin\LeadSourceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadSourceController extends Controller
{
    public function __construct(
        private readonly LeadSourceService $leadSourceService
    ) {
    }

    /**
     * Display a listing of lead sources.
     */
    public function index(Request $request): View
    {
        abort_unless(
            auth()->user()->hasPermission('lead_sources.view'),
            403,
            'You do not have permission to view lead sources.'
        );

        $search = $request->input('search');
        $status = $request->input('status');

        $leadSources = $this->leadSourceService->paginate(
            perPage: 15,
            search: $search,
            status: $status
        );

        return view(
            'admin.lead-sources.index',
            compact('leadSources')
        );
    }

    /**
     * Show the form for creating a new lead source.
     */
    public function create(): View
    {
        abort_unless(
            auth()->user()->hasPermission('lead_sources.create'),
            403,
            'You do not have permission to create lead sources.'
        );

        return view('admin.lead-sources.create');
    }

    /**
     * Store a newly created lead source.
     */
    public function store(
        StoreLeadSourceRequest $request
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('lead_sources.create'),
            403,
            'You do not have permission to create lead sources.'
        );

        $this->leadSourceService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.lead-sources.index')
            ->with(
                'success',
                'Lead source created successfully.'
            );
    }

    /**
     * Show the form for editing a lead source.
     */
    public function edit(LeadSource $leadSource): View
    {
        abort_unless(
            auth()->user()->hasPermission('lead_sources.edit'),
            403,
            'You do not have permission to edit lead sources.'
        );

        return view(
            'admin.lead-sources.edit',
            compact('leadSource')
        );
    }

    /**
     * Update the specified lead source.
     */
    public function update(
        UpdateLeadSourceRequest $request,
        LeadSource $leadSource
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('lead_sources.edit'),
            403,
            'You do not have permission to edit lead sources.'
        );

        $this->leadSourceService->update(
            $leadSource,
            $request->validated()
        );

        return redirect()
            ->route('admin.lead-sources.index')
            ->with(
                'success',
                'Lead source updated successfully.'
            );
    }

    /**
     * Remove the specified lead source.
     */
    public function destroy(
        LeadSource $leadSource
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('lead_sources.delete'),
            403,
            'You do not have permission to delete lead sources.'
        );

        try {
            $this->leadSourceService->delete($leadSource);

            return redirect()
                ->route('admin.lead-sources.index')
                ->with(
                    'success',
                    'Lead source deleted successfully.'
                );
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('admin.lead-sources.index')
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}