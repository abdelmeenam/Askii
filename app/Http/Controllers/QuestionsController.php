<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    /**
     * QuestionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index' , 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$questions = Question::leftjoin('users' , 'questions.user_id' , '=' ,'users.id')->select('questions.*' , 'users.name as user_name')->latest()->paginate(10);
       // $questions = Question::latest()->paginate(10);        //Too much queries  ( $question->user->name )
        // Eager loading
        $questions = Question::with('user' , 'tags')
            ->withCount('answers')
            ->latest()
            ->paginate(5);

        return view('questions.index', [
            'questions' => $questions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ALl tags
        $tags = Tag::all();
        return view('questions.create' , [
            'question' => new Question(),
            'tags' => $tags,
            ]);
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
            'title' => ['required' , 'string' , 'max:255'],
            'description' => ['required' , 'string' ],
            'tags' => ['required' , 'array' , 'exists:tags,id'],
        ]);

        // DB Transaction
        DB::beginTransaction();
        try{
            $question = Question::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
            ]);
            $question->tags()->attach($request->tags);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            throw $e;
        }

        return redirect()->route('questions.index')
            ->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrfail($id);
        $questionsCount = $question->answers->count();
        //$answers = $question->answers()->with('user')->get();
        $answers =Answer::where('question_id' , $id)->with('user')->latest()->get();

        return view('questions.show', [
            'question' => $question,
            'answers' => $answers,
            'questionsCount' => $questionsCount,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);

        // Tags
        $tags = Tag::all();
        $questionTags = $question->tags()->pluck('id')->toArray();
        //dd($tags , $questionTags);

        if ( ! (auth()->user()->id == $question->user_id) ) {
            abort(404);
        }

        return view('questions.edit', [
            'question' => $question,
            'tags' => $tags,
            'questionTags' => $questionTags,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required' , 'string' , 'max:255'],
            'description' => ['required' , 'string' ],
            'status' => ['in:open,closed'],
            'tags' => ['required' , 'array' , 'exists:tags,id'],
        ]);
        $question = Question::findOrFail($id);

        // DB Transaction
        DB::beginTransaction();
        try{
            $question->update($request->all());
            $question->tags()->sync($request->tags);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            throw $e;
        }
        return redirect()->route('questions.index')
            ->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::destroy($id);
        return redirect()->route('questions.index')
            ->with('success', 'Question deleted successfully.');
    }
}
