<?php
declare(strict_types=1);

namespace App\Traits;

use Cake\Event\EventInterface;

trait InertiaResponseTrait
{
    /**
     * @inheritDoc
     */
    public function beforeRender(EventInterface $event)
    {
        if ($this->isErrorStatus() || $this->isFailureStatus()) {
            return null;
        }

        $this->setViewBuilderClass();
    }

    /**
     * Sets view class depending on detector.
     *
     * @return void
     */
    private function setViewBuilderClass(): void
    {
        $viewClass = 'InertiaWeb';

        $this->viewBuilder()->setClassName("{$viewClass}");
    }

    /**
     * Checks if response status code is 404.
     *
     * @return bool Returns true if response is error, false otherwise.
     */
    private function isErrorStatus(): bool
    {
        $statusCode = $this->getResponse()->getStatusCode();
        $errorCodes = [404];

        if (in_array($statusCode, $errorCodes)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if response status code is 500.
     *
     * @return bool Returns true if response is failure, false otherwise.
     */
    private function isFailureStatus(): bool
    {
        $statusCode = $this->getResponse()->getStatusCode();
        $failureCodes = [500];

        if (in_array($statusCode, $failureCodes)) {
            return true;
        }

        return false;
    }
}
