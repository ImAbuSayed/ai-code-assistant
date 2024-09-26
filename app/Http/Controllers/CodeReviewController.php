<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CodeSnippet;

class CodeReviewController extends Controller
{
    public function index()
    {
        $codeSnippets = CodeSnippet::latest()->get();
        return view('code-review.index', compact('codeSnippets'));
    }
}
