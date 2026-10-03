<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function publicIndex()
    {
        $articles = Article::published()->with('category')->latest('published_at')->paginate(9);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }
        $article->load('category');
        $related = Article::published()->where('id', '!=', $article->id)->latest('published_at')->limit(4)->get();

        return view('articles.show', compact('article', 'related'));
    }

    public function index()
    {
        $articles = Article::with('category')->latest()->paginate(10);
        $draftsCount = Article::where('is_published', false)->count();

        return view('admin.articles.index', compact('articles', 'draftsCount'));
    }

    public function drafts()
    {
        $articles = Article::with('category')->where('is_published', false)->latest()->paginate(10);

        return view('admin.articles.drafts', compact('articles'));
    }

    public function categories()
    {
        $categories = ArticleCategory::withCount('articles')->latest()->paginate(10);

        return view('admin.articles.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:article_categories,name',
        ]);

        ArticleCategory::create($validated);

        return redirect()->route('admin.articles.categories')->with('success', 'دسته‌بندی مقاله با موفقیت ایجاد شد');
    }

    public function updateCategory(Request $request, ArticleCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:article_categories,name,'.$category->id,
        ]);

        $category->update($validated);

        return redirect()->route('admin.articles.categories')->with('success', 'دسته‌بندی مقاله با موفقیت ویرایش شد');
    }

    public function destroyCategory(ArticleCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.articles.categories')->with('success', 'دسته‌بندی مقاله با موفقیت حذف شد');
    }

    public function create()
    {
        $categories = ArticleCategory::all();

        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'مقاله با موفقیت ایجاد شد');
    }

    public function edit(Article $article)
    {
        $categories = ArticleCategory::all();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $this->validated($request, $article->id);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($article->image && \Storage::disk('public')->exists($article->image)) {
                \Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'مقاله با موفقیت ویرایش شد');
    }

    public function destroy(Article $article)
    {
        if ($article->image && \Storage::disk('public')->exists($article->image)) {
            \Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'مقاله با موفقیت حذف شد');
    }

    private function validated(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'title' => 'required|string|max:255|unique:articles,title'.($ignoreId ? ','.$ignoreId : ''),
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'article_category_id' => 'nullable|exists:article_categories,id',
        ]);
    }
}
