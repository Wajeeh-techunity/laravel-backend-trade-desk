<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\GroupMessage;
use App\User;
use Pusher\Pusher;

class GroupChatController extends Controller
{
    public function groupMessage(Request $request)
    {
        $user_name = '';

        $message = User::where('id', $request->userId)->first();
        if ($message) {        
              $user_name = $message->name;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/group'), $imageName);
            $imageUrl = asset('images/group/'.$imageName);           
        }

        $message = new GroupMessage();       
        $message->group_id = $request->groupId;
        $message->user_id = $request->userId;
        $message->message = $request->message;
        if($request->hasFile('image')){
            $message->image = $imageUrl;
        }else{
            $imageUrl = NULL;
        }
        
        $message->user_name = $user_name;
        $message->save();

        // Fetch users of the group to notify them

        // Notify users using Pusher
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true,
        ]);

        $pusher->trigger('group-chat', 'group-message', [
            'groupId' => $request->groupId,
            'message' => $request->message,
            'image' => $imageUrl,
            'userId' => $request->userId,
            'user_name' => $user_name,
            'created_at' => $message->created_at,
        ]);

        return response()->json([
            'groupId' => $request->groupId,
            'message' => $request->message,
            'image' => $imageUrl,
            'userId' => $request->userId,
            'user_name' => $user_name,
            'created_at' => $message->created_at,
        ]);
    }

    public function fetchChatHistory($groupId)
    {                  
        $chatHistory = GroupMessage::where('group_id', $groupId)->orderBy('created_at', 'asc')->get();
        return response()->json($chatHistory);        
    }

    public function groupImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/group'), $imageName);
            $imageUrl = asset('images/group/'.$imageName);

            return response()->json(['imageUrl' => $imageUrl], 200);
        } else {
            return response()->json(['error' => 'No image file provided'], 400);
        }
    }
}
