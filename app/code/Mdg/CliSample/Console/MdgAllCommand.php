<?php
declare(strict_types=1);

namespace Mdg\CliSample\Console;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Mdg\CliSample\Console\MdgBlockedCommand as Blocked;
use Mdg\CliSample\Console\MdgOnlineCommand as Online;
use Mdg\CliSample\Console\MdgRegisteredCommand as Registered;

class MdgAllCommand extends Command
{
    /**
     * Command cli
     */
    const MDG_ALL = "mdg:all";

    /**
     * Save to file option
     */
    const FILE = 'f';

    /**
     * @var MdgBlockedCommand
     */
    public MdgBlockedCommand $blockedCommand;
    /**
     * @var MdgOnlineCommand
     */
    public MdgOnlineCommand $onlineCommand;
    /**
     * @var MdgRegisteredCommand
     */
    public MdgRegisteredCommand $registeredCommand;

    /**
     * @param MdgBlockedCommand $blockedCommand
     * @param MdgOnlineCommand $onlineCommand
     * @param MdgRegisteredCommand $registeredCommand
     * @param string|null $name
     */
    public function __construct(
        Blocked $blockedCommand,
        Online $onlineCommand,
        Registered $registeredCommand,
        string $name = null
    ) {
        $this->blockedCommand = $blockedCommand;
        $this->onlineCommand = $onlineCommand;
        $this->registeredCommand = $registeredCommand;
        parent::__construct($name);
    }

    /**
     * Configure custom cli
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::MDG_ALL);
        $this->setDescription("Show info about users");
        $this->addArgument(
            self::FILE,
            InputOption::VALUE_OPTIONAL,
            'File'
        );

        parent::configure();
    }

    /**
     * Execute the command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $exitCode = 0;

        $this->registeredCommand->execute($input, $output);
        $this->onlineCommand->execute($input, $output);
        $this->blockedCommand->execute($input, $output);

        try {
            if (rand(0, 1)) {
                throw new LocalizedException(__('Random error occurred.'));
            }
        } catch (LocalizedException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            $exitCode = 1;
        }

        return $exitCode;
    }
}
