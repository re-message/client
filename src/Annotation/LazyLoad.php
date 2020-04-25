<?php

namespace RM\Component\Client\Annotation;

/**
 * Class LazyLoad
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package RM\Component\Client\Annotation
 * @author  h1karo <h1karo@outlook.com>
 * @internal
 */
class LazyLoad
{
    public string $entity;
}
