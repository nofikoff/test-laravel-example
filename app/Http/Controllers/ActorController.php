<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActorRequest;
use App\Http\Resources\ActorResource;
use App\Models\Actor;
use App\Services\ActorExtractionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActorController extends Controller
{
    public function __construct(
        private ActorExtractionService $extractionService
    ) {}

    public function create(): View
    {
        return view('actors.create');
    }

    public function store(StoreActorRequest $request): RedirectResponse
    {
        try {
            $actorData = $this->extractionService->extractActorData($request->description);

            $actor = Actor::create([
                'email' => $request->email,
                'description' => $request->description,
                ...$actorData,
            ]);

            return redirect()->route('actors.index')
                ->with('success', __('messages.actor_created'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['description' => $e->getMessage()]);
        }
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
