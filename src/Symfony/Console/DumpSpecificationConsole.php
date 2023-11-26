<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Console;


use Ferror\AsyncapiDocBundle\DocumentationStrategy\DocumentationStrategyInterface;
use Ferror\AsyncapiDocBundle\GeneratorInterface;
use Ferror\AsyncapiDocBundle\Schema;
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
        private readonly GeneratorInterface $generator,
        private readonly DocumentationStrategyInterface $documentationStrategy,
        private readonly Schema $schema,
    ) {
        parent::__construct('ferror:asyncapi:dump');
        $this->addArgument('class', InputArgument::OPTIONAL, sprintf('Class name. Example %s', UserSignedUp::class));
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getArgument('class')) {
            $document = $this->documentationStrategy->document($input->getArgument('class'));

            $schema = $this->schema->render($document);

            $io->writeln(Yaml::dump($schema, 10, 2));

            return Command::SUCCESS;
        }

        $io->writeln($this->generator->generate());

        return Command::SUCCESS;
    }
}
