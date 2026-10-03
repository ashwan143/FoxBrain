<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProgramRequest;
use App\Http\Requests\Admin\UpdateProgramRequest;
use App\Models\Program;
use App\Services\Admin\ProgramService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function __construct(
        private readonly ProgramService $programService
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless(
            auth()->user()->hasPermission('programs.view'),
            403,
            'You do not have permission to view programs.'
        );

        $programs = $this->programService->paginate(
            perPage: 15,
            search: $request->input('search'),
            status: $request->input('status')
        );

        return view('admin.programs.index', [
            'programs' => $programs,
            'search' => $request->input('search'),
            'status' => $request->input('status'),
        ]);
    }

    public function create(): View
    {
        abort_unless(
            auth()->user()->hasPermission('programs.create'),
            403
        );

        return view('admin.programs.create');
    }

    public function store(
        StoreProgramRequest $request
    ): RedirectResponse {
        $this->programService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }

    public function edit(Program $program): View
    {
        abort_unless(
            auth()->user()->hasPermission('programs.edit'),
            403
        );

        return view('admin.programs.edit', compact('program'));
    }

    public function update(
        UpdateProgramRequest $request,
        Program $program
    ): RedirectResponse {
        $this->programService->update(
            $program,
            $request->validated()
        );

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        abort_unless(
            auth()->user()->hasPermission('programs.delete'),
            403
        );

        $this->programService->delete($program);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }
}