<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use App\Models\LevelModels;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        return LevelModels::all();
    }

    public function store(Request $request)
    {
        $level = LevelModels::create($request->all());
        return response()->json($level, 201);
    }

    public function show(LevelModels $level)
    {
        return LevelModels::find($level);
    }

    public function update(Request $request, LevelModels $level)
    {
        $level->update($request->all());
        return LevelModels::find($level);
    }

    public function destroy(LevelModels $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
