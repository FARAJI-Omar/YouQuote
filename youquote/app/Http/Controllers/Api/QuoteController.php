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
        // Increment the popularity count for the requested quote
        $quote->increment('popularity');

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

        // Increment the popularity count for each random quote
        foreach ($randomQuote as $quote) {
        $quote->increment('popularity');
    }

        if ($randomQuote->isEmpty()) {
            return response()->json(['message' => 'No Quotes available'], 404);
        }

        // return new QuoteResource($randomQuote); 
        // return response()->json(['data' => new QuoteResource($randomQuote)], 200);

        return response()->json([
            'data' => QuoteResource::collection($randomQuote)
        ], 200);
    }

    public function filter(Request $request)        // filter quotes by words count, limit by param length
    {
        $validator = Validator::make($request->all(), [
            'length' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid length parameter',
                'error' => $validator->messages(),
            ], 422);
        }

        $maxLength = $request->input('length');

        // Get all quotes and filter by word count in PHP
        $filteredQuotes = Quote::all()->filter(function ($quote) use ($maxLength) {
            return str_word_count($quote->content) <= $maxLength;
        });

        if ($filteredQuotes->isEmpty()) {
            return response()->json(['message' => 'No quotes found with the specified word limit'], 404);
        }

        return response()->json([
            'data' => QuoteResource::collection($filteredQuotes)
        ], 200);
    }

    public function popular()
    {
        // get the top 3 most popular quotes ordered by popularity in desc order
        $topQuotes = Quote::orderBy('popularity', 'desc')->take(3)->get();
    
        if ($topQuotes->isEmpty()) {
            return response()->json(['message' => 'No quotes found'], 404);
        }
    
        return response()->json([
            'data' => QuoteResource::collection($topQuotes)
        ], 200);
    }


}
