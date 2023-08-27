<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
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
        $userId = $request->user_id;
        $tags = $request->tags ?  explode(',', $request->tags) :  null;

        $questions = Question::with(['user' , 'tags'])
            ->latest()
            ->when($userId , function($query , $userId){
                $query->where('user_id'  ,'=', $userId);
            })
            ->when($tags , function($query , $tags){
                $query->whereHas('tags' , function($query) use ($tags){
                    $query->whereIn('id' , $tags);
                });
            })
            ->paginate(5);

        return response()->json([
            'status' => 'success',
            'data' => $questions], 200);
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
            'tags.*' => ['required' , 'int' , 'exists:tags,id'],
        ]);

        $user = Auth::guard('sanctum')->user();

        // DB Transaction
        DB::beginTransaction();
        try{
            $question = Question::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $user->id
            ]);

            $question->tags()->attach($request->tags);
            DB::commit();
        }
        catch (\Throwable $e){
            DB::rollback();
            throw $e;
        }

        // return response
        return response()->json([
            'status' => 'success',
            'data' => $question
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::with(['user' , 'tags'])->find($id);
        if (!$question){
            return response()->json([
                'status' => 'error',
                'message' => 'Question not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $question->load('tags' ,'user' )
        ], 200);
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
            'title' => [ 'sometimes' ,  'required' , 'string' , 'max:255'],
            'description' => [ 'sometimes', 'required' , 'string' ],
            'status' => ['in:open,closed'],
            'tags' => [ 'sometimes' ,  'required'  , function($attribute, $value, $fail) {
                $tagsId = explode(',', $value);
                $exists = Tag::WhereIn('id', $tagsId)->pluck('id')->toArray();
                if(count($exists) != count($tagsId)){
                    $fail('The '.$attribute.' is invalid.');
                }
            }],
        ]);
        $question = Question::findOrFail($id);

        // DB Transaction
        DB::beginTransaction();
        try{
            $question->update($request->all());
            $tags = explode(',', $request->tags);
            $question->tags()->sync($tags);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            throw $e;
        }

        // return response
        return response()->json([
            'status' => 'success',
            'message' => 'Question updated successfully',
            'data' => $question
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // delete question by id
        Question::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Question deleted successfully',
        ], 200);
    }
}
