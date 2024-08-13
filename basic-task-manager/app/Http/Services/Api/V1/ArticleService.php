<?php

namespace App\Http\Services\Api\V1;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleService 
{
    public function index() 
    {
        return Article::all();
    }

    public function show($id) 
    {
        return Article::findOrFail($id);
    }

    public function store(Request $request) 
    {
        $article = Article::create($request->all());
        return response()->json($article, 201);
    }

    public function update(Request $request, $id) 
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());
        return response()->json($article, 200);
    }

    public function delete($id) 
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json($article, 204);
    }

}
