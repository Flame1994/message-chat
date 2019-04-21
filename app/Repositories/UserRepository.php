<?php

namespace App\Repositories;



//use Illuminate\Database\Eloquent\Model;
use App\User as Model;

class UserRepository implements RepositoryInterface {

    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->show($id);
        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function showMany(array $ids)
    {
        $records = array();
        foreach ($ids as $id) {
            array_push($records, $this->show($id));
        }
        return $records;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
