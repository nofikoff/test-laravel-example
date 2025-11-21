<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActorRequest;
use App\Models\Actor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActorController extends Controller
{
    public function create(): View
    {
        return view('actors.create');
    }

    public function store(StoreActorRequest $request): RedirectResponse
    {
        Actor::create([
            'email' => $request->email,
            'description' => $request->description,
            ...$request->getExtractedActorData(),
        ]);

        return redirect()->route('actors.index')
            ->with('success', __('messages.actor_created'));
    }

    public function index(): View
    {
        $actors = Actor::latest()->get();
        return view('actors.index', compact('actors'));
    }

    public function getPrompt(): JsonResponse
    {
        return response()->json([
            'message' => config('ai.actor_extraction_prompt'),
        ]);
    }
}
