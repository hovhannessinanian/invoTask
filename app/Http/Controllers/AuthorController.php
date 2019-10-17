<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AuthorResource
     */
    public function index()
    {
        $authors = Author::paginate();
        return AuthorResource::collection($authors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AuthorResource
     */
    public function store(AuthorRequest $request)
    {
        $author = new Author();
        $author->fill($request->validated());
        $author->save();
        return new AuthorResource($author);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return AuthorResource
     */
    public function show($id)
    {
        $author = Author::findOrFail($id);
        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AuthorRequest  $request
     * @param  int  $id
     * @return AuthorResource
     */
    public function update(AuthorRequest $request, $id)
    {
        $author = Author::findOrFail($id);
        $author->fill($request->validated());
        $author->save();
        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return response()->json();
    }
}
