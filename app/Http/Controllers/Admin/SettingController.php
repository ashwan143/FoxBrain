<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Services\Admin\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingService $settingService
    ) {
    }

    public function index(): View
    {
        abort_unless(
            auth()->user()->hasPermission('settings.view'),
            403,
            'You do not have permission to view settings.'
        );

        $settings = $this->settingService->getSettings();

        return view(
            'admin.settings.index',
            compact('settings')
        );
    }

    public function update(
        UpdateSettingsRequest $request
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('settings.edit'),
            403,
            'You do not have permission to edit settings.'
        );

        $this->settingService->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.settings.index')
            ->with(
                'success',
                'System settings updated successfully.'
            );
    }
}