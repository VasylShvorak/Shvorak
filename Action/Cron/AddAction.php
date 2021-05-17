<?php

namespace Shvorak\Action\Cron;

use Shvorak\Action\Model\ActionFactory;
use Shvorak\Action\Model\Config;

class AddAction
{
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var Config
     */
    private $config;

    public function __construct(ActionFactory $actionFactory, Config $config)
    {
        $this->actionFactory = $actionFactory;
        $this->config = $config;
    }

    public function execute()
    {
        if ($this->config->isEnabled()) {
            $this->actionFactory->create()
                ->setName('Cron Action')
                ->setDescription('Created at ' . time())
                ->save();
        }
    }
}
