<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
   public function index()
{
    $messages = Message::latest()->get();
    return view('auth.message', compact('messages'));
}

public function edit($id)
{
    $message = Message::findOrFail($id);
    return view('auth.message_edit', compact('messages'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        Message::findOrFail($id)->update($request->all());

        return redirect()->route('messages.index')
            ->with('success', 'Message updated successfully');
    }

    public function destroy($id)
    {
        Message::findOrFail($id)->delete();

        return redirect()->route('messages.index')
            ->with('success', 'Message deleted successfully');
    }
}
