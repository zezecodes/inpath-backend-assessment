<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    // Displays all regions
    public function index()
    {
        return Region::all();
    }

    // Creates regions 
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'capital' => 'required'
        ]);
        $region = Region::create($fields);
        return $region;
    }

    // Shows particular regions
    public function show(Region $region)
    {
        return $region;
    }

    // Updates regions
    public function update(Request $request, Region $region)
    {
        $fields = $request->validate([
            'name' => 'sometimes|max:255',
            'capital' => 'sometimes'
        ]);
        $region->update($fields);
        return $region;
    }

    // Deletes regions
    public function destroy(Region $region)
    {
        $region->delete();
        return ['region' => "Region was deleted from the database"];
    }

    // Searches for regions
    public function search(Request $request)
    {
        $query = Region::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('capital')) {
            $query->where('capital', 'like', '%' . $request->capital . '%');
        }

        return response()->json($query->get());
    }
}
