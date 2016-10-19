<?php

class AdminMovieController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$movies = Movie::with('categories')->paginate();

		return $movies;

		return View::make('admin.movie.index')
			->with('movies', $movies);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$categories = Category::lists('category_name', 'id');

		return View::make('admin.movie.create')->with('categories', $categories);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), [
			'title' => 'required'
		]);

		if($validator->fails())
		{
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$movie = Movie::create([
			'title' => Input::get('title'),
			'slug' => Str::slug(Input::get('title'))
		]);

		foreach (Input::get('category_ids') as $id) {
			DB::table('movie_category')->insert([
				'movie_id' => $movie->id,
				'category_id' => $id
			]);
		}

		return Redirect::route('admin.movie.index');

		
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function status($id)
	{
		//
	}


}
