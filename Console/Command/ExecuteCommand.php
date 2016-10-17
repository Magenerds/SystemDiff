<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Console\Command;

use Magenerds\SystemDiff\Api\Service\DiffDataServiceInterface;
use Magenerds\SystemDiff\Api\Service\FetchLocalDataServiceInterface;
use Magenerds\SystemDiff\Api\Service\FetchRemoteDataServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ExecuteCommand extends Command
{
    /**
     * Dry run argument
     */
    const DRY_RUN = 'dry-run';

    /**
     * Name argument
     */
    const NAME_ARGUMENT = 'name';

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
        $this->setName('system-diff:execute');
        $this->setDescription('system-diff:execute');
        $this->setDefinition([
            new InputOption(
                self::DRY_RUN,
                '--dry-run',
                InputOption::VALUE_NONE,
                'Dry run'
            )
        ]);

        parent::configure();
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

        if ($input->getOption(self::DRY_RUN)) {
            $output->writeln(var_export($difference, true));
        }
    }
}
