<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function index()
    {
        Gate::authorize('tags.view');
        $tags = Tag::Paginate();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        Gate::authorize('tags.create');
        return view('tags.create' ,['tag' => new Tag()]);
    }

    public function store(CreateTagRequest $request)
    {
        Gate::authorize('tags.create');
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
        Gate::authorize('tags.edit');
        $tag = Tag::findorFail($id);
        return view('tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, $id)
    {
        Gate::authorize('tags.edit');
        // Mass assignment method
        $tag = Tag::findorFail($id);
        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('tags.index');
    }

    public function destroy($id)
    {
        Gate::authorize('tags.delete');
        $tag = Tag::findorFail($id);
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully');
    }

}
