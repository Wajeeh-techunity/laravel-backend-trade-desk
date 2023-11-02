<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversationMessage extends Model
{

    protected $table = 'messages';

    public static function  postMessageCreate(array $data)
    {
        $senderId    =  auth()->id();
        $s = new ConversationMessage;
        $s->sender_id       =   $senderId;
        $s->receiver_id     =   $data['recId'];
        $s->message         =   $data['text'];
        $s->conversation_id =   $data['conid'];
        $s->save();
        return $s->id;
    }

    public static function  postMessageCreateUser(array $data,$convId)
    {
        $senderId    =  auth()->id();
        $s = new ConversationMessage;
        $s->sender_id       =   $senderId;
        $s->receiver_id     =   3;
        $s->message         =   $data['text'];
        $s->conversation_id =   $convId;
        $s->save();
        return $s->id;
    }

    public static function viewmessage($conId){
        ConversationMessage::where(['conversation_id'=>$conId, 'status' => 0])->update(['status' => 1]);

    }

    public function findSender(){
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function findReceiver(){
        return $this->belongsTo('App\User', 'receiver_id');
    }
}
