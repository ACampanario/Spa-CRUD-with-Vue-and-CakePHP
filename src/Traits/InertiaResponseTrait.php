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

        $session = $this->getRequest()->getSession();
        $flash = [];
        if ($session->check('Flash.flash.0')) {
            $flash = $session->read('Flash.flash.0');
            $flash['element'] = strtolower(str_replace('/', '-', $flash['element']));
            $session->delete('Flash');
        }
        $this->set('flash', $flash);

        //set csrf token
        $this->set('token', $this->getRequest()->getAttribute('csrfToken'));
    }

    /**
     * Sets view class
     *
     * @return void
     */
    private function setViewBuilderClass(): void
    {
        $viewClass = 'Inertia';
        if ($this->getRequest()->is('inertia')) {
            $viewClass = 'InertiaJson';
        }
        $this->viewBuilder()->setClassName("{$viewClass}");
    }

    /**
     * Checks if response status code is 404.
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
