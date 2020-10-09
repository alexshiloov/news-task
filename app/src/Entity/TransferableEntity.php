<?php


namespace App\Entity;


use App\Dto\AbstractDto;

abstract class TransferableEntity
{
    /**
     * Получить объекто класса dto
     *
     * @return AbstractDto
     */
    abstract public function getEntityDtoObject();

    /**
     * @return AbstractDto
     */
    public function toDto(): AbstractDto
    {
        $entityDto = $this->getEntityDtoObject();

        foreach (get_class_vars(get_class($entityDto)) as $key => $value) {
            $getMethod = $this->generateMethod($key, 'get');
            $isMethod = $this->generateMethod($key, 'is');

            if (method_exists($this, $getMethod)) {
                $entityDto->$key = $this->$getMethod();
            }

            if (method_exists($this, $isMethod)) {
                $entityDto->$key = $this->$isMethod();
            }

            if (method_exists($this, $key)) {
                $entityDto->$key = $this->$key();
            }
        }

        return $entityDto;
    }

    /**
     * generate set or get method
     *
     * @param $key
     * @param string $action
     * @return string
     */
    private function generateMethod($key, $action = 'get')
    {
        $key = explode('_', $key);
        $key = array_map('ucfirst', $key);
        $method = $action . implode('', $key);
        return $method;
    }

    /**
     * fill entity object
     *
     * @param $data
     * @return $this
     */
    public function fill(AbstractDto $data)
    {
        foreach (get_object_vars($data) as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * set entity property
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $method = $this->generateMethod($key, 'set');
        if (method_exists($this, $method)) {
            return $this->$method($value);
        } else {
            return $this;
        }
    }
}
