<?php
declare(strict_types=1);

namespace Mdg\CliSample\Console;

use Magento\Framework\Exception\FileSystemException;
use Mdg\CliSample\ViewModel\Data;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MdgOnlineCommand extends Command
{
    /**
     * Command cli
     */
    const MDG_ONLINE = "mdg:online";

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
        $this->setName(self::MDG_ONLINE);
        $this->setDescription("Show online users");
        $this->addArgument(
            self::FILE,
            InputOption::VALUE_OPTIONAL,
            'File'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws FileSystemException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $customerCollection = $this->data->getOnlineCustomersCollection();
        if ($input->getArgument(self::FILE)) {
            $this->data->saveInCsv($customerCollection, 'online');
            $output->writeln("<info>Information was saved in - media/export/mdg_online.csv</info>");
        } else {
            $output->write("<info>Online - ");
            foreach ($customerCollection as $customer) {
                $output->write($customer->getFirstname() . "; ");
            }
            $output->writeln("</info>");
        }
    }
}
