<?php

namespace Magenerds\SystemConfigDiff\Console\Command;

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
     * FetchDataCommand constructor.
     *
     * @param FetchLocalDataServiceInterface $fetchLocalDataService
     * @param FetchRemoteDataServiceInterface $fetchRemoteDataService
     */
    public function __construct(
        FetchLocalDataServiceInterface $fetchLocalDataService,
        FetchRemoteDataServiceInterface $fetchRemoteDataService
    ) {
        parent::__construct();

        $this->fetchLocalDataService = $fetchLocalDataService;
        $this->fetchRemoteDataService = $fetchRemoteDataService;
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

        $difference = $this->diffService->diffData($remoteData, $localData);
    }
}
