<?php

namespace App\Http\Controllers;

use App\Models\Constrained;
use App\Http\Requests\StoreConstrainedRequest;
use App\Http\Requests\UpdateConstrainedRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\ConstrainedResource;
use Carbon\Carbon;

class ConstrainedController extends Controller
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
        $this->authorize('viewAny', Constrained::class);
        /*$constrained = Constrained::first();
        return new ConstrainedResource($constrained);*/
        $firstConstrained = Constrained::first();
    $lastConstrained = Constrained::latest()->first();

    $constrainedData = [
        'first_constrained' => new ConstrainedResource($firstConstrained),
        'last_constrained' => new ConstrainedResource($lastConstrained)
    ];

    return response()->json($constrainedData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Constrained  $constrained
     * @return \Illuminate\Http\Response
     */
    public function show(Constrained $constrained)
    {
        return new ConstrainedResource($constrained);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConstrainedRequest  $request
     * @param  \App\Models\Constrained  $constrained
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConstrainedRequest $request, Constrained $constrained)
    {
        $this->authorize('viewAny', Constrained::class);
        $constrained = Constrained::findOrFail($constrained->id);

        $constrained->nbr_day = $request->input('nbr_day');
        //$constrained->slug = Str::slug($constrained->nbr_day);

        $constrained->save();

        return new ConstrainedResource($constrained);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Constrained  $constrained
     * @return \Illuminate\Http\Response
     */
    public function destroy(Constrained $constrained)
    {
        $this->authorize('viewAny', Constrained::class);
        $constrained->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $this->authorize('viewAny', Constrained::class);
        $constrained = Constrained::withTrashed()->find($id);
        $constrained->restore();
        return new ConstrainedResource($constrained);
    }
}
