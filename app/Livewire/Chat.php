<?php
namespace App\Livewire;


use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $messages;
    public $messageText = '';
    public $selectedUser;
    public $selectedUserId;
    public $unreadMessagesCount = [];

    public function mount()
    {
        $this->selectedUserId = User::where('id', '!=', Auth::id())->first()->id;
        $this->loadMessages();
        $this->loadUnreadMessagesCount();
    }

    public function loadMessages()
    {
        $this->messages = Message::where(function($query) {
            $query->where('from_user_id', Auth::id())
                  ->where('to_user_id', $this->selectedUserId);
        })->orWhere(function($query) {
            $query->where('from_user_id', $this->selectedUserId)
                  ->where('to_user_id', Auth::id());
        })->with('fromUser', 'toUser')->get();
    }

    public function loadUnreadMessagesCount()
    {
        $this->unreadMessagesCount = Message::where('to_user_id', Auth::id())
                                            ->where('is_read', false)
                                            ->groupBy('from_user_id')
                                            ->selectRaw('from_user_id, COUNT(*) as count')
                                            ->pluck('count', 'from_user_id')
                                            ->toArray();
    }

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->loadMessages();
        Message::where('from_user_id', $userId)
               ->where('to_user_id', Auth::id())
               ->update(['is_read' => true]);
        $this->loadUnreadMessagesCount();
    }

    public function sendMessage()
    {
        if ($this->messageText != '') {
            Message::create([
                'from_user_id' => Auth::id(),
                'to_user_id' => $this->selectedUserId,
                'message' => $this->messageText,
                'is_read' => false,
            ]);

            $this->loadMessages();
            $this->messageText = '';
        }
    }

    public function render()
    {
        return view('livewire.chat', [
            'users' => User::where('id', '!=', Auth::id())->get(),
        ]);
    }
}
