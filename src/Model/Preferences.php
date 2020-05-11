<?php

namespace RM\Component\Client\Model;

/**
 * Class RequestPreferences
 *
 * @package RM\Component\Client\Model
 * @author  h1karo <h1karo@outlook.com>
 */
class Preferences
{
    private CodeMethod $method;

    public function __construct()
    {
        $this->method = CodeMethod::get(CodeMethod::AUTO);
    }

    public function getMethod(): CodeMethod
    {
        return $this->method;
    }

    public function setMethod(CodeMethod $method): void
    {
        $this->method = $method;
    }

    public function toArray(): array
    {
        return [
            'method' => $this->method->getValue()
        ];
    }
}
