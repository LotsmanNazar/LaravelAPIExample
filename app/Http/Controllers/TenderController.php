<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests\TenderIndexRequest;
use App\Http\Requests\TenderCreateRequest;

class TenderController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(TenderIndexRequest $request)
	{
		$perPage = 10;
		$data = $request->validated();
		$name = isset( $data['search_by_name'] ) ? $data['search_by_name'] : '';
		$changeDateStart = isset( $data['search_by_date_start'] ) ? $data['search_by_date_start'] : '';
		$changDateEnd = isset( $data['search_by_date_end'] ) ? $data['search_by_date_end'] : '';

		if ( $changeDateStart && !$changDateEnd ) {
			$changDateEnd = Carbon::now()->format('Y-m-d H:i:s');
		}

		if ( !$changeDateStart && $changDateEnd ) {
			$changeDateStart = Carbon::createFromTimestamp(0)->format('Y-m-d H:i:s');
		}

		$query = Tender::query()->select(
			'id',
			'external_code',
			'number',
			'status',
			'name',
			'change_date'
		)->orderBy('id', 'asc');

		if ( $name ) {
			$query->where('name', 'like', '%' . $name . '%');
		}

		if ( $changeDateStart && $changDateEnd ) {
			$query->whereBetween('change_date', [$changeDateStart, $changDateEnd]);
		}

		var_dump( $changeDateStart, $changDateEnd );

		$tenders = $query->cursorPaginate($perPage);
		$tenders->appends($request->except('cursor'));

		return response()->json($tenders);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return response()->json([
			'error' => true,
			'message' => 'The route is temporarily unavailable.'
		], 405);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(TenderCreateRequest $request)
	{
		$data = $request->validated();

		try {
			$tender = Tender::create($data);
			unset($tender->created_at);
			unset($tender->updated_at);

			return response()->json($tender, 201);
		} catch (\Exception $e) {
			return response()->json([
				'error' => true,
				'message' => 'Server error'
			], 500);
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show($id)
	{
		$tender = Tender::find($id);

		if ( !$tender ) {
			return response()->json([
				'error' => true,
				'message' => 'Tender with id ' . $id . ' not Found'
			], 404);
		}

		return response()->json($tender);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Tender $tender)
	{
		return response()->json([
			'error' => true,
			'message' => 'The route is temporarily unavailable.'
		], 405);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Tender $tender)
	{
		return response()->json([
			'error' => true,
			'message' => 'The route is temporarily unavailable.'
		], 405);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Tender $tender)
	{
		return response()->json([
			'error' => true,
			'message' => 'The route is temporarily unavailable.'
		], 405);
	}
}
