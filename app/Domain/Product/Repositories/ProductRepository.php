<?php

declare(strict_types=1);

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function index()
    {
        return Product::orderBy('id')->get();
    }

    public function store(array $request): Product
    {
        try {
            DB::beginTransaction();

            $createdProduct = Product::create($request);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }

        return $createdProduct;
    }

    public function update(array $data, int $id)
    {
        $updateProduct = Product::find($id);

        return $updateProduct->fill($data)->save();
    }

    public function destroy(int $id): bool
    {
        return (bool) Product::destroy($id);
    }
}
