<?php

namespace RM\Component\Client\Security\Storage;

use RM\Component\Client\Entity\Application;
use RM\Component\Client\Entity\User;

/**
 * Class ActorStorage
 *
 * @package RM\Component\Client\Security\Storage
 * @author  h1karo <h1karo@outlook.com>
 */
class ActorStorage implements ActorStorageInterface
{
    private ?Application $application = null;
    private ?User $user = null;

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
