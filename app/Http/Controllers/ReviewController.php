<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'امتیاز ستاره‌ای الزامی است.',
            'rating.between' => 'امتیاز باید بین ۱ تا ۵ باشد.',
            'comment.max' => 'متن نظر نباید بیشتر از ۱۰۰۰ کاراکتر باشد.',
        ]);

        $review = Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => auth()->id()],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        if ($review->wasRecentlyCreated) {
            $message = 'نظر و امتیاز شما با موفقیت ثبت شد.';
        } else {
            $message = 'نظر و امتیاز شما با موفقیت به‌روزرسانی شد.';
        }

        return redirect()->route('product.show', $product)->with('success', $message);
    }
}
