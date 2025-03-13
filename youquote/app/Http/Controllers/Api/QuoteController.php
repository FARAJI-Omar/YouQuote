<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    public function index()         //show all quotes
    {
        $quotes = Quote::get();

        if ($quotes->count() > 0) {
            return QuoteResource::collection($quotes);
        } else {
            return response()->json(['message' => 'No quotes found'], 200);
        }
    }

    public function store(Request $request)     //create new quote
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

    public function show(Quote $quote)      //show single quote
    {
        return new QuoteResource($quote);
    }

    public function update(Request $request, Quote $quote)      //update single quote
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

        $quote->update([
            'content' => $request->content,
            'author' => $request->author,
        ]);

        return response()->json([
            'message' => 'Quote updated successfully',
            'data' => new QuoteResource($quote)
        ], 200);
    }

    public function destroy(Quote $quote)       //delete single quote
    {
        $quote->delete();
        return response()->json([
            'message' => 'Quote deleted succesfully'
        ], 200);
    }

    public function random(Request $request)    
    //show a random quote, if param: ?count=X => X random quotes, if param not provided => 1 random quote
    {
        $count = $request->input('count', 1);

        $validated = $request->validate([
            'count' => 'integer|min:1|max:10'
        ]);

        $randomQuote = Quote::inRandomOrder()->take($count)->get();

        if ($randomQuote->isEmpty()) {
            return response()->json(['message' => 'No Quotes available'], 404);
        }

        // return new QuoteResource($randomQuote); 
        // return response()->json(['data' => new QuoteResource($randomQuote)], 200);

        return response()->json([
            'data' => QuoteResource::collection($randomQuote)
        ], 200);
    }
}
