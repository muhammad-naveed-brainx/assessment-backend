<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreFeedbackRequest;
use App\Library\ResponseMessages;
use App\Models\Comment;
use App\Models\Feedback;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Feedback $feedback)
    {
        try {
            $user = auth()->user();
            $comment = new Comment($request->validated());
            $comment->user_id = $user->id;
            $comment->feedback_id = $feedback->id;
            $comment->save();
            $comment->user_name = $user->name;
            return $this->successResponse($comment, ResponseMessages::CREATE);
        }
        catch (\Exception $e) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
