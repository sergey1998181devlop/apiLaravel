<?php

namespace App\Services;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\Lk\Products\CategoryCreateRequest;
use App\Http\Requests\API\Lk\Products\CategoryIndexRequest;
use App\Http\Requests\API\Lk\Products\CategoryUpdateRequest;
use App\Http\Requests\API\Lk\Products\CategoryDeleteRequest;
use App\Models\CdpProducts;
use App\Models\CdpProductsCategories;
use App\Services\Contracts\CdpProductsCategoriesServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CdpProductsCategoriesService implements CdpProductsCategoriesServiceInterface
{
    public function create(CategoryCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $hash = sha1(uniqid());
            $filename = sha1(uniqid());
            $file = CdpFileService::storeForCategories($request->image , '' ,$hash  , $filename);
            $createdCategory = CdpProductsCategories::query()->create(array_merge($request->all(), ['category_image' => 'storage/'.$file->file_name]));
            DB::commit();

            return ApiController::sendResponse($createdCategory, 'Категория успешно создана', true);
        } catch (\Exception $exception) {
            DB::rollBack();
            return ApiController::sendError('Ошибка создания категории', ['status_code' => '501'], 501);
        }
    }

    public function show(CategoryIndexRequest $request)
    {
        return CdpProductsCategories::where('catalog_id', $request->catalog_id)->get();
    }

    public function getRandomByToken(Request $request)
    {
        if ($request->token == Config::get('externalaccess.token')) {
            try {
                $categories = CdpProductsCategories::where('catalog_id', $request->catalog_id)->inRandomOrder()->take(10)->get();

                return ApiController::sendResponse($categories, 'Данные о категориях успешно получены', true);
            } catch (\Exception $exception) {
                return ApiController::sendError('Ошибка при получении данных о продуктах', ['status_code' => 501], 501);
            }
        }

        return ApiController::sendError('В доступе отказано', ['status_code' => 403], 403);

    }

    public function update(CategoryUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->image) {
                $hash = sha1(uniqid());
                $filename = sha1(uniqid());
                $file = CdpFileService::storeForCategories($request->image , '' ,$hash  , $filename);
                $img = 'storage/'.$file->file_name;
            }

            $data = CdpProductsCategories::where('october_id', $request->october_id)->update(array_filter([
                'name' => $request->name,
                'catalog_id' => $request->catalog_id,
                'category_image' => $img ?? null,
                'sort_categories' => $request->sort_categories
            ]));
            DB::commit();

            return ApiController::sendResponse(['updated' => $data], 'Категория товаров успешно обновлна', true);
        } catch (\Exception $exception) {
            DB::rollBack();

            return ApiController::sendError('Ошибка обновления категории', ['status_code' => '501'], 501);
        }
    }

    public function delete(CategoryDeleteRequest $request)
    {
        $category = CdpProductsCategories::where('october_id', $request->category_id)->first();
        CdpProducts::where('category_id', $category->id)->delete();
        if ($deleted = $category->delete()) {
            return ApiController::sendResponse(['deleted' => $deleted], 'Категория товаров успешно удалена', true);
        }

        return ApiController::sendError('Ошибка удаления', ['status_code' => '501', 'deleted' => $deleted], 501);
    }
}
