<?php

namespace App\Repositories;

use App\Book;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookSearchRequest;
use App\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    public function find(int $id)
    {
        return Book::find($id);
    }

    public function findOrFail(int $id)
    {
        return Book::findOrFail($id);
    }

    public function findWithAuthorOrFail(int $id)
    {
        return Book::withAuthor()->findOrFail($id);
    }

    public function searchByAuthor(BookSearchRequest $request)
    {
        $searchResult = Book::withAuthor();
        if ($request->has('dob')) {
            $dob = $request->input('dob');
            switch ($request->input('condition', '')) {
                case 'greater':
                    $condVal = '>';
                    break;
                case 'less':
                    $condVal = '<';
                    break;
                default:
                    $condVal = '=';
            }
            $searchResult = $searchResult->whereHas('author', function ($q) use ($condVal, $dob) {
                return $q->where('dob', $condVal, $dob);
            });
        }
        return $searchResult->paginate();
    }

    public function store(BookRequest $request)
    {
        $book = new Book();
        $book->fill($request->validated());
        $book->save();
        return $book;
    }

    public function update(BookRequest $request, int $id)
    {
        $book = $this->findOrFail($id);
        $book->fill($request->validated());
        $book->save();
        return $book;
    }

    public function destroy(int $id)
    {
        Book::findOrFail($id)->delete();
    }
}
