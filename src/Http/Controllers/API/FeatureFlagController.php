<?php

namespace Mohamedahmed01\FeatureFlag\Http\Controllers\API;

use Illuminate\Http\Request;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;
use Illuminate\Routing\Controller;
use Mohamedahmed01\FeatureFlag\Requests\StoreFeatureFlagRequest;
use Mohamedahmed01\FeatureFlag\Requests\UpdateFeatureFlagRequest;

class FeatureFlagController extends Controller
{
    /**
     * Display a listing of the feature flags.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featureFlags = EloquentFeatureFlag::all();
        return response()->json($featureFlags);
    }

    /**
     * Store a newly created feature flag in storage.
     *
     * @param  \Mohamedahmed01\FeatureFlag\Requests\StoreFeatureFlagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeatureFlagRequest $request)
    {
        $featureFlag = EloquentFeatureFlag::create($request->validated());
        return response()->json($featureFlag, 201);
    }

    /**
     * Display the specified feature flag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $featureFlag = EloquentFeatureFlag::findOrFail($id);
        return response()->json($featureFlag);
    }

    /**
     * Update the specified feature flag in storage.
     *
     * @param  \Mohamedahmed01\FeatureFlag\Requests\UpdateFeatureFlagRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeatureFlagRequest $request, $id)
    {
        $featureFlag = EloquentFeatureFlag::findOrFail($id);
        $featureFlag->update($request->validated());
        return response()->json($featureFlag);
    }

    /**
     * Remove the specified feature flag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $featureFlag = EloquentFeatureFlag::findOrFail($id);
        $featureFlag->delete();
        return response()->json(null, 204);
    }

    /**
     * Report feature flag statistics.
     *
     * @return \Illuminate\Http\Response
     */
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

        return response()->json($statistics);
    }
}
