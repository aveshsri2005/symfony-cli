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
 * Class DisplayBalanceCommand
 * @package AppBundle\ConsoleCommand
 */
class DisplayBalanceCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DisplayBalanceCommand constructor.
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
            ->setName('display:balance')
            ->setDescription('Withdraw fund from the user account.')
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
       $io = new SymfonyStyle($input, $output);    
      
       //asking for account number
       $accountNumber  =   $io->ask('Please enter your account number', null, function ($number) {
                                if (!is_numeric($number)) {
                                    throw new \RuntimeException('You must type a numeric value.');
                                }

                                return $number;
                            });

       //asking for mobile number for dual verification
       $mobileNumber  =   $io->ask('Please enter your mobile number', null, function ($number) {
                                if (!is_numeric($number)) {
                                    throw new \RuntimeException('You must type a numeric value.');
                                }

                                return $number;
                            });

       //$io->title('Attempting to validate the given account details.');

       //Verifying the account details
       $accountId = $this->em->getRepository('AppBundle:Account')
                          ->validateAccountDetails($accountNumber, $mobileNumber);

        if($accountId != null) {  
                //get last 5 transactions
                $statement = $this->em->getRepository('AppBundle:Transaction')
                                    ->getLastFiveTransactions($accountId);   

                if(!empty($statement)){

                        $io->title('Last five transactions in descending order');

                        $io->table(
                                    array('S.no', 'Credit', 'Debit', 'Balance'),                        
                                    $statement                        
                                ); 

                        $io->newLine(1);                   
                }                    

                //get account last balance amount
                $availableBalance = $this->em->getRepository('AppBundle:Transaction')
                                    ->getAccountBalance($accountId);

                $io->success('Your current account balance is: HK$'. $availableBalance);

        }else{

           $io->error('Account does not exists with the given details. Please cross check your details again.');
        }       

    }
}
