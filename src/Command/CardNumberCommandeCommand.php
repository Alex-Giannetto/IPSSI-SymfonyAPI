<?php

namespace App\Command;

use App\Manager\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CardNumberCommandeCommand extends Command
{
    protected static $defaultName = 'app:CardNumberCommande';
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Return the number of card of an user')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of the user :')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        $user = $this->userManager->getUserByEmail($email);
        if($user !== null){
            $io->success('This user have ' . count($user->getCards()) . ' card(s)');
        } else {
            $io->error('This User doesn\'t exist');
        }
    }
}
