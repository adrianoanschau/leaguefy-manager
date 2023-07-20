<?php

namespace Leaguefy\LeaguefyManager\Traits;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResource
{
    private Collection|null $data = null;

    private Collection|null $relations = null;

    private Collection|null $included = null;

    private string|null $message = null;
    private mixed $errors = null;
    private int $http_status = 200;

    /**
     * @param array<string> $included
     */
    protected function include(array $relations)
    {
        $this->relations = collect($relations);
    }

    protected function status(int $status)
    {
        $this->http_status = $status;

        return $this;
    }

    /**
     * @param EloquentCollection|Model $data
     */
    protected function data(EloquentCollection|Model $data)
    {
        if (get_parent_class($data) === Model::class) {
            $data = collect([$data]);
        }

        if (get_class($data) === EloquentCollection::class) {
            $data = $data->collect();
        }

        $this->data = collect([]);

        if (!is_null($this->relations)) {
            $this->included = collect([]);
        }

        $data->map(function ($item) {
            $resource = [
                'type' => $item->getTable(),
                'id' => $item->getKey(),
                'attributes' => collect($item->getAttributes())
                    ->except(collect([$item->getKeyName()])->concat($item->hidden ?? [])),
            ];

            $relationships = null;

            if (!is_null($this->relations)) {
                $relationships = collect([]);

                $this->relations->map(function ($relation) use ($item, $relationships) {
                    $collection = $item[$relation];

                    if (get_parent_class($collection) === Model::class) {
                        $collection = collect([$item[$relation]]);
                    }

                    if ($item->isLoaded($relation) && $collection->isNotEmpty()) {
                        $data = collect([]);

                        $collection->map(fn ($r) => $data->push(collect([
                            'type' => $r->getTable(),
                            'id' => $r->getKey(),
                            'attributes' => collect($r->getAttributes())
                                ->except(collect([$r->getKeyName()])->concat($r->hidden ?? [])),
                        ])));

                        $relationships->put($relation, [
                            'data' => $data->map(fn ($d) => $d->except(['attributes'])),
                        ]);

                        $this->included = $this->included->concat($data->filter(function ($item) {
                            return !$this->included->map(fn ($r) => "{$r->get('type')}.{$r->get('id')}")
                                ->contains("{$item->get('type')}.{$item->get('id')}");
                        }));
                    }
                });
            }

            if (!is_null($relationships)) {
                $resource['relationships'] = $relationships;
            }

            $this->data->push($resource);
        });

        return $this;
    }

    /**
     * @param mixed $errors
     */
    protected function errors(mixed $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param string $message
     */
    protected function message(string $message = 'error')
    {
        $this->message = $message;

        return $this;
    }

    protected function response()
    {
        $response = [
            'status' => $this->http_status < 400,
        ];

        if (!is_null($this->data)) {
            $response['data'] = $this->data;
        }

        if (!is_null($this->included)) {
            $response['included'] = $this->included;
        }

        if (!is_null($this->message)) {
            $response['message'] = $this->message;
        }

        if (!is_null($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return response()->json($response, $this->http_status);
    }

}
