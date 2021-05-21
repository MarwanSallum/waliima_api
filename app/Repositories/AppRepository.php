<?php 
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AppRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get()
    {
        return $this->model->get();
    }

    public function paginate()
    {
        return $this->model->paginate(5);
    }

    public function store(Request $request)
    {
        $data = $this->setDataPayload($request);
        $item = $this->model;
        $item->fill($data);
        $item->save();
        return $item;
    }

    // public function update($id, Request $request)
    // {
    //     $data = $this->setDataPayload($request, $id);
    //     $item = $this->model->findOrFail($id);
    //     $item->fill($data);
    //     $item->save();
    //     return $item;
    // }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    protected function setDataPayload(Request $request)
    {
        return $request->all();
    }
}