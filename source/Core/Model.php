<?php

namespace Source\Core;

use Source\Support\Message;

abstract class Model {
    /*     * * @var type (object | null) */

    public $data;

    /*     * * @var \PDOException | null */
    public $fail;

    /*     * * @var Message|null */
    public $message;

    /*     * * @var type string */
    public $query;

    /*     * * @var type string */
    public $terms;

    /*     * * @var type string */
    public $params;

    /*     * * @var type string */
    public $order;

    /*     * * @var type string */
    public $limit;

    /*     * * @var type string */
    public $offset;

    /*     * * @var type string */
    public $entity;

    /*     * * @var type array */
    public $protected;

    /*     * * @var type array */
    public $required;

    /**
     * It requires a table inside the database to initiate, with it´s protected parameters as well as required ones.
     * Model constructor.
     * @param string $entity
     * @param array $protected
     * @param array $required
     */
    public function __construct(string $entity, array $protected, array $required) {
        $this->entity = $entity;
        $this->protected = array_merge($protected, ['created_at', 'updated_at']);
        $this->required = $required;

        $this->message = new Message();
    }

    /**
     * Sets the parameter inside data object.
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * Ask if certain parameter is set under data object.
     * @param $name
     * @return bool
     */
    public function __isset($name): bool {
        return isset($this->data->$name);
    }

    /**
     * Access to certain property of data object.
     * @param $name
     * @return string|null
     */
    public function __get($name): ?string {
        return (!empty($this->data->$name) ? $this->data->$name : null);
    }

    /**
     * Returns data object
     * @return object|null
     */
    public function data(): ?object {
        return $this->data;
    }

    /**
     * Returns message parameter.
     * @return Message|null
     */
    public function message(): ?Message {
        return $this->message;
    }

    /**
     * Returns the error or null
     * @return \PDOException|null
     */
    public function fail(): ?\PDOException {
        return $this->fail;
    }

    public function find(?string $terms = null, ?string $params = null, string $columns = "*") {
        if ($terms) {
            $this->query = "SELECT {$columns} FROM {$this->entity} WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->query = "SELECT {$columns} FROM {$this->entity}";
        return $this;
    }

    /**
     * Returns a query result filtered by id
     * @param int $id
     * @param string $columns
     * @return Model|null
     */
    public function findById(int $id, string $columns = "*"): ?Model {
        return $this->find("id = :id", "id={$id}", $columns)->fetch();
    }

    /**
     * Limits query result;
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): Model {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    /**
     * Provide a parameter to order query result
     * @param string $order
     * @param string $direction
     * @return $this
     */
    public function order(string $order, string $direction = 'DESC'): Model {
        $this->order = " ORDER BY {$order} {$direction}";
        return $this;
    }

    /**
     * Offset rows to execute the query
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset): Model {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    /**
     * Returns the result of a specific query execution. If argument $all is passed, it is going to execute fetchAll.
     * @param bool $all
     * @return array|mixed|null
     */
    public function fetch(bool $all = false) {
        try {
            $stmt = Connect::getInstance()->prepare($this->query . $this->order . $this->limit . $this->offset);
            $stmt->execute($this->params);

            if (!$stmt->rowCount()) {
                return null;
            }

            if ($all) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
            }

            return $stmt->fetchObject(static::class);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * Counts the return of a database query.
     * @return int|null
     */
    public function count(): ?int {
        $stmt = Connect::getInstance()->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    /**
     * Provides a basic filter to a certain data
     * @param array $data
     * @return array|null
     */
    private function filter(array $data): ?array {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }

        return $filter;
    }

    /**
     * Creates a record into my database table. Returns the id created.
     * @param array $data
     * @return int|null
     */
    protected function create(array $data): ?int {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $stmt = Connect::getInstance()->prepare("INSERT INTO {$this->entity}($columns) VALUES ($values)");
            $stmt->execute($this->filter($data));


            return Connect::getInstance()->lastInsertId();
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * Method responsible for updating data in the table.
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    protected function update(array $data, string $terms, string $params): ?int {
        try {
            $dataSet = [];
            foreach ($data as $key => $value) {
                $dataSet[] = "{$key} = :{$key}";
            }

            $dataSet = implode(", ", $dataSet);
            parse_str($params, $params);

            $stmt = Connect::getInstance()->prepare("UPDATE {$this->entity} SET {$dataSet} WHERE {$terms}");
            $stmt->execute($this->filter(array_merge($data, $params)));
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * Delete record(s) from table.
     * @param string $terms
     * @param string $params
     * @return bool|null
     */
    public function delete(string $terms, string $params): ?bool {
        try {
            $stmt = Connect::getInstance()->prepare("DELETE FROM {$this->entity} WHERE {$terms}");
            if ($params) {
                parse_str($params, $params);
                $stmt->execute($params);
                return true;
            }

            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * Destroy an active record.
     * @return bool
     */
    public function destroy(): bool {
        if (empty($this->id)) {
            return false;
        }

        return $this->delete("id = :id", "id={$this->id}");
    }

    /**
     * Checks if all required fields are considered in data.
     * @return bool
     */
    protected function required(): bool {
        $dataArray = (array) $this->data();
        foreach ($this->required as $field) {
            if (empty($dataArray[$field])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Responsible for creating or updating a record on the database table.
     * @return bool
     */
    public function save(): bool {
        //update data in the database
        if (!empty($this->id)) {
            $id = $this->id;
            $this->update($this->safe(), "id = :id", "id={$this->id}");
            if ($this->fail()) {
                $this->message = (new Message())->success("Dados atualizados com sucesso!");
                return true;
            } else {
                $this->message = (new Message())->error("Erro ao atualizar os dados. Verifique e tente novamente")->before("Oops! ");
                return false;
            }
        }
        //create data in the database
        $id = $this->create($this->safe());
        if ($this->fail()) {
            $this->message = (new Message())->error("Erro ao cadastrar os dados. Verifique e tente novamente")->before("Oops! ");
            return false;
        }
        $this->data = $this->findById($id)->data();
        return true;
    }

    /**
     * Unsets protected values from data array.
     * @return array|null
     */
    protected function safe(): ?array {
        $safe = (array) $this->data;
        foreach ($this->protected as $protected) {
            unset($safe[$protected]);
        }

        return $safe;
    }

}
