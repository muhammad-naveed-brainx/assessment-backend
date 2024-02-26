<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use App\Http\Requests\StoreFeedbackRequest;
use App\Library\ResponseMessages;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $feedback= $this->getPaginatedData($request);
            $feedback->transform(function ($item) {
                $item['user_name'] = $item->user->name;
                unset($item['user']);
                return $item;
            });
            return $this->successResponse($feedback, ResponseMessages::CREATE);
        } catch (\Exception $e) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedbackRequest $request)
    {
        try {
            $user = auth()->user();
            $feedback = new Feedback($request->validated());
            $feedback->user_id = $user->id;
            $feedback->save();
            return $this->successResponse($feedback, ResponseMessages::CREATE);
        }
        catch (\Exception $e) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $feedback = Feedback::with(['user','comments.user'])->findOrFail($id);
            $feedback->user_name = $feedback->user->name;
            $comments = $feedback->comments;
            unset($feedback['comments']);
            unset($feedback['user']);
            $comments->transform(function ($item) {
                $item['user_name'] = $item->user->name;
                unset($item['user']);
                return $item;
            });
            $data = [
                'feedback' => $feedback,
                'comments' => $comments
            ];

            return $this->successResponse($data, ResponseMessages::FOUND);
        }
        catch (\Exception $e) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function getPaginatedData($request)
    {
        $page = $request->get('page');
        $perPage = $request->get('perPage');
        if (isset($page) && isset($perPage)) {
            return Feedback::with('user:id,name')->paginate($perPage);
        }
        return Feedback::with('user:id,name')->latest()->get();
    }
}
