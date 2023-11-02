<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ConversationMessage;
class Conversation extends Model
{
    protected $table = 'conversations';

    public static function createConversation()
    {

        $senderId    =  auth()->id();
        $s = new Conversation;
        $s->sender_id       =   $senderId;
        $s->save();
        return $s->id;
    }

    public function findSender(){
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function latestMeasure()
    {
        return $this->hasOne(ConversationMessage::class);
    }
    public function messagesview()
    {
        return $this->hasMany(ConversationMessage::class);
    }
}
