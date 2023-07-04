<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('auth')->except('index');
    }

    public function index()
    {
        $tags = Tag::all();

        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create' ,['tag' => new Tag()]);
    }

    public function store(CreateTagRequest $request)
    {
        // Mass assignment method
        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        // PRG : Post Redirect Get
        return redirect()->route('tags.index');
    }

    public function edit($id)
    {
        $tag = Tag::findorFail($id);
        return view('tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, $id)
    {
        $tag = Tag::findorFail($id);
        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('tags.index');
    }

    public function destroy($id)
    {
        $tag = Tag::findorFail($id);
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully');
    }

}
