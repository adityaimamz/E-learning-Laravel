<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    // Menampilkan halaman daftar survei untuk admin
    public function viewSurvey()
    {
        $roles = DashboardController::getRolesName();

        $surveys = Survey::with('user', 'kelas')->paginate(15);
        return view('menu.admin.controlSurvey.viewSurvey', ['title' => 'Data Survey', 'surveys' => $surveys, 'roles' => $roles]);
    }

    // Menampilkan halaman tambah survei untuk admin
    public function viewTambahSurvey()
    {
        $roles = DashboardController::getRolesName();
        $users = User::where('roles_id', 2)->get(); // Mengambil semua guru
        $classes = Kelas::all();
        return view('menu.admin.controlSurvey.viewTambahSurvey', ['title' => 'Tambah Survey', 'users' => $users, 'classes' => $classes, 'roles' => $roles]);
    }

    public function viewUpdateSurvey($id)
    {
        $roles = DashboardController::getRolesName();
        $survey = Survey::with('user', 'kelas')->findOrFail($id);
        $users = User::where('roles_id', 2)->get(); // Mengambil semua guru
        $classes = Kelas::all();

        return view('menu.admin.controlSurvey.viewUpdateSurvey', ['title' => 'Update Survey', 'survey' => $survey, 'users' => $users, 'classes' => $classes, 'roles' => $roles]);
    }

    // Menyimpan survei baru
    public function tambahSurvey(Request $request)
    {
        $validator = Validator::make($request->all(), [ // Membuat validasi data pendaftaran
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
            'status' => 'Belum',
        ];

        Survey::create($data);

        return redirect()->route('viewSurvey')->with('success', 'Survey berhasil ditambahkan!');
    }

    public function updateSurvey(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $survey = Survey::findOrFail($request->id);
        $survey->update([
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
            'status' => $survey->status, // Biarkan status tetap sama
        ]);

        return redirect()->route('viewSurvey')->with('success', 'Survey berhasil diperbarui!');
    }

    public function viewListSurvey($surveyId)
    {
        $roles = DashboardController::getRolesName();
        $survey = Survey::with('user', 'kelas')->findOrFail($surveyId);
        $responses = SurveyResponses::where('survey_id', $surveyId)->with('user')->get();

        // Mengelompokkan respon berdasarkan user_id untuk memastikan setiap siswa hanya muncul satu kali
        $groupedResponses = $responses->groupBy('user_id');

        return view('menu.admin.controlSurvey.viewListSurvey', [
            'title' => 'List Responden Survey',
            'survey' => $survey,
            'responses' => $groupedResponses,
            'roles' => $roles,
        ]);
    }

    public function viewDetailSurvey($surveyId, $userId)
    {
        $roles = DashboardController::getRolesName();
        $survey = Survey::with('user', 'kelas')->findOrFail($surveyId);
        $responses = SurveyResponses::where('survey_id', $surveyId)
            ->where('user_id', $userId)
            ->with('question')
            ->get();
        $student = User::findOrFail($userId);

        return view('menu.admin.controlSurvey.viewDetailSurvey', [
            'title' => 'Detail Survey Siswa',
            'survey' => $survey,
            'responses' => $responses,
            'student' => $student,
            'roles' => $roles,
        ]);
    }

    public function viewSurveyMurid()
    {
        $roles = DashboardController::getRolesName();
        $assignedKelas = DashboardController::getAssignedClass();
        $profile = User::findOrFail(Auth()->User()->id);
        $kelas = Kelas::where('id', $profile->kelas_id)->first();

        $surveys = Survey::with('user', 'kelas')->paginate(15);
        return view('menu.siswa.survey.viewSurvey', ['title' => 'Data Survey', 'assignedKelas' => $assignedKelas, 'surveys' => $surveys, 'roles' => $roles, 'profile' => $profile, 'kelas' => $kelas]);
    }

    // Menampilkan halaman survei untuk murid
    public function viewSurveyStart()
    {
        $user = Auth::user();
        $survey = Survey::where('kelas_id', $user->kelas_id)->first();

        $roles = DashboardController::getRolesName();
        $assignedKelas = DashboardController::getAssignedClass();
        $profile = User::findOrFail(Auth()->User()->id);
        $kelas = Kelas::where('id', $profile->kelas_id)->first();
        $questions = SurveyQuestion::all();
        return view('menu.siswa.survey.survey', ['title' => 'Survey', 'survey' => $survey, 'questions' => $questions, 'roles' => $roles, 'profile' => $profile, 'assignedKelas' => $assignedKelas, 'kelas' => $kelas]);
    }

    // Menyimpan respons survei murid
    public function submitSurveyMurid(Request $request)
    {
        $user = Auth::user();
        $survey = Survey::where('kelas_id', $user->kelas_id)->first();

        foreach ($request->responses as $question_id => $response) {
            SurveyResponses::create([
                'survey_id' => $survey->id,
                'user_id' => $user->id,
                'question_id' => $question_id,
                'response' => $response,
            ]);
        }

        Survey::where('id', $survey->id)->update(['status' => 'selesai']);

        return redirect()->route('viewSurveyMurid')->with('success', 'Survey berhasil dikirim!');
    }

    public function searchSurvey(Request $request)
    {
        $search = $request->input('search');

        $surveys = Survey::where('guru', 'like', '%' . $query . '%')
            ->orWhere('kelas', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%')
            ->paginate(10);

        return view('menu.admin.controlSurvey.viewSurvey', compact('surveys'))->render();
    }

    public function destroySurvey(Request $request)
    {
        $surveyId = $request->input('idHapus');
        $survey = Survey::findOrFail($surveyId);

        // Hapus semua respons survei terkait
        SurveyResponses::where('survey_id', $surveyId)->delete();

        // Hapus survei
        $survey->delete();

        return redirect()->route('viewSurvey')->with('delete-success', 'Survey berhasil dihapus!');
    }

    // Menampilkan halaman tambah pertanyaan survei untuk admin
    public function viewTambahSurveyQuestion()
    {
        $roles = DashboardController::getRolesName();
        return view('menu.admin.controlSurvey.viewTambahSurveyQuestion', ['title' => 'Tambah Pertanyaan Survey', 'roles' => $roles]);
    }

// Menyimpan pertanyaan survei baru
    public function tambahSurveyQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        SurveyQuestion::create([
            'question' => $request->question,
        ]);

        return redirect()->route('viewSurveyQuestions')->with('success', 'Pertanyaan Survey berhasil ditambahkan!');
    }

// Menampilkan halaman daftar pertanyaan survei untuk admin
    public function viewSurveyQuestions()
    {
        $roles = DashboardController::getRolesName();
        $questions = SurveyQuestion::paginate(15);
        return view('menu.admin.controlSurvey.viewSurveyQuestions', ['title' => 'Data Pertanyaan Survey', 'questions' => $questions, 'roles' => $roles]);
    }

    public function destroySurveyQuestion(Request $request)
    {
        $questionId = $request->input('idHapus');
        $question = SurveyQuestion::findOrFail($questionId);

        // Hapus pertanyaan
        $question->delete();

        return redirect()->route('viewSurveyQuestions')->with('delete-success', 'Pertanyaan berhasil dihapus!');
    }

    public function viewUpdateSurveyQuestion($id)
    {
        $roles = DashboardController::getRolesName();
        $question = SurveyQuestion::findOrFail($id);
        return view('menu.admin.controlSurvey.viewUpdateSurveyQuestion', ['title' => 'Update Pertanyaan Survey', 'question' => $question, 'roles' => $roles]);
    }
    public function updateSurveyQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $question = SurveyQuestion::findOrFail($request->id);
        $question->update([
            'question' => $request->question,
        ]);

        return redirect()->route('viewSurveyQuestions')->with('success', 'Pertanyaan berhasil diperbarui!');
    }

}
