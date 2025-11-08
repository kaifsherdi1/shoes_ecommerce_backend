<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    public function getPaginatedReviews($productId, $perPage = 10)
    {
        return Review::with('user:id,name')
            ->where('product_id', $productId)
            ->latest()
            ->paginate($perPage);
    }

    public function createReview(array $data)
    {
        return Review::create($data);
    }

    public function getReviewById($id)
    {
        return Review::with('user:id,name')->find($id);
    }

    public function updateReview(Review $review, array $data)
    {
        $review->update($data);
        return $review;
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
    }
}
