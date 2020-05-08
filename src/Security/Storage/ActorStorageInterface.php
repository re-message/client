<?php

namespace RM\Component\Client\Security\Storage;

use RM\Component\Client\Entity\Application;
use RM\Component\Client\Entity\User;

/**
 * Interface ActorStorageInterface
 *
 * @package RM\Component\Client\Security\Storage
 * @author  h1karo <h1karo@outlook.com>
 */
interface ActorStorageInterface
{
    public function getApplication(): ?Application;

    public function setApplication(Application $application): void;

    public function getUser(): ?User;

    public function setUser(User $user): void;
}
