<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;
use Magnus\PrivateMessage;
use Magnus\Conversation;
use Magnus\User;
use Magnus\Http\Requests;

class ConversationController extends Controller
{
    public function index() {}

    public function create(Request $request) {}

    public function store(Request $request) {}

    public function show(Request $request, Conversation $conversation) {}

    public function destroy(Request $request, Conversation $conversation) {

    }

    public function addMessage(Request $request, Conversation $conversation) {
        $message = new PrivateMessage($request->all());
        $conversation->messages()->save($message);

        return redirect()->route('conversation.show', [$conversation->id])->with('success', 'Reply posted!');
    }

    public function editMessage(Request $request, Conversation $conversation, PrivateMessage $privateMessage) {}

    public function updateMessage(Request $request, Conversation $conversation, PrivateMessage $privateMessage) {}

    public function removeMessage(Request $request, Conversation $conversation, PrivateMessage $privateMessage) {}

    public function addUser(Request $request, Conversation $conversation) {
        $userNames = explode(',', preg_replace('/\s+/', '', $request->input('users')));

        foreach($userNames as $name) {
            $user = User::where('username', $name)->first();
            if(!$user) {
                continue;
            } else {
                $conversation->addUser($user);
            }
        }
    }

    public function removeUser(Request $request, Conversation $conversation) {}
}
