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
 * Class WithdrawFundCommand
 * @package AppBundle\ConsoleCommand
 */
class WithdrawFundCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * WithdrawFundCommand constructor.
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
            ->setName('fund:withdrawal')
            ->setDescription('withdrawal fund from the user account.')
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

        $io->title('Attempting to validate the given account details.');

        //Verifying the account details
        $accountId = $this->em->getRepository('AppBundle:Account')
                          ->validateAccountDetails($accountNumber, $mobileNumber);

        //if account exists
        if($accountId != null) {
                 
                //prompt for withdrawal amount   
                $withdrawalAmount  =   $io->ask('Please enter the amount you want to withdrawal', null,                function ($number) {
                                       if (!(is_float($number) || is_numeric($number)) || floatval($number)<=0 ) {
                                            throw new \RuntimeException('You must type either a decimal or numeric value.');
                                        }
                                        return $number;
                                    });
               
                //get account last balance amount
                $balanceAmount = $this->em->getRepository('AppBundle:Transaction')
                                    ->getAccountBalance($accountId);
             

                //calculate amount difference
                 $ammountDiff  = floatval($balanceAmount) - floatval($withdrawalAmount);

                //if account balance amount is less than requeted withdrawal Amount
                if($ammountDiff < -20000){

                    $io->warning('You cannot withdrawal beyond your overdraft limit.');
                    
                }else{
                        //create new account
                        $transaction = (new Transaction())
                            ->setAccountId($accountId)
                            ->setDebitAmount($withdrawalAmount)
                            ->setCreditAmount(0.00)
                            ->setBalanceAmount($ammountDiff)
                        ;

                        $this->em->persist($transaction);
                        $this->em->flush();

                        $io->success('Amount debited successfully. Your current account balance is: HK$'. $ammountDiff);
                }

        }else{

           $io->error('Account either closed or does not exists with the given details. Please cross check your details again.');
        }       

    }
}
