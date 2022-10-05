<?php

namespace App\Services;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\Lk\Products\ProductCreateRequest;
use App\Http\Requests\API\Lk\Products\ProductDeleteRequest;
use App\Http\Requests\API\Lk\Products\ProductIndexRequest;
use App\Http\Requests\API\Lk\Products\ProductUpdateRequest;
use App\Models\CdpProducts;
use App\Models\CdpProductsCatalog;
use App\Models\CdpProductsCategories;
use App\Models\CdpUsers;
use App\Services\Contracts\CdpProductsServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CdpProductsService implements CdpProductsServiceInterface
{
    public function index(Request $request)
    {
        try {
            $user = CdpUsers::index($request->bearerToken());
            $products = CdpProducts::join('cdp_products_categories', 'cdp_products_categories.id', '=', 'cdp_products.category_id')
                ->join('cdp_products_catalogs', 'cdp_products_categories.catalog_id', '=', 'cdp_products_catalogs.id')
                ->where('cdp_products_catalogs.mall_id', $user->mall_id)
                ->when($request->visible_all != true, function ($query) {
                    return $query->where('cdp_products.visible', true);
                })
                ->select(['cdp_products.*', 'cdp_products_categories.catalog_id as catalog_id'])
                ->orderBy('cdp_products_categories.sort_categories', 'ASC')->orderBy('cdp_products.sort_product', 'ASC')
                ->paginate(30);

            return ApiController::sendResponse($products, 'Данные о продуктах успешно получены', true);
        } catch (\Exception $exception) {
            return ApiController::sendError('Ошибка при получении данных о продуктах', ['status_code' => 501], 501);
        }
    }

    public function random(Request $request)
    {
        try {
            $user = CdpUsers::index($request->bearerToken());
            $products = CdpProducts::join('cdp_products_categories', 'cdp_products_categories.id', '=', 'cdp_products.category_id')
                ->join('cdp_products_catalogs', 'cdp_products_categories.catalog_id', '=', 'cdp_products_catalogs.id')
                ->where('cdp_products_catalogs.mall_id', $user->mall_id)
                ->when($request->visible_all != true, function ($query) {
                    return $query->where('cdp_products.visible', true);
                })
                ->select(['cdp_products.*', 'cdp_products_categories.catalog_id as catalog_id'])
                ->inRandomOrder()->take(4)->get();

            return ApiController::sendResponse($products, 'Данные о продуктах успешно получены', true);
        } catch (\Exception $exception) {
            return ApiController::sendError('Ошибка при получении данных о продуктах', ['status_code' => 501], 501);
        }
    }

    public function getRandomByToken(Request $request)
    {
        if ($request->token == Config::get('externalaccess.token')) {
            try {
                $products = CdpProducts::join('cdp_products_categories', 'cdp_products_categories.id', '=', 'cdp_products.category_id')
                    ->join('cdp_products_catalogs', 'cdp_products_categories.catalog_id', '=', 'cdp_products_catalogs.id')
                    ->where('cdp_products_catalogs.mall_id', $request->mall_id)
                    ->when($request->visible_all != true, function ($query) {
                        return $query->where('cdp_products.visible', true);
                    })
                    ->select(['cdp_products.*', 'cdp_products_categories.catalog_id as catalog_id'])
                    ->inRandomOrder()->take(10)->get();

                return ApiController::sendResponse($products, 'Данные о продуктах успешно получены', true);
            } catch (\Exception $exception) {
                return ApiController::sendError('Ошибка при получении данных о продуктах', ['status_code' => 501], 501);
            }
        }

        return ApiController::sendError('В доступе отказано', ['status_code' => 403], 403);
    }

    public function create(ProductCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $hash = sha1(uniqid());
            $category_id = CdpProductsCategories::where('october_id', $request->category_id)->pluck('id')->first();
            $lastProductInCategory = CdpProducts::query()->where('category_id', $category_id)->orderBy('sort_product' , 'desc')->first();
            $hash = sha1(uniqid());
            $filename = sha1(uniqid());
            $file = CdpFileService::storeForCategories($request->product_image , '' ,$hash  , $filename);
            if ($lastProductInCategory) {
                $createdProduct = CdpProducts::query()->create(array_merge($request->all(), ['sort_product' => $lastProductInCategory->sort_product + 1], ['category_id' => $category_id] , ['product_image' => 'storage/'.$file->file_name]));
            } else {
                $createdProduct = CdpProducts::query()->create(array_merge($request->all(), ['sort_product' => 1] , ['category_id' => $category_id],['product_image' => 'storage/'.$file->file_name]));
            }
            DB::commit();

            return ApiController::sendResponse($createdProduct, 'Товар успешно создан', true);
        } catch (\Exception $exception) {
            DB::rollBack();

            return ApiController::sendError('Ошибка создания товара', ['status_code' => '501'], 501);
        }
    }

    public function update(ProductUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->product_image) {
                $hash = sha1(uniqid());
                $filename = sha1(uniqid());
                $file = CdpFileService::storeForCategories($request->image , '' ,$hash  , $filename);
                $img = 'storage/' . $file->file_name;
            }

            $product = CdpProducts::where('october_id',$request->october_id)->update(array_filter([
                'name' => $request->name,
                'visible' => $request->visible,
                'product_image' => $img ?? null,
                'price' => $request->price,
                'product_count' => $request->product_count
            ]));
            DB::commit();

            return ApiController::sendResponse(['updated' => $product], 'Товар успешно обновлен', true);
        } catch (\Exception $exception) {
            DB::rollBack();

            return ApiController::sendError('Ошибка обновления товара', ['status_code' => '501', 'updated' => false], 501);
        }
    }

    public function delete(ProductDeleteRequest $request)
    {
        if ($deleted = CdpProducts::where('october_id', $request->october_id)->delete()) {
            return ApiController::sendResponse(['deleted' => $deleted], 'Товар успешно удален', true);
        }

        return ApiController::sendError('Ошибка удаления товара', ['status_code' => '501', 'deleted' => $deleted], 501);
    }

    public function show(int $id)
    {
        return CdpProducts::where('id', $id)->first();
    }
}
