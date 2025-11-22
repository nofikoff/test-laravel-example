<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActorRequest;
use App\Http\Resources\ActorResource;
use App\Services\ActorDataCache;
use App\Services\ActorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\View\View;

class ActorController extends Controller
{
    public function __construct(
        private readonly ActorService $actorService,
        private readonly ActorDataCache $cache
    ) {}

    public function create(): View
    {
        return view('actors.create');
    }

    /**
     * Uses cached AI extraction result from validation to avoid duplicate API calls.
     */
    public function store(StoreActorRequest $request): RedirectResponse
    {
        $this->actorService->createFromDescription(
            $request->validated('description'),
            $request->validated('email'),
            $this->cache->get()
        );

        return redirect()->route('actors.index')
            ->with('success', __('messages.actor_created'));
    }

    public function index(): View
    {
        return view('actors.index', [
            'actors' => $this->actorService->getAllActors()
        ]);
    }

    public function api(): AnonymousResourceCollection
    {
        return ActorResource::collection(
            $this->actorService->getAllActors(20)
        );
    }

    public function showPrompt(): View
    {
        return view('actors.prompt', [
            'prompt' => config('ai.actor_extraction_prompt'),
            'apiUrl' => route('api.v1.actors.prompt')
        ]);
    }

    /**
     * Client requirement: exposes AI prompt for transparency.
     */
    public function getPrompt(): JsonResponse
    {
        return response()->json([
            'message' => config('ai.actor_extraction_prompt'),
        ]);
    }
}
