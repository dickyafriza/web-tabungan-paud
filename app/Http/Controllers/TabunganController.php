<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tabungan;
use App\Models\Siswa;
use App\Models\Keuangan;
use Illuminate\Support\Facades\DB;
use App\Exports\TabunganExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TabunganSiswaExport;

class TabunganController extends Controller
{
    // ========================================================================
    // API ENDPOINTS - With Pagination, Filtering, Sorting
    // ========================================================================
    
    /**
     * API: Get all tabungan with pagination, filtering, and sorting
     * 
     * Pagination: ?page=1&per_page=10
     * Filtering: ?siswa_id=1&tipe=in
     * Search: ?search=keyword
     * Sorting: ?sort_by=created_at&order=desc
     * Date Range: ?start_date=2026-01-01&end_date=2026-01-31
     */
    public function apiIndex(Request $request)
    {
        $query = Tabungan::with(['siswa', 'siswa.kelas']);

        // Apply filters (siswa_id, tipe)
        $query = \App\Helper\QueryHelper::applyFilters($query, $request, [
            'siswa_id', 'tipe'
        ]);

        // Apply search (keperluan)
        if ($request->has('search') && $request->search) {
            $query->where('keperluan', 'like', '%' . $request->search . '%');
        }

        // Apply date range filter
        $query = \App\Helper\QueryHelper::applyDateRange($query, $request, 'created_at');

        // Apply sorting (default: created_at desc)
        $sortBy = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');
        
        // Validate order
        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'desc';
        }
        $query->orderBy($sortBy, $order);

        // Pagination with custom per_page
        $perPage = $request->get('per_page', 10);
        $perPage = min($perPage, 100); // Max 100 per page
        
        $tabungan = $query->paginate($perPage);

        return response()->json([
            'data' => $tabungan->items(),
            'meta' => [
                'current_page' => $tabungan->currentPage(),
                'last_page' => $tabungan->lastPage(),
                'per_page' => $tabungan->perPage(),
                'total' => $tabungan->total(),
                'from' => $tabungan->firstItem(),
                'to' => $tabungan->lastItem(),
            ],
            'links' => [
                'first' => $tabungan->url(1),
                'last' => $tabungan->url($tabungan->lastPage()),
                'prev' => $tabungan->previousPageUrl(),
                'next' => $tabungan->nextPageUrl(),
            ]
        ]);
    }

    /**
     * API: Get single tabungan by ID
     */
    public function apiShow($id)
    {
        $tabungan = Tabungan::with(['siswa', 'siswa.kelas'])->find($id);
        
        if (!$tabungan) {
            return response()->json(['message' => 'Tabungan tidak ditemukan'], 404);
        }

        return response()->json(['data' => $tabungan]);
    }

    /**
     * API: Create new tabungan transaction
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jumlah' => 'required',
            'tipe' => 'required|in:in,out',
            'keperluan' => 'nullable|string'
        ]);

        $siswa = Siswa::find($request->siswa_id);
        return $this->menabung($request, $siswa);
    }

    /**
     * API: Update tabungan (limited - mainly for keperluan/notes)
     */
    public function apiUpdate(Request $request, $id)
    {
        $tabungan = Tabungan::find($id);
        
        if (!$tabungan) {
            return response()->json(['message' => 'Tabungan tidak ditemukan'], 404);
        }

        $request->validate([
            'keperluan' => 'nullable|string'
        ]);

        $tabungan->keperluan = $request->keperluan;
        $tabungan->save();

        return response()->json([
            'message' => 'Tabungan berhasil diupdate',
            'data' => $tabungan
        ]);
    }

    /**
     * API: Delete tabungan
     */
    public function apiDestroy($id)
    {
        $tabungan = Tabungan::find($id);
        
        if (!$tabungan) {
            return response()->json(['message' => 'Tabungan tidak ditemukan'], 404);
        }

        if ($tabungan->delete()) {
            return response()->json(['message' => 'Tabungan berhasil dihapus']);
        }

        return response()->json(['message' => 'Gagal menghapus tabungan'], 500);
    }

    // ========================================================================
    // WEB ENDPOINTS
    // ========================================================================

    public function index(Request $request)
    {
        $siswa = Siswa::orderBy('created_at', 'desc')->get();
        
        $query = Tabungan::query();

        // Apply filters (siswa_id, tipe)
        $query = \App\Helper\QueryHelper::applyFilters($query, $request, [
            'siswa_id', 'tipe'
        ]);

        // Apply date range filter
        $query = \App\Helper\QueryHelper::applyDateRange($query, $request, 'created_at');

        // Apply sorting
        $query = \App\Helper\QueryHelper::applySort($query, $request, 'created_at', 'desc');

        $tabungan = $query->paginate(10);
        
        return view('tabungan.index', [
            'siswa' => $siswa,
            'tabungan' => $tabungan->appends($request->except('page')),
        ]);
    }

    public function transaksiCetak($id)
    {
        $tabungan = Tabungan::find($id);
        $siswa = $tabungan->siswa;
        $input = Tabungan::where('tipe', 'in')->where('siswa_id', $siswa->id)->sum('jumlah');
        $output = Tabungan::where('tipe', 'out')->where('siswa_id', $siswa->id)->sum('jumlah');

        $verify = Tabungan::where('siswa_id', $siswa->id)->orderBy('created_at', 'desc')->first()->saldo;
        return view('tabungan.tabunganprint', [
            'siswa' => $siswa,
            'tabungan' => $tabungan,
            'saldo' => format_idr($input - $output) . (($input - $output) == $verify ? '' : ' invalid'),
        ]);
    }

    //api manabung
    public function menabung(Request $request, Siswa $siswa)
    {
        $jumlah_bersih = preg_replace("/[,.]/", "", $request->jumlah);
        DB::beginTransaction();
        $tabungan = Tabungan::where('siswa_id', $siswa->id)->orderBy('created_at', 'desc')->first();
        if ($tabungan != null) {
            $menabung = Tabungan::make($request->except('jumlah'));
            $menabung->jumlah = $jumlah_bersih;
            if ($request->tipe == 'in') {
                $menabung->saldo = $jumlah_bersih + $tabungan->saldo;
            } else if ($request->tipe == 'out') {
                $menabung->saldo = $tabungan->saldo - $jumlah_bersih;
            }
            if ($menabung->saldo >= 0) {
                $menabung->save();
                $pesan = 'Berhasil melakukan transaksi';
            } else {
                $pesan = 'Transaksi gagal';
            }
        } else {
            $menabung = Tabungan::make($request->except('jumlah'));
            $menabung->jumlah = $jumlah_bersih;
            $menabung->saldo = $jumlah_bersih;
            $menabung->save();
            $pesan = 'Berhasil melakukan transaksi';
        }

        //tambahkan tabungan ke keuangan
        $keuangan = Keuangan::orderBy('created_at', 'desc')->first();
        if ($keuangan != null) {
            if ($menabung->tipe == 'in') {
                $jumlah = $keuangan->total_kas + $menabung->jumlah;
            } else if ($request->tipe == 'out') {
                $jumlah = $keuangan->total_kas - $menabung->jumlah;
            }
        } else {
            $jumlah = $menabung->jumlah;
        }
        $keuangan = Keuangan::create([
            'tabungan_id' => $menabung->id,
            'tipe' => $menabung->tipe,
            'jumlah' => $menabung->jumlah,
            'total_kas' => $jumlah,
            'keterangan' => 'Transaksi tabungan oleh ' . $menabung->siswa->nama . "(" . $menabung->siswa->kelas->nama . ")" .
                (($request->tipe == 'in') ? ' menabung' : ' melakukan penarikan tabungan') . ' sebesar ' . $menabung->jumlah
                . ' pada ' . $menabung->created_at . ' dengan total tabungan ' . $menabung->saldo .
                ((isset($menabung->keperluan)) ?  ' dengan catatan: ' . $menabung->keperluan : ''),
        ]);

        if ($keuangan) {
            DB::commit();
            return response()->json(['msg' => $pesan]);
        } else {
            DB::rollBack();
            return redirect()->route('tabungan.index')->with([
                'type' => 'danger',
                'msg' => 'terjadi kesalahan'
            ]);
        }
    }

    public function export()
    {
        return Excel::download(new TabunganExport, 'mutasi_tabungan-' . now() . '.xlsx');
    }

    public function cetak(Siswa $siswa)
    {
        $input = Tabungan::where('tipe', 'in')->where('siswa_id', $siswa->id)->sum('jumlah');
        $output = Tabungan::where('tipe', 'out')->where('siswa_id', $siswa->id)->sum('jumlah');

        $verify = Tabungan::where('siswa_id', $siswa->id)->orderBy('created_at', 'desc')->first()->saldo;
        $tabungan = Tabungan::where('siswa_id', $siswa->id)->orderBy('created_at', 'desc')->get();
        return view('tabungan.print', [
            'siswa' => $siswa,
            'tabungan' => $tabungan,
            'saldo' => format_idr($input - $output) . (($input - $output) == $verify ? '' : ' invalid'),
        ]);
    }

    public function siswaexport(Siswa $siswa)
    {
        return Excel::download(new TabunganSiswaExport($siswa), 'tabungan_siswa-' . now() . '.xlsx');
    }

    public function destroy($id)
    {
        $tabungan = Tabungan::find($id);

        if (!$tabungan) {
            return redirect()->route('tabungan.index')->with([
                'type' => 'danger',
                'msg' => 'Data tabungan tidak ditemukan.'
            ]);
        }

        if ($tabungan->delete()) {
            return redirect()->route('tabungan.index')->with([
                'type' => 'success',
                'msg' => 'Transaksi tabungan berhasil dihapus.'
            ]);
        } else {
            return redirect()->route('tabungan.index')->with([
                'type' => 'danger',
                'msg' => 'Err.., Terjadi kesalahan saat menghapus.'
            ]);
        }
    }
}
