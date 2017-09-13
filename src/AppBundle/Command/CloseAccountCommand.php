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
 * Class CloseAccountCommand
 * @package AppBundle\ConsoleCommand
 */
class CloseAccountCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CloseAccountCommand constructor.
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
            ->setName('account:close')
            ->setDescription('Close user account.')
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

       //asking user for account number
       $accountNumber  =   $io->ask('Please enter your account number', null, function ($number) {
                                if (!is_numeric($number)) {
                                    throw new \RuntimeException('You must type a numeric value.');
                                }

                                return $number;
                            });

       //asking user for mobile number for dual verification
       $mobileNumber  =   $io->ask('Please enter your mobile number', null, function ($number) {
                                if (!is_numeric($number)) {
                                    throw new \RuntimeException('You must type a numeric value.');
                                }

                                return $number;
                            });

       $io->title('Attempting to validate the given account details.');

       //verify the account details
       $accountDetails = $this->em->getRepository('AppBundle:Account')
                ->findOneBy([
                    'accountNumber'    => $accountNumber,
                    'mobileNumber'     => $mobileNumber,
                    'status'           => 1
                ]);

        //if account exists
        if($accountDetails != null) {
             $confirm   =   $io->confirm('Do you really want to close this account?', true);
             if($confirm){
                    $accountDetails->setStatus(0);
                    $this->em->flush();
                    $io->success('Account closed successfully.');  
             }

        }else{

           $io->error('Account either closed or does not exists with the given details. Please cross check your details again.');
        }       

    }
}
