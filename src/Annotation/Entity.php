<?php

namespace RM\Component\Client\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class Entity
 *
 * @Annotation
 * @Target("CLASS")
 *
 * @package RM\Component\Client\Annotation
 * @author  h1karo <h1karo@outlook.com>
 * @internal
 */
class Entity
{
    public ?string $repositoryClass = null;
}
