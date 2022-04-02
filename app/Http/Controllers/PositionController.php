<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Position::class, 'position');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Position::query();
            return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->editColumn('position_name', function ($position) {
                        return view('positions.edit', compact('position'))->render();
                    })
                    ->orderColumn('positions_name', function ($query, $order) {
                        $query->orderBy('position_name', $order);
                    })

                    ->editColumn('created_at', function ($position) {
                        return $position->created_at ? with(new Carbon($position->created_at))->format('d-m-Y') : '';
                    })
                    ->addColumn('action', function ($position) {
                        if (Auth::check() && Auth::user()->isAdmin()) {
                            return view('positions.action_buttons', compact('position'))->render();
                        }
                    })
                    ->rawColumns(['action', 'position_name'])
                    ->make(true);
        }
        $positions = Position::pluck('position_name', 'id')->unique()->sort()->all();
        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $position = new Position();
        return view('positions.create', compact('position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $positionInputData = $this->validate($request, [
            'position_name' => 'required|max:255|unique:positions',
        ], $messages = [
            'unique' => __('validation.The position name has already been taken'),
            'max' => __('validation.The name should be no more than :max characters'),
        ]);

        $position = new Position();
        $position->fill($positionInputData);
        $position->save();

        flash(__('positions.Position has been added successfully'))->success();
        return redirect()
            ->route('positions.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $positionInputData = $this->validate($request, [
            'position_name' => 'required|max:255|unique:positions,name,' . $position->id,
        ], $messages = [
            'unique' => __('validation.The position name has already been taken'),
            'max' => __('validation.The name should be no more than :max characters'),
        ]);

        $position->fill($positionInputData);
        $position->save();

        flash(__('positionss.Position has been updated successfully'))->success();
        return redirect()
            ->route('positions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        if ($position->users()->exists()) {
            flash(__('positions.Failed to delete position'))->error();
            return back();
        }

        $position->delete();
        flash(__('positions.Position has been deleted successfully'))->success();
        return redirect()->route('positions.index');
    }
}
