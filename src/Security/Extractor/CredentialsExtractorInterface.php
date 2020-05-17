<?php

namespace RM\Component\Client\Security\Extractor;

use RM\Standard\Jwt\Token\TokenInterface;

/**
 * Interface CredentialsExtractorInterface
 *
 * @package RM\Component\Client\Security\Extractor
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
interface CredentialsExtractorInterface
{
    /**
     * @param TokenInterface $token
     * @param string         $entity
     *
     * @return mixed
     */
    public function extract(TokenInterface $token, string $entity);

    /**
     * @param string $type
     * @param string $entity
     *
     * @return bool
     */
    public function supports(string $type, string $entity): bool;
}
