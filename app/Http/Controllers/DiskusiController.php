<?php

namespace App\Http\Controllers;

use App\Models\EditorAccess;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Mapel;
use App\Models\Diskusi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;


/**
 * Class : DiskusiController
 *
 * Class ini berisi berbagai fungsi yang berkaitan dengan manipulasi data-data diskusi, terutama terkait dengan model.

 */
class DiskusiController extends Controller
{
    /**
     * Menampilkan halaman Tambah Diskusi.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function viewCreateDiskusi($token, Request $request)
    {
        // id = Kelas Id
        $id = decrypt($token);
        $kelasMapel = KelasMapel::where('mapel_id', $request->mapelId)->where('kelas_id', $id)->first();

        $preparedIdDiskusi = count(Diskusi::get());
        $preparedIdDiskusi = $preparedIdDiskusi + 1;
        // Logika untuk memeriksa apakah pengguna yang sudah login memiliki akses editor
        foreach (Auth()->User()->EditorAccess as $key) {
            if ($key->kelas_mapel_id == $kelasMapel['id']) {
                $roles = DashboardController::getRolesName();
                $mapel = Mapel::where('id', $request->mapelId)->first();

                $assignedKelas = DashboardController::getAssignedClass();

                return view('menu.pengajar.diskusi.viewTambahDiskusi', ['assignedKelas' => $assignedKelas, 'title' => 'Tambah Diskusi', 'roles' => $roles, 'kelasId' => $id, 'mapel' => $mapel, 'preparedIdDiskusi' => $preparedIdDiskusi]);
            }
        }
        abort(404);
    }

    /**
     * Menampilkan halaman Update Diskusi.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function viewUpdateDiskusi($token, Request $request)
    {
        // token = Diskusi Id
        $id = decrypt($token);
        $diskusi = Diskusi::where('id', $id)->first();  // Dapatkan Diskusi

        // Dapatkan kelas mapel untuk dibandingkan dengan diskusi
        $kelasMapel = KelasMapel::where('id', $diskusi->kelas_mapel_id)->first();

        // Logika untuk memeriksa apakah pengguna yang sudah login memiliki akses editor
        foreach (Auth()->User()->EditorAccess as $key) {
            if ($key->kelas_mapel_id == $kelasMapel['id']) {
                $roles = DashboardController::getRolesName();
                $mapel = Mapel::where('id', $request->mapelId)->first();

                $kelas = Kelas::where('id', $kelasMapel['kelas_id'])->first('id');

                $assignedKelas = DashboardController::getAssignedClass();

                return view('menu.pengajar.diskusi.viewUpdateDiskusi', ['assignedKelas' => $assignedKelas, 'title' => 'Update Diskusi', 'diskusi' => $diskusi, 'roles' => $roles, 'kelasId' => $kelas['id'], 'mapel' => $mapel, 'kelasMapel' => $kelasMapel]);
            }
        }
        abort(404);
    }

    /**
     * Menampilkan halaman Diskusi.
     *
     * @return \Illuminate\View\View
     */
    public function viewDiskusi(Request $request)
    {
        // diskusi id
        $id = decrypt($request->token);
        //kelasMapel id
        $idx = decrypt($request->kelasMapelId);

        $diskusi = Diskusi::where('id', $id)->first();

        $roles = DashboardController::getRolesName();
        $kelasMapel = KelasMapel::where('id', $diskusi->kelas_mapel_id)->first();

        // Dapatkan Pengajar
        $editorAccess = EditorAccess::where('kelas_mapel_id', $kelasMapel['id'])->first();
        $editorData = User::where('id', $editorAccess['user_id'])->where('roles_id', 2)->first();

        $mapel = Mapel::where('id', $request->mapelId)->first();
        $kelas = Kelas::where('id', $kelasMapel['kelas_id'])->first('id');

        $diskusiAll = Diskusi::where('kelas_mapel_id', $idx)->get();

        $assignedKelas = DashboardController::getAssignedClass();

        return view('menu.pengajar.diskusi.viewDiskusi', ['assignedKelas' => $assignedKelas, 'editor' => $editorData, 'diskusi' => $diskusi, 'kelas' => $kelas, 'title' => $diskusi->name, 'roles' => $roles, 'diskusiAll' => $diskusiAll, 'mapel' => $mapel, 'kelasMapel' => $kelasMapel, 'diskusiId' => $id]);
    }

    /**
     * Membuat Diskusi baru.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createDiskusi(Request $request)
    {
        // Lakukan validasi untuk inputan form
        $request->validate([
            'name' => 'required',
            'content' => 'required',
        ]);

        try {
            // Dekripsi token dan dapatkan KelasMapel
            $token = decrypt($request->kelasId);
            $kelasMapel = KelasMapel::where('mapel_id', $request->mapelId)->where('kelas_id', $token)->first();

            $isHidden = 1;

            if ($request->opened) {
                $isHidden = 0;
            }
            $temp = [
                'kelas_mapel_id' => $kelasMapel['id'],
                'name' => $request->name,
                'content' => $request->content,
                'isHidden' => $isHidden,
            ];

            // Simpan data Diskusi ke database
            Diskusi::create($temp);

            // Commit transaksi database
            DB::commit();

            // Berikan respons sukses jika semuanya berjalan lancar
            return response()->json(['message' => 'Diskusi berhasil dibuat'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error'], 200);
        }
    }

    /**
     * Mengupdate Diskusi.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDiskusi(Request $request)
    {
        // Lakukan validasi untuk inputan form
        $request->validate([
            'name' => 'required',
            'content' => 'required',
        ]);
        // return response()->json(['message' => $request->input()], 200);
        // Dekripsi token hasil dari hidden form lalu dapatkan data KelasMapel
        $diskusiId = decrypt($request->diskusiId);

        try {
            $isHidden = 1;

            if ($request->opened) {
                $isHidden = 0;
            }
            $data = [
                'name' => $request->name,
                'content' => $request->content,
                'isHidden' => $isHidden,
            ];
            // Simpan data Diskusi ke database
            Diskusi::where('id', $diskusiId)->update($data);
            // Commit transaksi database
            DB::commit();

            // Berikan respons sukses jika semuanya berjalan lancar
            return response()->json(['message' => 'Diskusi berhasil dibuat'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error'], 200);
        }
    }

    /**
     * Menghapus Diskusi.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyDiskusi(Request $request)
    {

        // Dapatkan Id Diskusi dari Inputan Form request
        $diskusiId = $request->hapusId;

        // Logika untuk memeriksa apakah pengguna yang sudah login memiliki akses editor
        foreach (Auth()->User()->EditorAccess as $key) {
            if ($key->kelas_mapel_id == $request->kelasMapelId) {
                Diskusi::where('id', $diskusiId)->delete();

                return redirect()->back()->with('success', 'Diskusi Berhasil dihapus');
            }
        }
        abort(404);
    }


    public function redirectBack(Request $request)
    {
        $mapelId = request('amp;mapelId');
        $message = request('amp;message');

        return redirect(route('viewKelasMapel', ['mapel' => $mapelId, 'token' => encrypt($request->kelasId), 'mapel_id' => $mapelId]))->with('success', 'Data Berhasil di ' . $message);
    }
}
