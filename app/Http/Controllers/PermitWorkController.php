<?php

namespace App\Http\Controllers;

use App\Models\PermitWork;
use App\Models\Document;
use App\Notifications\IzinStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermitWorkController extends Controller
{
    /**
     * Menampilkan daftar pengajuan izin untuk pemohon.
     */
    public function index()
    {
        $permitWorks = PermitWork::where('user_id', Auth::id())->get();
        return view('permit_works.index', compact('permitWorks'));
    }

    /**
     * Menampilkan formulir pengajuan izin baru.
     */
    public function create()
    {
        return view('permit_works.create');
    }

    /**
     * Menyimpan pengajuan izin baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'permit_type' => 'required|string',
            'description' => 'required|string',
            'document.*' => 'file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Simpan data pengajuan izin
        $permitWork = new PermitWork();
        $permitWork->company_name = $request->company_name;
        $permitWork->permit_type = $request->permit_type;
        $permitWork->description = $request->description;
        $permitWork->status = 'pending';
        $permitWork->user_id = Auth::id();
        $permitWork->save();

        // Simpan dokumen pendukung jika ada
        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $file) {
                $path = $file->store('documents', 'public');
                $permitWork->documents()->create(['path' => $path]);
            }
        }

        return redirect()->route('permit-works.index')->with('success', 'Pengajuan izin berhasil disimpan.');
    }

    /**
     * Menampilkan detail pengajuan izin tertentu.
     */
    public function show($id)
    {
        $permitWork = PermitWork::findOrFail($id);
        return view('permit_works.show', compact('permitWork'));
    }

    /**
     * Menampilkan formulir edit pengajuan izin.
     */
    public function edit($id)
    {
        $permitWork = PermitWork::findOrFail($id);
        $permitTypes = ['Izin Pertambangan', 'Izin Energi']; // Daftar tipe izin
    
        return view('permit_works.edit', compact('permitWork', 'permitTypes'));
    }

    /**
     * Memperbarui pengajuan izin yang ada.
     */
    public function update(Request $request, $id)
    {
        $permitWork = PermitWork::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'permit_type' => 'required|string',
            'description' => 'required|string',
            'document.*' => 'file|mimes:pdf,jpg,png|max:2048',
        ]);

        $permitWork->update($request->only(['company_name', 'permit_type', 'description']));

            // Simpan dokumen tambahan jika ada
        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $file) {
                $path = $file->store('documents', 'public');
                $permitWork->documents()->create(['path' => $path]);
            }
        }

        return redirect()->route('permit-works.index')->with('success', 'Pengajuan izin berhasil diperbarui.');
    }

    /**
     * Menghapus pengajuan izin.
     */
    public function destroy($id)
    {
        $permitWork = PermitWork::findOrFail($id);
        $permitWork->delete();

        return redirect()->route('permit-works.index')->with('success', 'Pengajuan izin berhasil dihapus.');
    }

    /**
     * Menampilkan daftar pengajuan izin untuk verifikasi oleh verifikator.
     */
    public function indexVerify()
    {
        if (Auth::user()->role !== 'verifikator') {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    
        $permitWorks = PermitWork::where('status', 'pending')->get();
        return view('permit_works.verify', compact('permitWorks'));
    }

    /**
     * Memproses verifikasi pengajuan izin.
     */
    public function verify(Request $request, $id)
    {
        $permitWork = PermitWork::findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,rejected,need_revision',
            'feedback' => 'nullable|string|max:255',
        ]);

        $permitWork->status = $request->status;
        $permitWork->feedback = $request->feedback;
        $permitWork->verified_by = Auth::user()->id;
        $permitWork->save();

        // Kirim notifikasi email kepada pemohon izin
        $permitWork->user->notify(new IzinStatusNotification($permitWork, $request->status, $request->feedback));

        return redirect()->route('permit-works.verify')->with('success', 'Pengajuan izin telah diverifikasi.');
    }

    /**
     * Menampilkan laporan rekap pengajuan izin per bulan untuk supervisor.
     */
    public function report(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $permitWorks = PermitWork::whereMonth('created_at', $month)
                                 ->whereYear('created_at', $year)
                                 ->get();

        return view('permit_works.report', compact('permitWorks', 'month', 'year'));
    }
}
