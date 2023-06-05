<?php

declare(strict_types=1);

namespace App\Domain\Product\Controllers;

use App\Domain\Product\Repositories\ProductRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $repository;

    protected array $validators = [
        'name' => 'required|string|max:255',
        'description' => 'nullable',
        'brand' => 'required|string|max:255',
    ];

    /**
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return parent::index($request);
    }

    public function store(Request $request)
    {
        return parent::store($request);
    }

    public function update(Request $request, int $id)
    {
        return parent::update($request, $id);
    }

    public function destroy(int $id)
    {
        return parent::destroy($id);
    }

    public function show($id)
    {
        return parent::show($id);
    }
}
