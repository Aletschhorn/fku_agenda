<?php
namespace FKU\FkuAgenda\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use FKU\FkuAgenda\Domain\Repository\EventRepository;

class SweepCommand extends Command {
	
    /**
     * Configure the command
     */
    protected function configure() {
        $this->setDescription('Deletes events older than a given number of years');
        $this->setHelp('Deletes events older than a given number of years. This helps to keep the database table small.');
		$this->addArgument('years',InputArgument::REQUIRED,'Number of years between the event\'s date and today; if the event is older, it will be deleted.');
    }

    /**
     * Executes the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		$this->eventRepository = $objectManager->get(EventRepository::class);

		$endDate = new \DateTime('-'.intval($input->getArgument('years')).' years');
		$events = $this->eventRepository->findPast($endDate);
		$amount = sizeof($events);
		foreach ($events as $event) {
			$this->eventRepository->remove($event);
		}
		
		$persistenceManager = GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
		$persistenceManager->persistAll();

        $io = new SymfonyStyle($input, $output);
		$io->writeln($amount.' Events deleted');

		return 0;
    }

}