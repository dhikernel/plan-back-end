<?php

declare(strict_types=1);

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Models\Product;
use App\Domain\Product\Resources\ProductCollection;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository
{
    public function index()
    {
        $query = QueryBuilder::for(Product::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
            ])
            ->defaultSort('created_at')
            ->paginate(request('per_page', config('settings.AMOUNT_PAGINATE_DEFAULT')))
            ->appends(request()->query());

        $returnProductCollection = new ProductCollection($query);

        return $returnProductCollection->resource;
    }
    public function edit($id)
    {
        return Product::find($id);
    }

    /**
     * @throws Exception
     */
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
