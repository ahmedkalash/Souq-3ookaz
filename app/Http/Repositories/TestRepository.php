<?php

namespace App\Http\Repositories;

use App\Models\Product;
use Unlimited\Repository\Services\BaseEloquentService;
use App\Http\Interfaces\TestInterface;

class TestRepository extends BaseEloquentService implements TestInterface
{
    protected $modelName;

    public function __construct()
    {
//        dd(Product::query()->toRawSql());
//        dd(Product::query()->find(2));
        //$this->instance = $this->getNewInstance();
    }

    public function index()
    {
//        dd(Product::query()->toRawSql());
//        dd(Product::find(2));
    }

    public function create()
    {
        //toDo
    }

    /**
     * @param $request
     */
    public function store($request)
    {
        $this->executeSave($request->all());
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        $row = $this->findById($id);
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        $this->instance = $this->findById($id);
    }

    /**
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        $this->instance = $this->findById($id);
        $this->executeSave($request->all());
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $this->instance = $this->findById($id);
        $this->delete($id);
    }
}
