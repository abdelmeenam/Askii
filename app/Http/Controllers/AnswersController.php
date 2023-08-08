<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    //store
    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required' , 'string' , 'min:5'],
            'question_id' => ['required' , 'integer' , 'exists:questions,id'],
        ]);
        $request->merge(['user_id' => auth()->user()->id ]);
        $question = Question::findOrFail($request->question_id);

        // check if the user already answered this question
        if ($question->answers()->where('user_id' , auth()->user()->id)->exists()){
            return redirect()->route('questions.show' , $question->id)->with('error' , 'You already answered this question');
        }

        $answer = $question->answers()->create($request->all());

        return redirect()->route('questions.show' , $question->id)->with('success' , 'Answer created successfully');
    }

    // destroy
    public function destroy($answerId)
    {
        $answer = Answer::findOrFail($answerId);

        if ($answer->user_id != auth()->user()->id){
            return redirect()->route('questions.show' , $questionId)->with('error' , 'You are not authorized to delete this answer');
        }

        $answer->delete();
        return redirect()->route('questions.show' , $answer->question_id)->with('success' , 'Answer deleted successfully');
    }


    // edit answer of a question
    public function edit($answerId)
    {
        $answer = Answer::findOrFail($answerId);

        if ($answer->user_id != auth()->user()->id){
            return redirect()->route('questions.show' , $questionId)->with('error' , 'You are not authorized to edit this answer');
        }

        return view('answers.edit' , compact('answer'));
    }


    // update answer page
    public function update($answerId , Request $request){

        $request->validate([
            'description' => ['required' , 'string' , 'min:5'],
        ]);

        $answer = Answer::findOrFail($answerId);

        $answer->update($request->all());
        return redirect()->route('questions.show' , $answer->question_id)->with('success' , 'Answer updated successfully');
    }

    /**
     * @param $question_id
     * @param $answer_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bestAnswer(Request $request , $answerId){

        $answer = Answer::findOrFail($answerId);
        $question= $answer->question;

        if ( Auth::id() != $question->user_id) {
            return redirect()->route('questions.show' , $answer->question_id)
                ->with('error', 'You are not authorized to mark any answer as best.');
        };

        // update all answers to 0 (not best answer)
        $question->answers()->update([
            'best_answer' => 0
        ]);

        // update the answer to 1 (best answer)
        $answer->forceFill([
            'best_answer' => 1
        ])->save();

        return redirect()->route('questions.show' , $answer->question_id)
            ->with('success', 'Best answer updated successfully.');
    }
}
