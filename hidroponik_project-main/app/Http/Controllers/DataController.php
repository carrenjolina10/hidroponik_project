<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;


class DataController extends Controller
{
    public function index()
    {
    $histories = Data::orderBy('created_at', 'asc')->get();

    return view('index', compact('histories'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idTumbuhan' => 'required|string|max:11',
            'suhu' => 'required|numeric',
            'pH' => 'required|numeric',
            'nutrisi' => 'required|numeric',
        ]);

        Data::create($validated);

        return redirect()
            ->route('data')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    public function record(Request $request)
    {
        try {
            $validated = $request->validate([
                'idTumbuhan' => 'required|string|max:11',
                'suhu' => 'required|numeric',
                'pH' => 'required|numeric',
                'nutrisi' => 'required|numeric',
            ]);

            $data = Data::create([
                'idTumbuhan' => $validated['idTumbuhan'],
                'suhu' => $validated['suhu'],
                'pH' => $validated['pH'],
                'nutrisi' => $validated['nutrisi'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $data
            ], 201);

        } catch (\Throwable $e) {

            \Log::error('AUTO RECORD ERROR', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Data $data)
    {
        return view('data', compact('data'));
    }

    public function edit(Data $data)
    {
        return view('data', compact('data'));
    }

    public function update(Request $request, Data $data)
    {
        $validated = $request->validate([
            'idTumbuhan' => 'required|string|max:11',
            'suhu' => 'required|numeric',
            'pH' => 'required|numeric',
            'nutrisi' => 'required|numeric',
        ]);

        $data->update($validated);

        return redirect()
            ->route('data')
            ->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(Data $data)
    {
        $data->delete();

        return redirect()
            ->route('data')
            ->with('success', 'Data berhasil dihapus!');
    }

    public function data()
    {
        $histories = Data::orderByDesc('created_at')->paginate(20);

        return view('data', compact('histories'));
    }
}