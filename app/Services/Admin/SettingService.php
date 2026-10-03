<?php

namespace App\Services\Admin;

use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingService
{
    public function getSettings(): array
    {
        return [
            'site_name' => Setting::getValue(
                'site_name',
                'FoxBrain ERP'
            ),

            'company_name' => Setting::getValue(
                'company_name',
                'FoxBrain Pvt. Ltd.'
            ),

            'site_email' => Setting::getValue(
                'site_email',
                ''
            ),

            'site_phone' => Setting::getValue(
                'site_phone',
                ''
            ),

            'currency' => Setting::getValue(
                'currency',
                'INR'
            ),

            'timezone' => Setting::getValue(
                'timezone',
                'Asia/Kolkata'
            ),

            'date_format' => Setting::getValue(
                'date_format',
                'd-m-Y'
            ),
        ];
    }

    public function update(array $data): void
    {
        DB::transaction(function () use ($data) {

            $oldValues = [];

            foreach ($data as $key => $value) {
                $oldValues[$key] = Setting::getValue($key);
            }

            foreach ($data as $key => $value) {
                Setting::setValue($key, $value);
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'module' => 'settings',
                'description' => 'System settings were updated.',
                'subject_type' => Setting::class,
                'subject_id' => null,
                'old_values' => $oldValues,
                'new_values' => $data,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }
}