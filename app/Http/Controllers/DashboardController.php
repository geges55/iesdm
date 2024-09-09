<?php

namespace App\Http\Controllers;

use App\Models\PermitWork;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama.
     */
    public function index()
    {
        // Data statistik untuk dashboard
        $totalPengajuan = PermitWork::count();
        $totalDisetujui = PermitWork::where('status', 'approved')->count();
        $totalPending = PermitWork::where('status', 'pending')->count();
        $totalDitolak = PermitWork::where('status', 'rejected')->count();

        return view('dashboard.index', compact('totalPengajuan', 'totalDisetujui', 'totalPending', 'totalDitolak'));
    }
}
