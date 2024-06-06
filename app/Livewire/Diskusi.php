<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;

class Diskusi extends Component
{
    public $diskusiId;
    public $pesan;
    public $komentars;

    protected $rules = [
        'pesan' => 'required|string|max:500',
    ];

    public function mount($diskusiId)
    {
        $this->diskusiId = $diskusiId;
        $this->loadKomentars();
    }

    public function loadKomentars()
    {
        $this->komentars = Komentar::where('diskusi_id', $this->diskusiId)->oldest()->get();
    }
    
    public function submit()
    {
        $this->validate();

        Komentar::create([
            'diskusi_id' => $this->diskusiId,
            'user_id' => Auth::id(),
            'pesan' => $this->pesan,
        ]);

        $this->pesan = '';
        $this->loadKomentars();
    }

    public function render()
    {
        return view('livewire.diskusi');
    }
}
