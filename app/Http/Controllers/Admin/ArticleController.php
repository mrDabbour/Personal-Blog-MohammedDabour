<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\EditArticleRequest;
use App\Http\Requests\Admin\CreateArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->paginate(5);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.articles.create', compact('categories'));
    }

    
    public function store(CreateArticleRequest $request)
    {
        $tags = explode(',', $request->tags);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $filename, 'public');
        }
        
        $article = auth()->user()->articles()->create([
            'title' => $request->title,
            'image' => $filename ?? null,
            'article' => $request->article,
            'category_id' => $request->category
        ]);

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        }

        return redirect()->route('admin.articles.index');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = $article->tags->implode('name', ', ');

        return view('admin.articles.edit', compact('article', 'tags', 'categories'));
    }

    public function update(EditArticleRequest $request, Article $article)
    {
        $tags = explode(',', $request->tags);

        if ($request->hasFile('image')) {
            Storage::delete('public/uploads/' . $article->image);
            
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $filename, 'public');
        }

        $article->update([
            'title' => $request->title,
            'image' => $filename ?? $article->image,
            'article' => $request->article,
            'category_id' => $request->category
        ]);

        $newTags = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            array_push($newTags, $tag->id);
        }
        $article->tags()->sync($newTags);

        return redirect()->route('admin.articles.index');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::delete('public/uploads/' . $article->image);
        }

        $article->tags()->detach();
        $article->delete();

        return redirect()->route('admin.articles.index');
    }
}
