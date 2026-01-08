<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];
    
    protected $casts = [
        'value' => 'array',
    ];
    
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
    
    public static function setValue($key, $value, $type = 'string', $group = 'general', $description = null)
    {
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            self::create([
                'key' => $key,
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description,
            ]);
        }
    }
}