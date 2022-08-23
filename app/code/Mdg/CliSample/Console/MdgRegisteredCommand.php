<?php
declare(strict_types=1);

namespace Mdg\CliSample\Console;

use Magento\Framework\Exception\FileSystemException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Mdg\CliSample\ViewModel\Data;

class MdgRegisteredCommand extends Command
{
    /**
     * Command cli
     */
    const MDG_REGISTERED = "mdg:registered";

    /**
     * Save to file option
     */
    const FILE = 'f';

    /**
     * @var Data
     */
    public Data $data;

    /**
     * @param string|null $name
     * @param Data $data
     */
    public function __construct(
        Data $data,
        string $name = null
    ) {
        $this->data = $data;
        parent::__construct($name);
    }

    /**
     * Configure custom cli
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::MDG_REGISTERED);
        $this->setDescription("Show info about users who registered while day");
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
     * @return int|void
     * @throws FileSystemException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $collection = $this->data->getCustomerRegisteredPerDay();
        if ($input->getArgument(self::FILE)) {
            $this->data->saveInCsv($collection, 'registered');
            $output->writeln("<info>Information was saved in - media/export/mdg_registered.csv</info>");
        } else {
            $output->write("<info>Registered - ");
            foreach ($collection as $customer) {
                $output->write($customer->getName() . "; ");
            }
            $output->writeln("</info>");
        }
    }
}
