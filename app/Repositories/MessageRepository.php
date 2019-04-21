<?php

namespace App\Repositories;



//use Illuminate\Database\Eloquent\Model;
use App\Message as Model;

class MessageRepository implements RepositoryInterface {

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
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function show($id)
    {
        return $this->model->find($id);
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

    public function allMessages($id) {
        return $this->model
            ->where('from_id', $id)
            ->orWhere('to_id', $id)->get();
    }

    public function allIncomingMessages($id) {
        return $this->model
            ->where('to_id', $id)->get();
    }

    public function allOutgoingMessages($id) {
        return $this->model
            ->where('from_id', $id)->get();
    }

    public function incomingMessagesFrom($id, $from) {
        return $this->model
            ->where('from_id', $from)
            ->where('to_id', $id)->get();
    }

    public function outgoingMessagesTo($id, $to) {
        return $this->model
            ->where('from_id', $id)
            ->where('to_id', $to)->get();
    }

    public function messagesBetween($id, $user) {
        return $this->model
            ->where(function ($q) use ($id, $user) {
                $q->where('from_id', $id)->where('to_id', $user);
            })
            ->orWhere(function ($q) use ($id, $user) {
                $q->where('from_id', $user)->where('to_id', $id);
            })->orderBy('date_created', 'DESC')->get();
    }
}
