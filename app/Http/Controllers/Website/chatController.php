<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Conversation;
use App\ConversationMessage;

class chatController extends Controller
{
    public function getConversationChat()
    {
        if (!auth()->check())
        {
            return response()->json([
                'status'=>  200,
                'result' => (string)view('ajaxmessage'),
            ]);
        }
        $conversation = Conversation::where('sender_id',auth()->id())->first();
        if ($conversation)
        {
            $messages   = ConversationMessage::where(['conversation_id'=>$conversation->id])->get();
            return response()->json([
                'status'=>  $conversation->status,
                'result' => (string)view('ajaxmessage', compact('messages')),
            ]);
        }else{
            return response()->json([
                'status'=>  $conversation->status,
                'result' => (string)view('ajaxmessage', compact('conversation')),
            ]);
        }
    }

    public function postConversationChat(Request $request)
    {
        $data     =   $request->all();
        $conversation = Conversation::where('sender_id',auth()->id())->first();

        if ($conversation)
        {
            $conversation = Conversation::where('sender_id',auth()->id())->first();
            $result = ConversationMessage::postMessageCreateUser($data,$conversation->id);
            $messages   = ConversationMessage::where(['conversation_id'=>$conversation->id])->get();
            return response()->json([
                'status'=>  $conversation->status,
                'result' => (string)view('ajaxmessage', compact('messages')),
            ]);
        }else{
            $convId     =   Conversation::createConversation();

            $result = ConversationMessage::postMessageCreateUser($data,$convId);
            $conversation = Conversation::where('sender_id',auth()->id())->first();
            $messages   = ConversationMessage::where(['conversation_id'=>$conversation->id])->get();
            return response()->json([
                'status'=>  $conversation->status,
                'result' => (string)view('ajaxmessage', compact('messages')),
            ]);
        }

    }
}
