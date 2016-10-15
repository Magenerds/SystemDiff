<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemConfigDiff\Console\Command;

use Magenerds\SystemConfigDiff\Api\Service\DiffDataServiceInterface;
use Magenerds\SystemConfigDiff\Api\Service\FetchLocalDataServiceInterface;
use Magenerds\SystemConfigDiff\Api\Service\FetchRemoteDataServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteCommand extends Command
{
    /**
     * @var FetchLocalDataServiceInterface
     */
    private $fetchLocalDataService;

    /**
     * @var FetchRemoteDataServiceInterface
     */
    private $fetchRemoteDataService;

    /**
     * @var DiffDataServiceInterface
     */
    private $diffDataService;

    /**
     * FetchDataCommand constructor.
     *
     * @param FetchLocalDataServiceInterface $fetchLocalDataService
     * @param FetchRemoteDataServiceInterface $fetchRemoteDataService
     * @param DiffDataServiceInterface $diffDataService
     */
    public function __construct(
        FetchLocalDataServiceInterface $fetchLocalDataService,
        FetchRemoteDataServiceInterface $fetchRemoteDataService,
        DiffDataServiceInterface $diffDataService
    ) {
        parent::__construct();

        $this->fetchLocalDataService = $fetchLocalDataService;
        $this->fetchRemoteDataService = $fetchRemoteDataService;
        $this->diffDataService = $diffDataService;
    }

    /**
     * Configures the current command.
     */
    public function configure()
    {
        $this->setName('config-diff:execute');
        $this->setDescription('config-diff:execute');
    }

    /**
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     * @return null|int null or 0 if everything went fine, or an error code
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $remoteData = $this->fetchRemoteDataService->fetch();
        $localData = $this->fetchLocalDataService->fetch();

        $difference = $this->diffDataService->diffData($remoteData, $localData);

        $output->writeln(var_export($difference, true));
    }
}
