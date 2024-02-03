<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Console;

use Ferror\AsyncapiDocBundle\DataFormat;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\DocumentationStrategyInterface;
use Ferror\AsyncapiDocBundle\Generator\GeneratorFactory;
use Ferror\AsyncapiDocBundle\Schema\V2\MessageRenderer;
use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

class DumpSpecificationConsole extends Command
{
    public function __construct(
        private readonly GeneratorFactory $generatorFactory,
        private readonly DocumentationStrategyInterface $documentationStrategy,
        private readonly MessageRenderer $messageRenderer,
    ) {
        parent::__construct('ferror:asyncapi:dump');
        $this->addArgument('class', InputArgument::OPTIONAL, sprintf('Class name. Example %s', UserSignedUp::class));
        $this->addArgument('format', InputArgument::OPTIONAL, 'Data format. Example json or yaml', 'yaml');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getArgument('class')) {
            $document = $this->documentationStrategy->document($input->getArgument('class'));

            $schema = $this->messageRenderer->render($document->toArray());

            $io->writeln(Yaml::dump($schema, 10, 2));

            return Command::SUCCESS;
        }

        $generator = $this->generatorFactory->create(DataFormat::from($input->getArgument('format')));

        $io->writeln($generator->generate());

        return Command::SUCCESS;
    }
}
