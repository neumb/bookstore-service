<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Queries\AuthorQueries;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class AuthorController extends Controller
{
    public function index(AuthorQueries $queries): LengthAwarePaginator
    {
        return $queries->paginateQuery()->paginate();
    }

    public function store(StoreAuthorRequest $request): AuthorResource
    {
        // TODO: move logic to dedicated service
        $author = tap(new Author, function (Author $author) use ($request): void {
            $author->fill($request->safe()->all());
            $author->save();
        });

        return AuthorResource::make($author);
    }

    public function show(Author $author): AuthorResource
    {
        return AuthorResource::make($author);
    }

    public function update(UpdateAuthorRequest $request, Author $author): AuthorResource
    {
        $author = tap($author, function (Author $author) use ($request): void {
            $author->fill($request->safe()->all());
            $author->save();
        });

        return AuthorResource::make($author);
    }

    public function destroy(Author $author): void
    {
        //
    }
}
