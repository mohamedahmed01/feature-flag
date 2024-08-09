<?php

namespace Mohamedahmed01\FeatureFlag\Http\Controllers;

use Illuminate\Http\Request;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;
use Illuminate\Routing\Controller;
use Mohamedahmed01\FeatureFlag\Requests\StoreFeatureFlagRequest;
use Mohamedahmed01\FeatureFlag\Requests\UpdateFeatureFlagRequest;

class FeatureFlagController extends Controller
{
    public function index()
    {
        $featureFlags = EloquentFeatureFlag::all();
        return view('feature-flag::feature-flags.index', compact('featureFlags'));
    }

    public function create()
    {
        return view('feature-flag::feature-flags.create');
    }

    public function store(StoreFeatureFlagRequest $request)
    {
        $featureFlag = EloquentFeatureFlag::create($request->validated());
        return redirect()->route('feature-flags-web.index')->with('success', 'Feature flag created successfully.');
    }

    public function show($id)
    {
        $featureFlag = EloquentFeatureFlag::findOrFail($id);
        return view('feature-flag::feature-flags.show', compact('featureFlag'));
    }

    public function edit($id)
    {
        $featureFlag = EloquentFeatureFlag::findOrFail($id);
        return view('feature-flag::feature-flags.edit', compact('featureFlag'));
    }

    public function update(UpdateFeatureFlagRequest $request, $id)
    {
        $featureFlag = EloquentFeatureFlag::findOrFail($id);
        $featureFlag->update($request->validated());
        return redirect()->route('feature-flags-web.index')->with('success', 'Feature flag updated successfully.');
    }

    public function destroy($id)
    {
        $featureFlag = EloquentFeatureFlag::findOrFail($id);
        $featureFlag->delete();
        return redirect()->route('feature-flags-web.index')->with('success', 'Feature flag deleted successfully.');
    }

    public function report()
    {
        $totalFlags = EloquentFeatureFlag::count();
        $enabledFlags = EloquentFeatureFlag::where('enabled', true)->count();
        $disabledFlags = EloquentFeatureFlag::where('enabled', false)->count();
        $targetedFlags = EloquentFeatureFlag::whereNotNull('audience')->count();
        $untargetedFlags = $totalFlags - $targetedFlags;

        $statistics = [
            'total_flags' => $totalFlags,
            'enabled_flags' => $enabledFlags,
            'disabled_flags' => $disabledFlags,
            'targeted_flags' => $targetedFlags,
            'untargeted_flags' => $untargetedFlags,
        ];

        return view('feature-flag::feature-flags.report', compact('statistics'));
    }
}
