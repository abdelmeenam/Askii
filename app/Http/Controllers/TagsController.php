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
    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    public function index()
    {
        //Gate::authorize('tags.view');
        //$this->authorize('viewAny' ,Tag::class);

        $tags = Tag::Paginate();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        //Gate::authorize('tags.create');
        //$this->authorize('create' ,Tag::class);

        return view('tags.create' ,['tag' => new Tag()]);
    }

    public function store(CreateTagRequest $request)
    {
        //Gate::authorize('tags.create');
        //$this->authorize('create' ,Tag::class);

        // Mass assignment method
        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        // PRG : Post Redirect Get
        //return redirect()->route('tags.index');
        return redirect()->route('tags.index')->with('success', 'Tag created successfully');
    }

    public function edit($id)
    {
        //Gate::authorize('tags.edit');
        $this->authorize('update' ,Tag::class);
        $tag = Tag::findorFail($id);
        return view('tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, $id)
    {
        //Gate::authorize('tags.edit');
        //$this->authorize('update' ,Tag::class);

        $tag = Tag::findorFail($id);
        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        //return redirect()->route('tags.index');
        return redirect()->route('tags.index')->with('success', 'Tag updated successfully');
    }

    public function destroy($id)
    {
        //Gate::authorize('tags.delete');
        //$this->authorize('delete' ,Tag::class);

        $tag = Tag::findorFail($id);
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully');
    }

}
