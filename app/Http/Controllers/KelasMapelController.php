<?php

namespace App\Http\Controllers;

use App\Exports\NilaiTugasExport;
use App\Exports\NilaiUjianExport;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Rekomendasi;
use App\Models\Pengumuman;
use App\Models\Diskusi;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KelasMapelController extends Controller
{
    /**
     * Menampilkan halaman kelas dan mata pelajaran tertentu.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function viewKelasMapel($x, $token, Request $request)
    {
        if ($token) {
            // Request = mapel id
            $id = decrypt($token);
            $mapel = Mapel::where('id', $request->mapel_id)->first();
            $kelas = Kelas::where('id', $id)->first();
            $kelasMapel = KelasMapel::where('mapel_id', $request->mapel_id)->where('kelas_id', $id)->first();
            $materi = Materi::where('kelas_mapel_id', $kelasMapel['id'])->get();
            $rekomendasi = Rekomendasi::where('kelas_mapel_id', $kelasMapel['id'])->get();
            $pengumuman = Pengumuman::where('kelas_mapel_id', $kelasMapel['id'])->get();
            $diskusi = Diskusi::where('kelas_mapel_id', $kelasMapel['id'])->get();
            $tugas = Tugas::where('kelas_mapel_id', $kelasMapel['id'])->get();
            $ujian = Ujian::where('kelas_mapel_id', $kelasMapel['id'])->get();
            $roles = DashboardController::getRolesName();
            $assignedKelas = DashboardController::getAssignedClass();
            $editor = null;

            // Editor Data
            if (count($kelasMapel->EditorAccess) > 0) {
                $editor = User::where('id', $kelasMapel->EditorAccess[0]->user_id)->first();
                $editor = [
                    'name' => $editor['name'],
                    'id' => $editor['id'],
                ];
            }

            return view('menu.kelasMapel.viewKelasMapel', ['editor' => $editor, 'assignedKelas' => $assignedKelas, 'diskusi' => $diskusi, 'pengumuman' => $pengumuman, 'roles' => $roles, 'title' => 'Dashboard', 'kelasMapel' => $kelasMapel, 'ujian' => $ujian, 'materi' => $materi, 'mapel' => $mapel, 'kelas' => $kelas, 'tugas' => $tugas, 'rekomendasi' => $rekomendasi]);
        } else {
            abort(404);
        }
    }

    public function viewAllActivities()
    {
        // Ambil semua materi dan pengumuman
        $materi = Materi::all();
        $pengumuman = Pengumuman::all();
        $rekomendasi = Rekomendasi::all();
        $diskusi = Diskusi::all();
        $tugas = Tugas::all();
        $ujian = Ujian::all();
        $roles = DashboardController::getRolesName();
        
        // Ambil semua kelasMapel
        $kelasMapel = KelasMapel::all();
        
        // Array untuk menyimpan data editor
        $editors = [];
    
        foreach ($kelasMapel as $km) {
            if (count($km->EditorAccess) > 0) {
                $editor = User::where('id', $km->EditorAccess[0]->user_id)->first();
                $editors[$km->id] = [
                    'name' => $editor->name,
                    'id' => $editor->id,
                ];
            } else {
                $editors[$km->id] = null;
            }
        }
    
        return view('menu.admin.activity', [
            'materi' => $materi,
            'pengumuman' => $pengumuman,
            'rekomendasi' => $rekomendasi,
            'diskusi' => $diskusi,
            'tugas' => $tugas,
            'ujian' => $ujian,
            'title' => 'Activity',
            'roles' => $roles,
            'editors' => $editors
        ]);
    }
    

    /**
     * Metode untuk menyimpan gambar sementara.
     *
     * @return \Illuminate\View\View
     */
    public function saveImageTemp(Request $request)
    {

        $roles = DashboardController::getRolesName();
        $assignedKelas = DashboardController::getAssignedClass();

        return view('menu.mapelKelas.viewKelasMapel', ['assignedKelas' => $assignedKelas, 'roles' => $roles, 'title' => 'Dashboard']);
    }

    public function exportNilaiTugas(Request $request)
    {
        return Excel::download(new NilaiTugasExport($request->tugasId, $request->kelasMapelId), 'export-kelas.xls');
    }

    public function exportNilaiUjian(Request $request)
    {
        return Excel::download(new NilaiUjianExport($request->ujianId, $request->kelasMapelId), 'export-kelas.xls');
    }
}
