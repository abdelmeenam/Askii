<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $questions = Question::count();
        $answers = Answer::count();
        //$sessions = DB::table('sessions')->count();

        //$agent = new Agent();
        //$agent->setUserAgent(DB::table('sessions')->first()->user_agent);
        //echo $agent->platform();

        return view('dashboard', compact('users', 'questions', 'answers'));
    }
}
