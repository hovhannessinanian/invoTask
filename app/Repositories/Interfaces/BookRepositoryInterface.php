<?php


namespace App\Repositories\Interfaces;


use App\Http\Requests\BookRequest;
use App\Http\Requests\BookSearchRequest;

interface BookRepositoryInterface
{
    public function find(int $id);
    public function findOrFail(int $id);
    public function findWithAuthorOrFail(int $id);
    public function searchByAuthor(BookSearchRequest $request);
    public function store(BookRequest $request);
    public function update(BookRequest $request, int $id);
    public function destroy(int $id);
}
