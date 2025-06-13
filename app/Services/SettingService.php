<?php
namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public static function getSettings(array $columns, $tenantId)
    {
         $finalResult = [];
        $settings = Setting::whereIn('key', $columns)
            ->with(['settings' => function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            }])
            ->get();
        foreach ($columns as $column) {
            $setting = $settings->firstWhere('key', $column);

            if ($setting) {
                $tenantSetting = $setting->settings->first();
                if($setting->type == "file")
                {
                    $finalResult[$column] = $tenantSetting ? asset($tenantSetting->value) : asset($setting->value);
                }
                else
                {
                    $finalResult[$column] = $tenantSetting ? $tenantSetting->value : $setting->value;
                }
            } else {
                $finalResult[$column] = '';
            }
        }
        return $finalResult;
    }
}
