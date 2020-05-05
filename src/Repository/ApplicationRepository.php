<?php

namespace RM\Component\Client\Repository;

use RM\Component\Client\Entity\Application;
use RM\Standard\Message\Action;
use RuntimeException;

/**
 * Class ApplicationRepository
 *
 * @package RM\Component\Client\Repository
 * @author  h1karo <h1karo@outlook.com>
 */
class ApplicationRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    final public function get(string $id): Application
    {
        $action = new Action('applications.get', ['id' => $id]);
        $response = $this->send($action);

        $data = $response->getContent()['application'];
        $application = $this->hydrate($data);
        if (!$application instanceof Application) {
            throw new RuntimeException(sprintf('Hydrated entity is not %s.', Application::class));
        }

        return $application;
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return Application::class;
    }
}
