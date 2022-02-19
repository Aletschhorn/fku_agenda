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

class IcalCommand extends Command {
	
    /**
     * Configure the command
     */
    protected function configure() {
        $this->setDescription('Creates an .ics file of all events of a certain event category and visibility category');
        $this->setHelp('Creates an .ics file of all events of a certain event category and visibility category. Set parameter updateIntervalHours=0 to create the file anyway or to any integer to only update the file if changes were made in the last xx hours.');
		$this->addArgument('filePathAndName',InputArgument::REQUIRED,'Complete path and file name of .ics file, relative to TYPO3 installation path, e.g. fileadmin/calendar/cal.ics');
		$this->addArgument('updateIntervalHours', InputArgument::REQUIRED, 'Number of hours back a change in the events shall still provoke the update of the .ics file; set to 0 to create the file anyway');
		$this->addArgument('visible', InputArgument::REQUIRED, 'Comma-separated list of visibility table uids that shall be displayed');
		$this->addArgument('categories', InputArgument::OPTIONAL, 'Comma-separated list of event category table uids that shall be displayed; set to 0 or leave blank to include all event categories');
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

        $io = new SymfonyStyle($input, $output);
		$updateIntervalHours = intval($input->getArgument('updateIntervalHours'));
		$categories = $input->getArgument('categories');
		$this->visible = explode(',',$input->getArgument('visible'));

		$this->start = strtotime('-6 months');
		if ($categories == NULL or $categories == "" or $categories == "0") {
			$this->categoriesAll = true;
			$this->categoriesArray = [];
		} else {
			$this->categoriesAll = false;
			$this->categoriesArray = explode(',',$categories);
		}

		// get content of .ics file (if needed)
		if ($updateIntervalHours > 0) {
			$updatedEvents = $this->eventRepository->findByUpdate($this->start, $updateIntervalHours, $this->visible, $this->categoriesAll, $this->categoriesArray);
			if ($updatedEvents->count() > 0) {
				$fileContent = $this->createFileContent();
			}
		} else {
			$fileContent = $this->createFileContent();
		}

		// write file if content exists
		if ($fileContent) {
			$absoluteFilePathAndName = Environment::getPublicPath() . '/' . $input->getArgument('filePathAndName');
			$filesystem = new Filesystem();
			$filesystem->dumpFile($absoluteFilePathAndName, $fileContent);
	        $io->writeln('Ical file has been created.');
		} else {
	        $io->writeln('No Ical file written.');
		}
		return 0;
    }

	/**
	 * 
	 * @param \string $visible Comma-separated list of visibility table uids that shall be displayed
 	 * @param \string $categories Comma-separated list of event category table uids that shall be displayed
	 *
	 * @return \string
	 */
	protected function createFileContent () {
		
		// get events from database
		$events = $this->eventRepository->findFuture($this->start, $this->visible, $this->categoriesAll, $this->categoriesArray);
				
		// write file content
		$fileContent = "";
		if ($events->count() > 0) {
			foreach ($events as $event) {
				$fileContent .= "BEGIN:VEVENT\r\n";
				$fileContent .= "UID:".$event->getUid()."@fku.ch\r\n";

				// format date and time information
				if ($event->getAllDay()) {
					// register dates without times
					$dtstart = ";VALUE=DATE:".$event->getEventStart()->format('Ymd');
					if ($event->getEventEnd()) {
						$dtend = ";VALUE=DATE:".date('Ymd', strtotime('+1 days',$event->getEventEnd()->getTimestamp()));
					} else {
						$dtend = $dtstart;
					}
				} else {
					// register dates and times
					$dtstart = ";TZID=Europe/Berlin:".$event->getEventStart()->format('Ymd\THis');
					if ($event->getEventEnd() and $event->getEventStart() != $event->getEventEnd()) {
						$dtend = ";TZID=Europe/Berlin:".$event->getEventEnd()->format('Ymd\THis');
					} elseif ($event->getCategory()->getDuration() > 0) {
						$duration = $event->getCategory()->getDuration();
						$end = strtotime('+'.$duration.' minutes',$event->getEventStart()->format('U'));
						$dtend = ";TZID=Europe/Berlin:".date('Ymd\THis',$end);
					} else {
						$dtend = $dtstart;
					}
				}
				$fileContent .= "DTSTART".$dtstart."\r\n";
				$fileContent .= "DTEND".$dtend."\r\n";
				
				// Event description
				$description = $event->getDescription();
				$fileContent .= "SUMMARY:".self::escapeText($event->getDescriptionFirstLine())."\r\n";
                if ($event->getDescriptionRest()) {
					$fileContent .= "DESCRIPTION:".self::escapeText($event->getDescriptionRest())."\r\n";
				}
				$fileContent .= "DTSTAMP:".$event->getCrdate()->format('Ymd\THis\Z')."\r\n";
				$fileContent .= "CREATED:".$event->getCrdate()->format('Ymd\THis\Z')."\r\n";
				$fileContent .= "LAST-MODIFIED:".$event->getTstamp()->format('Ymd\THis\Z')."\r\n";
				$fileContent .= "END:VEVENT\r\n";
			}
			
			// create and return complete file content
			return self::getFileHeader() . $fileContent . self::getFileFooter();

		} else {
			return false;
		}
	}

	/**
	 * escapeText
	 *
	 * @var \string $text
	 * @return \string
	 */
	protected function escapeText($text) {
		$text = str_replace("\r\n", "\\n", $text);
		$text = str_replace(",", "\,", $text);
		$text = str_replace(";", "\;", $text);
		return $text;
	}
	
	/**
	 * getFileHeader
	 *
	 * @return \string
	 */
	protected static function getFileHeader () {
		$fileHeader = "";
		$fileHeader .= "BEGIN:VCALENDAR\r\n";
		$fileHeader .= "VERSION:2.0\r\n";
		$fileHeader .= "PRODID:-//FKU//Freie Kirche Uster 1.0//DE\r\n";
		$fileHeader .= "CALSCALE:GREGORIAN\r\n";
		$fileHeader .= "METHOD:PUBLISH\r\n";
		$fileHeader .= "X-WR-CALNAME:Freie Kirche Uster\r\n";
		$fileHeader .= "X-WR-TIMEZONE:Europe/Zurich\r\n";
		$fileHeader .= "BEGIN:VTIMEZONE\r\n";
		$fileHeader .= "TZID:Europe/Berlin\r\n";
		$fileHeader .= "X-LIC-LOCATION:Europe/Berlin\r\n";
		$fileHeader .= "BEGIN:DAYLIGHT\r\n";
		$fileHeader .= "TZOFFSETFROM:+0100\r\n";
		$fileHeader .= "TZOFFSETTO:+0200\r\n";
		$fileHeader .= "TZNAME:CEST\r\n";
		$fileHeader .= "DTSTART:19700329T020000\r\n";
		$fileHeader .= "RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU\r\n";
		$fileHeader .= "END:DAYLIGHT\r\n";
		$fileHeader .= "BEGIN:STANDARD\r\n";
		$fileHeader .= "TZOFFSETFROM:+0200\r\n";
		$fileHeader .= "TZOFFSETTO:+0100\r\n";
		$fileHeader .= "TZNAME:CET\r\n";
		$fileHeader .= "DTSTART:19701025T030000\r\n";
		$fileHeader .= "RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU\r\n";
		$fileHeader .= "END:STANDARD\r\n";
		$fileHeader .= "END:VTIMEZONE\r\n";
		return $fileHeader;
	}
		
	/**
	 * getFileFooter
	 *
	 * @return \string
	 */
	protected static function getFileFooter () {
		return "END:VCALENDAR\r\n";
	}

}