<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\appliedjob;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $chat = new Chat();
        $chat->from_user_id = Auth::user()->id;
        $chat->to_user_id = $request->to_user_id;
        $chat->message = $request->message;
        $chat->save();
        if (Auth::user()->role == 'Candidate') {
            return redirect()->route('candidate.getMessages', $request->to_user_id);
        }
        if (Auth::user()->role == 'Employer') {
            return redirect()->route('employer.getMessages', $request->to_user_id);
        }
        if (Auth::user()->role == 'Admin') {
            return redirect()->route('admin.getMessages', $request->to_user_id);
        }

        // return response()->json([
        //     'message' => 'Message sent successfully',
        //     'chat' => $chat,
        // ]);
    }

    public function getMessages($userId)
    {
        $user = User::where('id', $userId)->first();
        $message = Chat::where(function ($query) use ($userId) {
            $query->where('from_user_id', Auth::id());
            $query->where('to_user_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('from_user_id', $userId);
            $query->where('to_user_id', Auth::id());
        })->get();
        return view('inbox.chat', compact('message', 'user'));
        // return response()->json([
        //     'chats' => $chats,
        // ]);
    }
    public function inbox()
    {
        if (Auth::user()->role == 'Candidate') {
            $user = appliedjob::where('candidate_id', Auth::user()->id)->first();
        }
        if (Auth::user()->role == 'Employer') {
            $user = appliedjob::where('employer_id', Auth::user()->id)->first();
        }

        return view('inbox.chat', compact('user'));
    }
}
