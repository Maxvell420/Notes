<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\House;
use App\Models\User;
use App\Services\ChatService;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService){
    }

    public function show(House $house,Chat $chat = null)
    {
        $user = Auth::user();
        if (!isset($chat)){
            $chat = $this->chatService->firstOrCreateChat($house);
        }
        $this->chatService->messagesCheck($chat);
        if ($this->chatService->messagesCheck($chat)){
            $this->chatService->MarkAsReaded($chat);
        }
        $service = new DashboardService();
        $watchlist = $service->getFavouriteHouses(Auth::user());
        $secondUser = $chat->getChatWith($house);
        $title = "Час с пользователем:{$secondUser->name}";
        $house->processExternalData();

        return view('chat.show',compact(['chat','house','watchlist','user','title','secondUser']));
    }
    public function messageCreate(Request $request, Chat $chat)
    {
        $this->chatService->messageCreate($request, $chat);
        return redirect()->back();
    }
}
