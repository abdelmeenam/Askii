<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Localization;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    /**
     * QuestionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }


    public function index()
    {
        $searchTerm = trim(request('search'));
        $tag_id = request('tag_id');

        //$questions = Question::leftjoin('users' , 'questions.user_id' , '=' ,'users.id')->select('questions.*' , 'users.name as user_name')->latest()->paginate(10);
        // $questions = Question::latest()->paginate(10);        //Too much queries  ( $question->user->name )
        // Eager loading
        $questions = Question::with(['user', 'tags:id,name'])
            ->withCount('answers')
            ->latest()
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            })
            ->when($tag_id, function ($query, $tag_id) {
                //$query->whereRaw('questions.id IN (SELECT question_id FROM question_tag WHERE tag_id = ?)', [$tag_id]);
                $query->whereHas('tags', function ($query) use ($tag_id) {
                    $query->where('id', $tag_id);
                });
            })
            ->paginate(perPage: 3);


        if (request()->expectsJson()) {
            // If request expects JSON response (for autocomplete search), return search results only
            return $questions->pluck('title', 'id');
        }

        return view('questions.index', [
            'questions' => $questions,
        ]);
    }


    public function create()
    {
        $this->authorize('create', Question::class);
        // ALl tags
        $tags = Tag::all();

        return view('questions.create', [
            'question' => new Question(),
            'tags' => $tags,
        ]);
    }


    public function store(Request $request)
    {
        $this->authorize('create', Question::class);
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tags' => ['required', 'array', 'exists:tags,id'],
        ]);

        //dd($request->tags);

        // DB Transaction
        DB::beginTransaction();
        try {
            $question = Question::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
            ]);

            $question->tags()->attach($request->tags);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

        //return redirect()->route('questions.index')    ->with('success', 'Question created successfully.');
        toastr()->success(message: __('Question created successfully'));
        return redirect()->route('questions.index');
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
        $questionsCount = $question->answers->count();          //->withCount('answers')
        $answers = $question->answers()->with('user')->get();
        //$answers =Answer::where('question_id' , $id)->with('user')->latest()->get();

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
     * @return  \Illuminate\views\view

     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('update', $question);

        //$questionTags = implode(separator: ',', $question->tags()->pluck('name')->toArray());
        $questionTags = $question->tags->pluck('id')->toArray();
        $tags = Tag::all();


        //dd($tags , $questionTags);
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
        $question = Question::findOrFail($id);
        $this->authorize('update', $question);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['in:open,closed'],
            'tags' => ['required', 'array', 'exists:tags,id'],
        ]);

        // DB Transaction
        DB::beginTransaction();
        try {
            $question->update($request->all());
            $question->tags()->sync($request->tags);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        //return redirect()->route('questions.index')       ->with('success', 'Question updated successfully.');
        toastr()->success(message: __('Question updated successfully'));
        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('delete', $question);

        Question::destroy($id);
        // return redirect()->route('questions.index')   ->with('success', 'Question deleted successfully.');
        toastr()->success(message: __('Question deleted successfully'));
        return redirect()->route('questions.index');
    }
}