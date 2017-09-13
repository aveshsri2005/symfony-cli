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
 * Class DepositFundCommand
 * @package AppBundle\ConsoleCommand
 */
class DepositFundCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DepositFundCommand constructor.
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
            ->setName('fund:deposit')
            ->setDescription('Deposit fund in the user account.')
            ->addArgument('accountNumber', InputArgument::REQUIRED, 'Enter your account number')
            ->addArgument('mobileNumber', InputArgument::REQUIRED, 'Enter your mobile number')
            ->addArgument('creditAmount', InputArgument::REQUIRED, 'Enter the amount you want to deposit')
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
        $accountNumber          = $input->getArgument('accountNumber');
        $mobileNumber           = $input->getArgument('mobileNumber');
        $creditAmount           = floatval($input->getArgument('creditAmount'));

        $io = new SymfonyStyle($input, $output);
        $io->title('Attempting to validate the given account details.');

        //Verifying the account details
        $accountId = $this->em->getRepository('AppBundle:Account')
                          ->validateAccountDetails($accountNumber, $mobileNumber);

        //if account exists
        if($accountId != null) {

            //get account last balance amount
            $balanceAmount = $this->em->getRepository('AppBundle:Transaction')
                                    ->getAccountBalance($accountId);

            //Calculate account balance after deposit   
            $availableBalance =  $balanceAmount+$creditAmount;

            //save new transaction
            $transaction = (new Transaction())
                ->setAccountId($accountId)
                ->setCreditAmount($creditAmount)
                ->setDebitAmount(0.00)
                ->setBalanceAmount($availableBalance)
            ;

            $this->em->persist($transaction);
            $this->em->flush();

            $io->success('Amount credited successfully. Your current account balance is: HK$'. $availableBalance);  

        }
        else
        {           
             $io->error('Account either closed or does not exists with the given details. Please cross check your details again.');
        }       

    }
}
