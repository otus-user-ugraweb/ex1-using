<?php

namespace user\ex1\using\Commands;

use InvalidArgumentException;
use otus\user\ugraweb\ex1\ValidatorSequence;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExecuteAppCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:valid')
            ->addArgument('path', InputArgument::OPTIONAL, 'path to file')
            ->setDescription('validation sequence');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pathToFile = $input->getArgument('path');
        if ($pathToFile == null) $pathToFile = $this->askQuestion($input, $output);
        $content = file_get_contents($pathToFile);
        $result = $this->checkSequence($content);
        $output->writeln("Path: $pathToFile");
        $output->writeln("Sequence: $content");
        $output->writeln("Result: $result");
    }

    private function checkSequence($content)
    {
        try {
            $object = new ValidatorSequence($content);
        } catch (InvalidArgumentException $exception) {
            return "error - sequence is not a valid sequence";
        }
        if ($object->checkSequence()) {
            return "true";
        } else return "false";
    }

    private function askQuestion($input, $output)
    {
        $question = new Question(
            "Please enter path to file",
            false
        );
        $io = new SymfonyStyle($input, $output);
        $pathToFile = false;
        while ($pathToFile == false) {
            $userInput = $io->askQuestion($question);
            $pathToFile = $userInput ? $userInput : false;
        }
        return $pathToFile;
    }


}