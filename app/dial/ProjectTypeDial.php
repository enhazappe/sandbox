<?php

namespace Project\Dial;

class ProjectTypeDial
{
    /**
     * @return array
     */
    static function getList()
    {
        return [
            0 => 'Časově omezený projekt',
            1 => 'Continous Integration'
        ];
    }

    /**
     * @param int $key
     *
     * @return string|null
     */
    static function getProject($key)
    {
        return isset(self::getList()[$key]) ? self::getList()[$key] : null;
    }
}