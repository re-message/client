<?php

namespace RM\Component\Client\Repository;

use RM\Component\Client\Entity\Application;
use RM\Standard\Message\Action;
use RuntimeException;

/**
 * Class ApplicationRepository
 *
 * @package RM\Component\Client\Repository
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class ApplicationRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    final public function get(string $id): Application
    {
        $applications = $this->getAll([$id]);
        return $applications[0];
    }

    /**
     * @inheritDoc
     *
     * @return Application[]
     */
    final public function getAll(array $ids): array
    {
        $action = new Action('apps.get', ['id' => $ids]);
        $response = $this->send($action);

        foreach ($response->getContent() as $data) {
            $application = $this->hydrate($data);
            if (!$application instanceof Application) {
                throw new RuntimeException(sprintf('Hydrated entity is not %s.', Application::class));
            }

            $applications[] = $application;
        }

        return $applications ?? [];
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): string
    {
        return Application::class;
    }
}
