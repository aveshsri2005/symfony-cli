<?php

namespace AppBundle\Command;

use AppBundle\Entity\Account;
use AppBundle\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CsvImportCommand
 * @package AppBundle\ConsoleCommand
 */
class OpenAccountCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CsvImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    /**
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('account:open')
            ->setDescription('Create an user account with given details.')
            ->addArgument('fullName', InputArgument::REQUIRED, 'Enter your full name')
            ->addArgument('dob', InputArgument::REQUIRED, 'Enter you date of birth')
            ->addArgument('mobileNumber', InputArgument::REQUIRED, 'Enter you mobile number')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io                = new SymfonyStyle($input, $output);
        $fullName          = $input->getArgument('fullName');
        $dob               = $input->getArgument('dob');
        $mobileNumber      = $input->getArgument('mobileNumber');  
        $maxAccountNumber  = 1000;


        $io->title('Attempting to create a new bank account');

        //validate mobile number 
        $accounts = $this->em->getRepository('AppBundle:Account')
                    ->findOneBy(['mobileNumber'=>$mobileNumber]);

        if($accounts!=null) {
             throw new \RuntimeException('Mobile number already exists.');
        }       

        //get the last record of the Account table
        $accounts = $this->em->getRepository('AppBundle:Account')
                    ->findOneBy([],['id'=>'desc']);
      
        //Get the last account number of the Account table
        if ($accounts != null) {
            $maxAccountNumber  = intval($accounts->getAccountNumber());            
        }  
       
        //generate new account number
        $newAccountNumber  = $maxAccountNumber+1;      
        
        //create new account
        $account = (new Account())
                ->setFullName($fullName)
                ->setDob(new \DateTime($dob))
                ->setMobileNumber($mobileNumber)
                ->setStatus(1)
                ->setAccountNumber($newAccountNumber)
            ;

        $this->em->persist($account);
        $this->em->flush();
        $io->success('A new account has been created with account number: '.$newAccountNumber);
    }
}
