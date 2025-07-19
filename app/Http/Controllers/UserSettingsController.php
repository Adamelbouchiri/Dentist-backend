<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSettingsController extends Controller
{
    public function changeAvatar(Request $request) {

        $request->validate([
            'file' => 'required|image|mimes:png|max:5120',
        ]);

        $file = $request->file('file');

        $fileHash = hash('sha256', file_get_contents($file));
        $extension = $file->getClientOriginalExtension();
        $fileName = $fileHash . '.' . $extension;

        $targetPath = storage_path('app/public/images/' . $fileName);

        if (!file_exists($targetPath)) {
            $file->move(storage_path('app/public/images'), $fileName);
        }

        $user = $request->user();
        $user->avatar = $fileName;
        $user->save();

        return response()->json([
            'message' => 'Avatar changed successfully',
            'user' => $user
        ]);
    }

    public function changeName(Request $request) {

        $request->validate([
        'userName' => 'required|string|max:255',
        ]);

        $user = $request->user();
        $user->name = $request->userName;
        $user->save();

        return response()->json([
            'message' => 'Name changed successfully',
            'user' => $user
        ]);
    }

    public function changePassword(Request $request) {
        $request->validate([
        'current_password' => 'required',
        'password' => 'required|confirmed|min:8',
        ]);

        $user = $request->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        // Update to new password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password changed successfully',
            'user' => $user
        ]);
    }
}
