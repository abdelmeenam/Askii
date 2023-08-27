<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Notifications\NewAnswerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index' , 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $question_id = $request->question_id;
        if (!$question_id){
            return response()->json(['status' => 'error', 'message' => 'question_id is required'], 422);
        }

        $answers = Answer::where('question_id' , $question_id)
            ->with('user')
            ->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $answers
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required' , 'string' , 'min:5'],
            'question_id' => ['required' , 'integer' , 'exists:questions,id'],
        ]);

        $user = Auth::guard('sanctum')->user()->id;
        $request->merge(['user_id' => $user]);
        $question = Question::findOrFail($request->question_id);

        // check if the user already answered this question
        if ($question->answers()->where('user_id' , $user)->exists()){
            return response()->json(['error' => 'You already answered this question'] , 422);
        }

        $answer = $question->answers()->create($request->all());
        $question->user->notify(new NewAnswerNotification($question ,Auth::user()));
        return response()->json([
            'status' => 'success',
            'data' => $answer->load('question' ,'user' )
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $answer = Answer::findOrfail($id);
        return response()->json([
            'status' => 'success',
            'data' => $answer->load('question' ,'user' )
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $answerId)
    {
        $request->validate([
            'description' => ['required' , 'string' , 'min:5'],
        ]);

        $answer = Answer::findOrFail($answerId);
        $answer->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $answer->load('question' ,'user' )
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($answerId)
    {
        $answer = Answer::findOrFail($answerId);
        if ($answer->user_id != auth()->user()->id){
            return response()->json(['error' => 'You are not authorized to delete this answer'] , 422);
        }

        $answer->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Answer deleted successfully'
        ], 200);
    }
}
