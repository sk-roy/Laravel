<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUnread() 
    {
        try {
            $user = User::find(Auth::id());
            return response()->json(['notifications' => $user->unreadNotifications], 200);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }
    
}
