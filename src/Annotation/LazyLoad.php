<?php

namespace RM\Component\Client\Annotation;

/**
 * Class LazyLoad
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package RM\Component\Client\Annotation
 * @author  Oleg Kozlov <h1karo@outlook.com>
 * @internal
 */
class LazyLoad
{
    public string $entity;
}
