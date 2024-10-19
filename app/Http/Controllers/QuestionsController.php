<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Question;
use App\Models\QuestionView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class QuestionsController extends Controller
{
    /**
     * QuestionsController constructor.
     */
    public function __construct()
    {
        $this->middleware(middleware: ['auth', 'verified'])->except(['index', 'show', 'fetchQuestionSearchResults']);
    }


    public function index()
    {
        $tag_id = request('tag_id');
        /*
        //$questions = Question::leftjoin('users' , 'questions.user_id' , '=' ,'users.id')->select('questions.*' , 'users.name as user_name')->latest()->paginate(10);
        //$questions = Question::latest()->paginate(10);        //Too much queries  ( $question->user->name )
                   ->when($tag_id, function ($query, $tag_id) {
                //$query->whereRaw('questions.id IN (SELECT question_id FROM question_tag WHERE tag_id = ?)', [$tag_id]);
                $query->whereHas('tags', function ($query) use ($tag_id) {
                    $query->where('id', $tag_id);
                });
            })
                       ->when($searchTerm, function ($query, $searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            })
            */

        $questions = Question::with(['user', 'tags:id,name'])
            ->withCount(['answers', 'views'])
            ->latest()
            ->paginate(perPage: 5);

        return view('questions.index', [
            'questions' => $questions,
        ]);
    }

    public function fetchQuestionSearchResults(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($request->expectsJson()) {
            // Using Algolia or Laravel Scout to perform the search
            $questions = Question::search($searchTerm)->get();
            $results = $questions->pluck('title', 'id');

            return response()->json($results);
        }
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Question $question)
    {
        $answers = $question->answers()->with(relations: 'user')->get();
        $userId = auth()->id(); // Get the authenticated user's ID

        $alreadyViewed = QuestionView::where('question_id', $question->id)
            ->where('user_id', $userId)
            ->exists();


        if (!$alreadyViewed && auth()->check()) {
            QuestionView::create([
                'question_id' => $question->id,
                'user_id' => $userId,
            ]);
        }

        return view('questions.show', [
            'question' => $question,
            'answers' => $answers,
            'questionsCount' =>    $answers->count(),
            'viewsCount' => $question->views()->count(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View

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
