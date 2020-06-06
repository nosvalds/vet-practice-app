<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use App\User;

class Home extends Controller
{
    // index
    public function index()
    {
        $hour = Carbon::now()->hour;
        if ($hour < 12) {
            $timeOfDay = "Morning";
        } elseif ($hour < 17) {
            $timeOfDay = "Afternoon";
        } else {
            $timeOfDay = "Evening";
        }

        if (Auth::check()) {
            $user = Auth::user();
            $login = true;
        } else {
            $user = new User; // pass in empty user object so our ternary operators don't break
            $login = false;
        }

        return view("welcome",['page' => 'Home', 'logged_in' => $login, 'user' => $user, 'timeOfDay' => $timeOfDay]);
    }
}
