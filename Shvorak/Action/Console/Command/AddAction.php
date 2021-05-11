<?php


namespace Shvorak\Action\Console\Command;


use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Shvorak\Action\Model\ActionFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddAction extends Command
{

    const INPUT_KEY_NAME = 'name';
    const INPUT_KEY_DESCRIPTION = 'description';

    /**
     * @var ActionFactory
     */
    private $actionFactory;

    public function __construct(ActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('shvorak:action:add')
            ->addArgument(
                self::INPUT_KEY_NAME,
                InputArgument::REQUIRED,
                'Action name'
            )->addArgument(
                self::INPUT_KEY_DESCRIPTION,
                InputArgument::OPTIONAL,
                'Action Description'
            );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $action = $this->actionFactory->create();
        $action->setName($input->getArgument(self::INPUT_KEY_NAME));
        $action->setDescription($input->getArgument(self::INPUT_KEY_DESCRIPTION));
        $action->save();
        return Cli::RETURN_SUCCESS;
    }
}
