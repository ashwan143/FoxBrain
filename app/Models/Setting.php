<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'group_name',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * Get a setting value by key.
     */
    public static function getValue(
        string $key,
        mixed $default = null
    ): mixed {
        $setting = static::where('setting_key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return static::castValue(
            $setting->setting_value,
            $setting->setting_type
        );
    }

    /**
     * Set or update a setting.
     */
    public static function setValue(
        string $key,
        mixed $value,
        string $type = 'string',
        string $group = 'general',
        bool $isPublic = false
    ): static {
        $storedValue = match ($type) {
            'boolean' => $value ? '1' : '0',
            'json', 'array' => json_encode($value),
            default => (string) $value,
        };

        return static::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_value' => $storedValue,
                'setting_type' => $type,
                'group_name' => $group,
                'is_public' => $isPublic,
            ]
        );
    }

    /**
     * Convert stored setting value to its correct PHP type.
     */
    protected static function castValue(
        mixed $value,
        ?string $type
    ): mixed {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float', 'decimal' => (float) $value,
            'json', 'array' => json_decode($value, true),
            default => $value,
        };
    }
}