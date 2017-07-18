<?php

namespace app\traits;

/**
 * Трейт для удобной работы с классами.
 * Довольно давно таскаю его из проекта в проект
 */
trait ClassIdentityTrait
{

    /**
     * Получить полное имя класса с неймспейсом.
     * @return string
     */
    public function getClassName()
    {
        return get_class($this);
    }

    /**
     * Получить имя класса без неймспейса.
     * @return string
     */
    public function getShortClassName()
    {
      return (new \ReflectionClass($this->getClassName()))->getShortName();
    }

    /**
     * Проверка на существование метода в классе
     * @param  string  $methodName Искомый метод
     * @return boolean
     */
    public function isMethodExists($methodName)
    {
        return method_exists($this, $methodName);
    }
}
