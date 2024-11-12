<?php

namespace App\Http\Controllers;

use App\Models\Mobility;
use App\Http\Requests\StoreMobilityRequest;
use App\Http\Requests\UpdateMobilityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\MobilityResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MobilityController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('viewAny', Mobility::class);
        $query = $request->input('search'); 

        $mobility = Mobility::orderBy('created_at', 'desc')
        ->where( 'last_name_benefit' , 'like' , '%'. $query . '%' )
            ->paginate(15);

        return MobilityResource::collection($mobility);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAuth(Request $request)
    {
        //$this->authorize('viewAnyAuth', Mobility::class);
        $query = $request->input('search');
    $user = Auth::user();
    if ($user) {
        $mobility = $user->mobilities()->orderBy('date_go', 'desc')
        ->where(function ($q) use ($query) {
            $q->where('first_name_benefit', 'like', '%' . $query . '%')
              ->orWhere('last_name_benefit', 'like', '%' . $query . '%');
        })
        ->paginate(10);
        return new MobilityResource($mobility);
    }
    }

    public function collection()
    {
        /*$this->authorize('viewAny', Mobility::class);
        $mobility = Mobility::all();
        return $mobility;*/
        //$this->authorize('viewAny', Event::class);
        $mobility = Mobility::select(
            'first_name_benefit as prénom',
            'last_name_benefit as nom',
            'date_go as date de départ',
            'date_return as date de retour',
            'destination'
            )->get();
        return $mobility;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMobilityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMobilityRequest $request)
    {
        $mobility = new Mobility();

        $mobility->first_name_benefit = $request->input('first_name_benefit');
        $mobility->last_name_benefit = $request->input('last_name_benefit');
        $mobility->status = $request->input('status');
        //$mobility->slug = Str::slug($request->input('first_name_benefit') . ' ' . $request->input('last_name_benefit'));
        $mobility->date_go = Carbon::parse($request->input('date_go'))->toDateString();
        $mobility->date_return = Carbon::parse($request->input('date_return'))->toDateString();
        $mobility->destination = $request->input('destination');
        $mobility->laboratory = $request->input('laboratory') ?? 'aucun';
        $mobility->department = $request->input('department') ?? 'aucun';
        //$mobility->user_id = Auth::id();
        $mobility->user_id = Auth::id();

        $mobility->save();

        return new MobilityResource($mobility);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mobility  $mobility
     * @return \Illuminate\Http\Response
     */
    public function show(Mobility $mobility)
    {
        //$this->authorize('viewAny', Mobility::class);
        return new MobilityResource($mobility);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMobilityRequest  $request
     * @param  \App\Models\Mobility  $mobility
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMobilityRequest $request, Mobility $mobility)
    {
        //$this->authorize('viewAny', Mobility::class);
        $mobility = Mobility::findOrFail($mobility->id);
        $mobility->first_name_benefit = $request->input('first_name_benefit');
        $mobility->last_name_benefit = $request->input('last_name_benefit');
        $mobility->status = $request->input('status');
        //$mobility->slug = Str::slug($request->input('first_name_benefit') . ' ' . $request->input('last_name_benefit'));
        $mobility->date_go = Carbon::parse($request->input('date_go'))->toDateString();
        $mobility->date_return = Carbon::parse($request->input('date_return'))->toDateString();
        $mobility->destination = $request->input('destination');
        $mobility->laboratory = $request->input('laboratory') ?? 'aucun';
        $mobility->department = $request->input('department') ?? 'aucun';
        //$mobility->user_id = Auth::id();
        $mobility->user_id = 14;

        $mobility->save();

        return new MobilityResource($mobility);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mobility  $mobility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mobility $mobility)
    {
        //$this->authorize('viewAny', Mobility::class);
        $mobility->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        //$this->authorize('viewAny', Mobility::class);
        $mobility = Mobility::withTrashed()->find($id);
        $mobility->restore();
        return new MobilityResource($mobility);
    }
}
