<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magenerds\SystemDiff\Service\PerformSystemDiffService;

class ExecuteCommand extends Command
{
    /**
     * Holds the command name
     */
    const COMMAND_NAME = 'system-diff:execute';

    /**
     * Holds the command description
     */
    const COMMAND_DESCRIPTION = 'system-diff:execute';

    /**
     * @var PerformSystemDiffService
     */
    private $performSystemDiffService;

    /**
     * ExecuteCommand constructor.
     * @param PerformSystemDiffService $performSystemDiffService
     */
    public function __construct(
        PerformSystemDiffService $performSystemDiffService
    ){
        parent::__construct(self::COMMAND_NAME);
        $this->performSystemDiffService = $performSystemDiffService;
    }

    /**
     * Configures the current command.
     */
    public function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::COMMAND_DESCRIPTION);

        parent::configure();
    }

    /**
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     * @return null|int null or 0 if everything went fine, or an error code
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->performSystemDiffService->performDiff();
        } catch (\Exception $e) {
            $output->writeln(sprintf('An error occurred during diff: %s', $e->getMessage()));
        }
    }
}