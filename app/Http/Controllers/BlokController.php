<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlokController extends Controller
{
    public function index(Request $request)
    {
        $blocks = DB::table('blocks');

        if ($request->has('search')) {
            $search = $request->input('search');
            $blocks->where(function ($query) use ($search) {
                $query->where('block_name', 'like', "%{$search}%")
                    ->orWhere('year_planting', 'like', "%{$search}%")
                    ->orWhere('clone', 'like', "%{$search}%");
            });
        }

        $blocks = $blocks->paginate(20);

        return view('master-blok.index', [
            'title' => 'Data Blok',
            'blocks' => $blocks,
        ]);
    }

    public function create()
    {
        return view('master-blok.create', [
            'title' => 'Create Blok',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_name' => 'required|string|max:255',
            'year_planting' => 'required|integer',
            'clone' => 'required|string|max:50',
        ]);

        Block::create([
            'block_code' => $request->input('block_name') . '-' . $request->input('year_planting'),
            'block_name' => $validated['block_name'],
            'year_planting' => $validated['year_planting'],
            'clone' => $validated['clone'],
            'dept' => $request->input('dept'),
        ]);

        flash()->success('Blok created successfully.');

        return redirect()->route('master-blok.index');
    }

    public function edit($id)
    {
        $block = Block::findOrFail($id);

        return view('master-blok.edit', [
            'title' => 'Edit Blok',
            'block' => $block,
        ]);
    }

    public function update(Request $request, $id)
    {
        $block = Block::findOrFail($id);

        $validated = $request->validate([
            'block_name' => 'required|string|max:255',
            'year_planting' => 'required|integer',
            'clone' => 'required|string|max:50',
        ]);

        $block->update([
            'block_code' => $request->input('block_name') . '-' . $request->input('year_planting'),
            'block_name' => $validated['block_name'],
            'year_planting' => $validated['year_planting'],
            'clone' => $validated['clone'],
            'dept' => $request->input('dept'),
        ]);

        flash()->success('Blok updated successfully.');

        return redirect()->route('master-blok.index');
    }

    public function destroy($id)
    {
        $block = Block::findOrFail($id);
        $block->delete();

        flash()->success('Blok deleted successfully.');

        return redirect()->route('master-blok.index');
    }
}
