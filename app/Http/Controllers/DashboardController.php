<?php

namespace App\Http\Controllers;

use App\Models\Workorder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workorders = Workorder::with('listMaterials.material')->get();

        $currentDateTime = Carbon::now();
        $startTime24Hours = $currentDateTime->copy()->subHours(24);
        $startTimeWeek = $currentDateTime->copy()->subWeek();
        $startTimeMonth = $currentDateTime->copy()->subMonth();
        $startTimeYear = $currentDateTime->copy()->subYear();
        
        $totalCost24Hours = 0;
        $totalCostWeek = 0;
        $totalCostMonth = 0;
        $totalCostYear = 0;
        
        foreach ($workorders as $workorder) {
            foreach ($workorder->listMaterials as $material) {
                $materialCreatedAt = Carbon::parse($material->created_at);
        
                if ($materialCreatedAt->between($startTime24Hours, $currentDateTime)) {
                    $totalCost24Hours += $material->count * $material->material->harga;
                }
        
                if ($materialCreatedAt->between($startTimeWeek, $currentDateTime)) {
                    $totalCostWeek += $material->count * $material->material->harga;
                }
        
                if ($materialCreatedAt->between($startTimeMonth, $currentDateTime)) {
                    $totalCostMonth += $material->count * $material->material->harga;
                }
        
                if ($materialCreatedAt->between($startTimeYear, $currentDateTime)) {
                    $totalCostYear += $material->count * $material->material->harga;
                }
            }
        }
        
        return view('dashboard.index', compact('totalCost24Hours', 'totalCostWeek', 'totalCostMonth', 'totalCostYear'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workorder $workorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workorder $workorder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workorder $workorder)
    {
        //
    }
}
