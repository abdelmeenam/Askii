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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::count();
        $questions = Question::count();
        $answers = Answer::count();
        $sessions = DB::table('sessions')->count();

//        $agent = new Agent();
//        $agent->setUserAgent(request()->header('User-Agent'));
//        $browser = $agent->browser();
//        $platform = $agent->platform();

        return view('dashboard', compact('users', 'questions', 'answers' , 'sessions'));
    }

    public function getChartData()
    {
        // Get question date and count
        $questions = Question::select([
            DB::raw('date(created_at) as date'),
            DB::raw('COUNT(*) as count')
        ])
            ->groupBy('date')
            ->get();

        // Get answer date and count
        $answers = Answer::select([
            DB::raw('date(created_at) as date'),
            DB::raw('COUNT(*) as count')
        ])
            ->groupBy('date')
            ->get();

        $labels =[];
        $set1 =$set2 =[];
        $start = Carbon::now()->subDays(28);
        $end = Carbon::now();
        $date = clone $start;
        while($date->lessThanOrEqualTo($end)){
            $labels[] = $date->format('Y-m-d');
            $q = $questions->where('date', $date->format('Y-m-d'))->first();
            $a = $answers->where('date', $date->format('Y-m-d'))->first();
            $set1[] = $q ? $q->count : 0;
            $set2[] = $a ? $a->count : 0;
            $date->addDay();
        }

        return[
            'labels' => $labels,
            'questions' => $set1,
            'answers' => $set2
        ];
    }

    public function getTagChartData()
    {
        $tags = Tag::withCount('questions')->get();
        $dataset = $labels = [];
        foreach ($tags as $tag) {
            $labels[] = $tag->name;
            $dataset[] = $tag->questions_count;
        }
        return [
            'labels' => $labels,
            'dataset' => $dataset,
        ];
    }


}
