<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Region $region)
    {
        return response()->json($region->districts);
    }

    public function store(Request $request, Region $region)
    {
        $fields = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'district' => 'required|max:255',
            'category' => 'required|max:255',
            'capital' => 'required|max:255',
            'established' => 'required|integer',
        ]);

        $district = $region->districts()->create($fields);

        return response()->json($district, 201);
    }

    public function show(Region $region, District $district)
    {
        if ($district->region_id != $region->id) {
            return response()->json(['error' => 'District does not belong to this region'], 404);
        }

        return response()->json($district);
    }

    public function update(Request $request, Region $region, District $district)
    {
        if ($district->region_id != $region->id) {
            return response()->json(['error' => 'District does not belong to this region'], 404);
        }

        $fields = $request->validate([
            'region_id' => 'sometimes|exists:regions,id',
            'district' => 'sometimes|max:255',
            'category' => 'sometimes|max:255',
            'capital' => 'sometimes|max:255',
            'established' => 'sometimes|integer',
        ]);

        if (isset($fields['region_id']) && $district->region_id != $fields['region_id']) {
            $district->region_id = $fields['region_id'];
        }

        $district->update($fields);

        return response()->json($district);
    }

    public function destroy(Region $region, District $district)
    {
        if ($district->region_id != $region->id) {
            return response()->json(['error' => 'District does not belong to this region'], 404);
        }

        $district->delete();

        return response()->json(['message' => 'District deleted successfully']);
    }

    public function search(Request $request, Region $region)
    {
        $query = $region->districts();

        if ($request->has('region_id')) {
            $query->where('region_id', 'like', '%' . $request->region_id. '%');
        }

        if ($request->has('district')) {
            $query->where('district', 'like', '%' . $request->district . '%');
        }

        if ($request->has('category')) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }

        if ($request->has('capital')) {
            $query->where('capital', 'like', '%' . $request->capital . '%');
        }

        if ($request->has('established')) {
            $query->where('establised', 'like', '%' . $request->name . '%');
        }

        return response()->json($query->get());
    }
}
