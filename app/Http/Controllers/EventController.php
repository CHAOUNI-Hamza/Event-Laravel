<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\EventResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('viewAny', Event::class);
        $query = $request->input('search'); 

        $events = Event::orderBy('date', 'desc')
        ->where( 'title' , 'like' , '%'. $query . '%' )
        ->paginate(15);

        return EventResource::collection($events);
    }

    public function indexVal(Request $request)
{ 
    // Récupérer les événements avec le statut "valider"
    $events = Event::where('status', 'valider')->get();

    // Retourner les événements sous forme de ressource
    return EventResource::collection($events);
}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAuth(Request $request)
    {
        //$this->authorize('viewAnyAuth', Event::class);
        $query = $request->input('search');
    $user = Auth::user();
    if ($user) {
        $events = $user->events()->orderBy('date', 'desc')
        ->where( 'title' , 'like' , '%'. $query . '%' )
        ->paginate(10);
        return new EventResource($events);
    }
    }

    public function all(Request $request)
    {
        $this->authorize('viewAny', Event::class);
        $events = Event::orderBy('created_at', 'desc')->get();
        return EventResource::collection($events);
    }

    public function collection()
    {
        //$this->authorize('viewAny', Event::class);
        $events = Event::select(
            'title as titre',
            'date',
            'coordinator as coordinateur',
            'place as salle_amphi',
            'type'
            )->get();
        return $events;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        // Vérifier si la date est déjà réservée
    $existingEvent = Event::where('date', Carbon::parse($request->input('date'))->toDateString())->first();

    if ($existingEvent) {
        return response()->json(['errorDate' => 'التاريخ محجوز، الرجاء اختيار تاريخ آخر'], 422);
    }

    // Si la date n'est pas déjà réservée, créer un nouvel événement
    $event = new Event();

    $event->title = $request->input('title');
    $event->type = $request->input('type');
    $event->status = $request->input('status');
    //$event->slug = Str::slug($event->title);
    $event->date = Carbon::parse($request->input('date'))->toDateString();
    $event->duration = $request->input('duration') ?? 0;
    $event->place = $request->input('place');
    $event->coordinator = $request->input('coordinator');
    $event->laboratory = $request->input('laboratory') ?? 'aucun';
    $event->department = $request->input('department') ?? 'aucun';
    $event->user_id = Auth::id();

    $event->save();

    return new EventResource($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //$this->authorize('viewAny', Event::class);
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        // Vérifier si la date est déjà réservée
    $existingEvent = Event::where('date', Carbon::parse($request->input('date'))->toDateString())->first();

    if ($existingEvent) {
        return response()->json(['errorDate' => 'التاريخ محجوز، الرجاء اختيار تاريخ آخر'], 422);
    }
        //$this->authorize('viewAny', Event::class);
        $event = Event::findOrFail($event->id);

        $event->title = $request->input('title');
        $event->type = $request->input('type');
        $event->status = $request->input('status');
        //$event->slug = Str::slug($event->title);
        $event->date = Carbon::parse($request->input('date'))->toDateString();
        $event->duration = $request->input('duration') ?? 0;
        $event->place = $request->input('place');
        $event->coordinator = $request->input('coordinator');
        $event->laboratory = $request->input('laboratory') ?? 'aucun';
        $event->department = $request->input('department') ?? 'aucun';
        $event->user_id = Auth::id();

        $event->save();

        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //$this->authorize('viewAny', Event::class);
        $event->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $this->authorize('viewAny', Event::class);
        $event = Event::withTrashed()->find($id);
        $event->restore();
        return new EventResource($event);
    }
}
