<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\ReviewStoreRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;

        // Apply policy-based authorization middleware
        $this->middleware('can:manage,App\Models\Review')->only(['update', 'destroy']);
    }

    /**
     * List reviews of a single product (paginated)
     */
    public function index(Request $request, $product_id)
    {
        $perPage = $request->get('per_page', 10);

        $reviews = $this->reviewService->getPaginatedReviews($product_id, $perPage);

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    /**
     * Store a new review
     */
    public function store(ReviewStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $review = $this->reviewService->createReview($data);

        return response()->json([
            'success' => true,
            'message' => 'Review created successfully',
            'data' => $review
        ], 201);
    }

    /**
     * Show a single review
     */
    public function show($id)
    {
        $review = $this->reviewService->getReviewById($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }

    /**
     * Update an existing review
     */
    public function update(ReviewStoreRequest $request, $id)
    {
        $review = $this->reviewService->getReviewById($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        // Authorization is handled by middleware/policy
        $updatedReview = $this->reviewService->updateReview($review, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully',
            'data' => $updatedReview
        ]);
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        $review = $this->reviewService->getReviewById($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        // Authorization is handled by middleware/policy
        $this->reviewService->deleteReview($review);

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }
}
