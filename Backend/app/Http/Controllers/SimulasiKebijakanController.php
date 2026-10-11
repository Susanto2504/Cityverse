<?php

namespace App\Http\Controllers;

use App\Models\SimulasiKebijakan;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class SimulasiKebijakanController extends Controller
{
    public function index(Request $request)
    {
        $query = SimulasiKebijakan::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_kebijakan')) {
            $query->where('jenis_kebijakan', $request->jenis_kebijakan);
        }

        if ($request->filled('start')) {
            $query->whereDate('created_at', '>=', $request->start);
        }

        if ($request->filled('end')) {
            $query->whereDate('created_at', '<=', $request->end);
        }

        $data = $query
            ->latest()
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'jenis_kebijakan' => 'required|string|max:100',
            'jenis_label' => 'nullable|string|max:255',
            'skenario' => 'required|string',
            'target' => 'nullable',
            'ruas_awal_id' => 'nullable',
            'ruas_target_id' => 'nullable',
            'rekayasa_lalu_lintas' => 'nullable|array',
            'baseline' => 'nullable',
            'domains' => 'nullable|array',
            'hasil_ai' => 'required|array',
            'kesimpulan' => 'nullable|string',
            'status' => 'nullable|in:draft,diajukan,diterapkan',
        ]);

        if (
            $validated['jenis_kebijakan'] === 'rekayasa_lalu_lintas' &&
            isset($validated['ruas_awal_id'], $validated['ruas_target_id']) &&
            (string) $validated['ruas_awal_id'] === (string) $validated['ruas_target_id']
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ruas awal dan ruas target tidak boleh sama.',
            ], 422);
        }

        $simulasi = SimulasiKebijakan::create([
            'judul' => $validated['judul'] ?? 'Tanpa Judul',
            'jenis_kebijakan' => $validated['jenis_kebijakan'],
            'jenis_label' => $validated['jenis_label'] ?? $validated['jenis_kebijakan'],
            'skenario' => $validated['skenario'],
            'target' => $validated['target'] ?? null,
            'ruas_awal_id' => $validated['ruas_awal_id'] ?? null,
            'ruas_target_id' => $validated['ruas_target_id'] ?? null,
            'rekayasa_lalu_lintas' => $validated['rekayasa_lalu_lintas'] ?? null,
            'baseline' => $validated['baseline'] ?? null,
            'domains' => $validated['domains'] ?? null,
            'hasil_ai' => $validated['hasil_ai'],
            'hasil_penerapan' => null,
            'kesimpulan' => $validated['kesimpulan'] ?? null,
            'status' => $validated['status'] ?? 'draft',
        ]);

        Log::info('SIMULASI KEBIJAKAN DISIMPAN', [
            'id' => $simulasi->id,
            'jenis' => $simulasi->jenis_kebijakan,
            'status' => $simulasi->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Draf simulasi berhasil disimpan.',
            'data' => $simulasi,
        ], 201);
    }

    public function show(SimulasiKebijakan $simulasiKebijakan)
    {
        return response()->json([
            'status' => 'success',
            'data' => $simulasiKebijakan,
        ]);
    }

    public function update(Request $request, SimulasiKebijakan $simulasiKebijakan)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'jenis_kebijakan' => 'sometimes|required|string|max:100',
            'jenis_label' => 'nullable|string|max:255',
            'skenario' => 'sometimes|required|string',
            'target' => 'nullable',
            'ruas_awal_id' => 'nullable',
            'ruas_target_id' => 'nullable',
            'rekayasa_lalu_lintas' => 'nullable|array',
            'baseline' => 'nullable',
            'domains' => 'nullable|array',
            'hasil_ai' => 'sometimes|required|array',
            'hasil_penerapan' => 'nullable|array',
            'kesimpulan' => 'nullable|string',
            'status' => 'nullable|in:draft,diajukan,diterapkan',
        ]);

        if (
            ($validated['jenis_kebijakan'] ?? $simulasiKebijakan->jenis_kebijakan) === 'rekayasa_lalu_lintas' &&
            isset($validated['ruas_awal_id'], $validated['ruas_target_id']) &&
            (string) $validated['ruas_awal_id'] === (string) $validated['ruas_target_id']
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ruas awal dan ruas target tidak boleh sama.',
            ], 422);
        }

        $statusSebelumnya = $simulasiKebijakan->status;
        $simulasiKebijakan->update($validated);

        if (
            $statusSebelumnya !== 'diterapkan' &&
            $simulasiKebijakan->status === 'diterapkan'
        ) {
            Notification::create([
                'type' => 'kebijakan',
                'title' => 'Kebijakan Diterapkan',
                'message' => 'Kebijakan ' . $simulasiKebijakan->judul . ' telah diterapkan',
                'is_read' => false,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Simulasi berhasil diperbarui.',
            'data' => $simulasiKebijakan->fresh(),
        ]);
    }

    public function destroy(SimulasiKebijakan $simulasiKebijakan)
    {
        $simulasiKebijakan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Simulasi berhasil dihapus.',
        ]);
    }
}