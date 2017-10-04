<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Console\Command;

use Magenerds\SystemDiff\Helper\Config;
use Magento\Framework\App\Config\MutableScopeConfigInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
     * Exit code when exception occurred
     */
    const EXIT_CODE_EXCEPTION = 4;

    /**
     * Command options
     */
    const OPTION_REMOTE_SYSTEM_URL = 'remote-system-url';
    const OPTION_API_TYPE = 'api-type';
    const OPTION_ACCESS_TOKEN = 'access-token';

    /**
     * @var PerformSystemDiffService
     */
    private $performSystemDiffService;

    /**
     * @var Config
     */
    private $configHelper;

    /**
     * @var MutableScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * ExecuteCommand constructor.
     *
     * @param PerformSystemDiffService    $performSystemDiffService
     * @param MutableScopeConfigInterface $scopeConfig
     * @param Config                      $configHelper
     */
    public function __construct(
        PerformSystemDiffService $performSystemDiffService,
        MutableScopeConfigInterface $scopeConfig,
        Config $configHelper
    ) {
        parent::__construct(self::COMMAND_NAME);

        $this->performSystemDiffService = $performSystemDiffService;
        $this->scopeConfig = $scopeConfig;
        $this->configHelper = $configHelper;
    }

    /**
     * Configures the current command.
     *
     * @return void
     */
    public function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::COMMAND_DESCRIPTION);

        $this->addOption(self::OPTION_API_TYPE, 'a', InputOption::VALUE_OPTIONAL, 'Overwrite configured api type');
        $this->addOption(self::OPTION_REMOTE_SYSTEM_URL, 'u', InputOption::VALUE_OPTIONAL,
            'Overwrite configured remote url');
        $this->addOption(self::OPTION_ACCESS_TOKEN, 't', InputOption::VALUE_OPTIONAL,
            'Overwrite configured access token');

        parent::configure();
    }

    /**
     * Perform system diff via service.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $exitStatus = 0;

        if ($url = $input->getOption(self::OPTION_REMOTE_SYSTEM_URL)) {
            $this->scopeConfig->setValue(Config::XML_PATH_REMOTE_SYSTEM_URL, $url);
        }
        if ($api = $input->getOption(self::OPTION_API_TYPE)) {
            $this->scopeConfig->setValue(Config::XML_PATH_API_TYPE, $api);
        }
        if ($token = $input->getOption(self::OPTION_ACCESS_TOKEN)) {
            $this->scopeConfig->setValue(Config::XML_PATH_ACCESS_TOKEN, $token);
        }

        try {
            $output->write('Performing sync and diff...');
            $this->performSystemDiffService->performDiff();
            $output->writeln(
                sprintf(
                    'Done at %s.',
                    $this->configHelper->getLastSyncDatetimeFormatted()
                )
            );
        } catch (\Exception $e) {
            $exitStatus = self::EXIT_CODE_EXCEPTION;
            $output->writeln(sprintf('An error occurred during diff: %s', $e->getMessage()));
        }

        return $exitStatus;
    }
}