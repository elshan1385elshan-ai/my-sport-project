<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = AppSetting::allSettings();
        $adminIconOptions = AppSetting::adminIconOptions();
        $publicIconOptions = AppSetting::publicIconOptions();
        $fontOptions = AppSetting::fontOptions();

        $mediaFiles = collect(Storage::disk('public')->files('icons'))
            ->filter(fn ($path) => in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico']))
            ->map(fn ($path) => [
                'name' => basename($path),
                'url' => Storage::url($path),
                'path' => $path,
            ])
            ->values();

        return view('admin.settings.edit', compact('settings', 'adminIconOptions', 'publicIconOptions', 'fontOptions', 'mediaFiles'));
    }

    public function update(Request $request)
    {
        $adminIcons = array_keys(AppSetting::adminIconOptions());
        $publicIcons = array_keys(AppSetting::publicIconOptions());
        $fontFamilies = array_keys(AppSetting::fontOptions());

        $validated = $request->validate([
            'app_name' => 'required|string|max:100',
            'page_title_prefix' => 'required|string|max:50',
            'font_family' => 'required|string|in:' . implode(',', $fontFamilies),
            'admin_icon' => 'required|string|in:' . implode(',', $adminIcons),
            'admin_icon_type' => 'required|in:font,custom',
            'admin_icon_custom' => 'nullable|string|max:255',
            'public_icon' => 'required|string|in:' . implode(',', $publicIcons),
            'public_icon_type' => 'required|in:font,custom',
            'public_icon_custom' => 'nullable|string|max:255',
            'welcome_message' => 'required|string|max:255',
            'footer_description' => 'required|string|max:500',
            'search_placeholder' => 'required|string|max:100',
            'copyright_text' => 'required|string|max:255',
            'admin_panel_subtitle' => 'required|string|max:100',
            'contact_address' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:50',
            'contact_email' => 'required|email|max:100',
            'contact_hours' => 'required|string|max:100',
        ]);

        if ($request->hasFile('admin_icon_upload')) {
            $request->validate([
                'admin_icon_upload' => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp,ico|max:2048',
            ]);
            $file = $request->file('admin_icon_upload');
            $name = 'admin-icon-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('icons', $name, 'public');
            $validated['admin_icon_custom'] = $path;
            $validated['admin_icon_type'] = 'custom';
        }

        if ($request->hasFile('public_icon_upload')) {
            $request->validate([
                'public_icon_upload' => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp,ico|max:2048',
            ]);
            $file = $request->file('public_icon_upload');
            $name = 'public-icon-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('icons', $name, 'public');
            $validated['public_icon_custom'] = $path;
            $validated['public_icon_type'] = 'custom';
        }

        AppSetting::setMany($validated);

        return redirect()->route('settings.edit')->with('success', 'تنظیمات اپلیکیشن با موفقیت ذخیره شد');
    }
}
