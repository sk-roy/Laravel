<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Services\ArticleService;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index() 
    {
        return $this->articleService->index();
    }

    public function show($id) 
    {
        return $this->articleService->show($id);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'nullable|string',
        ]);

        return $this->articleService->store($request);
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'nullable|string',
        ]);
        
        return $this->articleService->update($request, $id);
    }

    public function delete($id) 
    {
        return $this->articleService->delete($id);
    }
}
