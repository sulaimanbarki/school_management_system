<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class MainController extends Controller
{
	public function Logout()
	{
		Auth::logout();
		return Redirect()->route('login');
	}
	public function UserProfile()
	{
		$UserID = Auth::user()->id;

		$userData = User::find($UserID);
		// echo $userData;
		return view('user.profile.Userprofile', compact('userData'));
	}
	public function UserProfileEdit()
	{
		$UserID = Auth::user()->id;

		$userData = User::find($UserID);
		// echo $userData;
		return view('user.profile.Editprofile', compact('userData'));
	}
	//
}
