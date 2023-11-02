<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Conversation;
use App\ConversationMessage;
use Illuminate\Support\Facades\App;
class MessageController extends Controller
{
    public function __construct()
    {
        App::setLocale('en');
    }

    public function index()
    {
        return view('admin.message.index');
    }

    public function getConversationList()
    {
        $conversation = Conversation::orderBy('id','DESC')->get();
        return response()->json([
            'status'=>  200,
            'result' => (string)view('admin.message.ajax.conversationlist', compact('conversation')),
        ]);
    }

    public function getConversation(Request $request)
    {
        $messages   = ConversationMessage::where(['conversation_id'=>$request->id])->get();
        ConversationMessage::viewmessage($request->id);
        return response()->json([
            'status'=>  200,
            'result' => (string)view('admin.message.ajax.conversation', compact('messages')),
        ]);
    }
    public function postMessage(Request $request)
    {
        $data     =   $request->all();
        ConversationMessage::postMessageCreate($data);
        $messages   = ConversationMessage::where(['conversation_id'=>$request->conid])->get();
        return response()->json([
            'status'=>  200,
            'result' => (string)view('admin.message.ajax.conversation', compact('messages')),
        ]);
    }

    public function getMessageNotification()
    {
        $data   =   Conversation::all();
        return response()->json([
            'status'=>  $data,
            'result' => (string)view('admin.master.ajax.messagenotification', compact('data')),
        ]);
    }

    public function conversationBlock(Request $request)
    {
        Conversation::where(['id'=>$request->id])->update(['status' => $request->status]);
        return response()->json([
            'status'=>  200,
            'result' => $request->status,
        ]);
    }
}
