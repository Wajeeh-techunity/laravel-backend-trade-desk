<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\User;
use App\PrivateMessage;
use App\Group;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    public function message(Request $request)
    {

        $user = User::find($request->input('user_id'));
        $username = $user->name;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/public'), $imageName);
            $imageUrl = asset('images/public/'.$imageName);           
        }else{
            $imageUrl = NULL;
        }
        

        // $message = Message::create([
        //     'user_id' => $user->id,
        //     'username' => $username,
        //     'content' => $request->input('message'),
        //     'image' => $imageUrl,
        // ]);

        $message = new Message();       
        $message->user_id = $user->id;
        $message->username = $username;
        $message->content = $request->message;
        $message->image = $imageUrl;
        $message->save();

        try {
            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                [
                    'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                    'useTLS' => true,
                ]
            );
    
            $pusher->trigger('chat', 'test-event', [
            'message' => $message->content,
            'user_id' => $message->user_id,
            'username' => $user->name,
            'image' => $imageUrl,
            ]);

            return response()->json([
                'message' => $message->content,
                'user_id' => $message->user_id,
                'username' => $user->name,
                'image' => $imageUrl,
            ]);

        } catch (\Exception $exception) {
            return response()->json(['status' => 'Pusher connection error', 'error' => $exception->getMessage()], 500);
        }
    }

    public function getChatHistory()
    {
        $chatHistory = Message::orderBy('created_at', 'asc')->get();
        return response()->json($chatHistory);
    }

    public function delete($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['error' => 'Message not found.'], 404);
        }

        $message->delete();

        // Broadcast an event to notify clients about the deleted message
        broadcast(new MessageDeleted($id))->toOthers();

        return response()->json(['message' => 'Message deleted successfully.']);
    }

    public function privateMessage(Request $request)
    {
        $sender = User::find($request->input('sender_id'));
        $receiver = User::find($request->input('receiver_id'));
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/private'), $imageName);
            $imageUrl = asset('images/private/'.$imageName);           
        }else{
            $imageUrl = NULL;
        }

        // $message = PrivateMessage::create([
        //     'sender_id' => $sender->id,
        //     'receiver_id' => $receiver->id,
        //     'sender_name' => $sender->name,
        //     'reciever_name' => $receiver->name,
        //     'message' => $request->input('message'),
        // ]);

        $message = new PrivateMessage();       
        $message->sender_id = $sender->id;
        $message->receiver_id = $receiver->id;
        $message->sender_name = $sender->name;
        $message->reciever_name = $receiver->name;
        $message->message = $request->message;
        $message->image = $imageUrl;
        $message->save();

        try {
            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                [
                    'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                    'useTLS' => true,
                ]
            );

            $channelName = "one-chat";
            $pusher->trigger($channelName, 'one-message-5-6', [
                'message' => $message->message,
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'sender_name' => $sender->name,
                'created_at' => $message->created_at,
                'image' => $imageUrl,
            ]);

            // $pusher->trigger($channelName, 'private-message', [
            //     'message' => $message->message,
            //     'sender_id' => $sender->id,
            //     'receiver_id' => $receiver->id,
            //     'sender_name' => $sender->name,
            //     'created_at' => $message->created_at,
            // ]);

            return response()->json([
                'message' => $message->message,
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'sender_name' => $sender->name,
                'created_at' => $message->created_at,
                'image' => $imageUrl,
            ]);

        } catch (\Exception $exception) {
            return response()->json(['status' => 'Pusher connection error', 'error' => $exception->getMessage()], 500);
        }
    }
    public function allUsers(){
        $chatUsers = User::orderBy('created_at', 'asc')->get();
        return response()->json($chatUsers);
    }

    public function getPrivateChatHistory($recipientId)
    {
        $senderId = request()->query('senderId');

        // Fetch private chat history based on sender_id and recipient_id
        $chatHistory = PrivateMessage::where(function ($query) use ($senderId, $recipientId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $recipientId);
        })->orWhere(function ($query) use ($senderId, $recipientId) {
            $query->where('sender_id', $recipientId)
                ->where('receiver_id', $senderId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($chatHistory);
    }

    public function creategroup(Request $request)
    {    
        $request->validate([
            'groupName' => 'required|string',
            'selectedUserIds' => 'required|array',
        ]);

        $selectedUserIds = $request->input('selectedUserIds');
        $group = new Group([
            'name' => $request->input('groupName'),
            'created_user_id' => $request->input('createdBy'),
        ]);

        $group->save();
        $group->users()->attach($selectedUserIds);

         // Send email to each selected user
        foreach ($selectedUserIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $to = $user->email;
                $subject = 'You have been added to a group';
                $message = 'You have been added to the group: ' . $group->name;
                
                // Construct the email directly within the controller
                Mail::raw($message, function($mail) use ($to, $subject) {
                $mail->to($to)
                    ->subject($subject)
                    ->from('your@example.com', 'Trade Desk'); // Set sender name here
            });
            }
        }

        return response()->json([
            'message' => 'Group created successfully',
            'id' => $group->id,
            'group_name' => $group->name,
            'created_user_id' => $group->created_user_id,            
            'created_at' => $group->created_at
        ]);
    }

    public function addNewUserInGroup(Request $request)
    {
        $request->validate([
            'selectedUserIds' => 'required|array',
            'selectedGroupId' => 'required|integer',
        ]);

        $selectedUserIds = $request->input('selectedUserIds');
        $selectedGroupId = $request->input('selectedGroupId');

        // Find the group by ID
        $group = Group::find($selectedGroupId);

        // Check if the group exists
        if ($group) {
            
            $group->users()->attach($selectedUserIds);

            $allGroupMembers = $group->users()->pluck('name')->toArray();
            $allGroupMembersIds = $group->users()->pluck('user_id')->toArray();

            foreach ($selectedUserIds as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $to = $user->email;
                    $subject = 'You have been added to a group';
                    $message = 'You have been added to the group: ' . $group->name;

                    // Construct the email directly within the controller
                    Mail::raw($message, function($mail) use ($to, $subject) {
                        $mail->to($to)
                            ->subject($subject)
                            ->from('your@example.com', 'Trade Desk'); // Set sender name here
                    });
                }
            }

            return response()->json([
                'message' => 'Users added to the group successfully',
                'group_id' => $group->id,
                'group_name' => $group->name,
                'all_group_members' => $allGroupMembers,
                'all_group_members_Ids' => $allGroupMembersIds,
            ]);

        } else {
            return response()->json([
                'error' => 'Group not found',
            ], 404);
        }
    }

    public function userGroups($id){     
        // Get groups created by the user
        $createdGroups = Group::where('created_user_id', $id)->get();

        // Get groups where the user is a member
        $userGroups = Group::whereHas('users', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();

        // Merge the two collections to remove duplicates
        $allGroups = $createdGroups->merge($userGroups)->unique();

        return response()->json($allGroups);
    }

    public function deleteGroup($groupId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            // Handle the case where the group is not found
            return response()->json(['error' => 'Group not found'], 404);
        }

        // Detach all users from the group
        $group->users()->detach();

        // Delete the group
        $group->delete();

        return response()->json(['message' => 'Group deleted successfully']);
    }

    public function groupDetail($groupId)
    {
          
        $group = Group::find($groupId);
        if ($group) {
            $created_user_id = $group->created_user_id;
            $user = User::find($created_user_id);
            $created_user_name = $user->name;
    
        }
        
        if (!$group) {         
            return response()->json(['error' => 'Group not found'], 404);
        }
      
        $groupUsers = $group->users()->get();
       
        $userNames = $groupUsers->pluck('name');
        $user_id = $groupUsers->pluck('id');

        return response()->json([
            'group' => $group,
            'created_user_name' => $created_user_name,
            'user_names' => $userNames,
            'user_id' => $user_id,
        ]);
        
    }
}
