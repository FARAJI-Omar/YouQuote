<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    public function index()
    {

        $quotes = Quote::get();

        if ($quotes->count() > 0) {
            return QuoteResource::collection($quotes);
        } else {
            return response()->json(['message' => 'No quotes found'], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'author' => 'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandatory',
                'error' => $validator->messages(),
            ], 422);
        }

        $quote = Quote::create([
            'content' => $request->content,
            'author' => $request->author,
        ]);

        return response()->json([
            'message' => 'Quote created successfully!',
            'data' => new QuoteResource($quote)
        ], 200);
    }

    public function show() {}

    public function update() {}

    public function destroy() {}
}
