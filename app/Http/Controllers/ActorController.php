<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActorRequest;
use App\Http\Resources\ActorResource;
use App\Models\Actor;
use App\Services\ActorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\View\View;

class ActorController extends Controller
{
    public function __construct(
        private readonly ActorService $actorService
    ) {}

    public function create(): View
    {
        return view('actors.create');
    }

    public function store(StoreActorRequest $request): RedirectResponse
    {
        $this->actorService->createFromDescription(
            $request->description,
            $request->email
        );

        return redirect()->route('actors.index')
            ->with('success', __('messages.actor_created'));
    }

    public function index(): View
    {
        $actors = Actor::latest()->get();

        return view('actors.index', compact('actors'));
    }

    public function api(): AnonymousResourceCollection
    {
        $actors = Actor::latest()->get();

        return ActorResource::collection($actors);
    }

    public function showPrompt(): View
    {
        $prompt = config('ai.actor_extraction_prompt');
        $apiUrl = route('api.v1.actors.prompt');

        return view('actors.prompt', compact('prompt', 'apiUrl'));
    }

    public function getPrompt(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => config('ai.actor_extraction_prompt'),
        ]);
    }
}
