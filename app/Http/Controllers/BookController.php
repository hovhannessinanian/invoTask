<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookSearchRequest;
use App\Http\Resources\BookResource;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Response;

class BookController extends Controller
{
    private $_bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->_bookRepository = $bookRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param BookSearchRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(BookSearchRequest $request)
    {
        return BookResource::collection($books = $this->_bookRepository->searchByAuthor($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BookRequest  $request
     * @return BookResource
     */
    public function store(BookRequest $request)
    {
        return new BookResource($this->_bookRepository->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BookResource
     */
    public function show($id)
    {
        return new BookResource($this->_bookRepository->findWithAuthorOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BookRequest  $request
     * @param  int  $id
     * @return BookResource
     */
    public function update(BookRequest $request, $id)
    {
        return new BookResource($this->_bookRepository->update($request, $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $this->_bookRepository->destroy($id);
        return response()->json();
    }
}
