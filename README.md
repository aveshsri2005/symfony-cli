#Bank Application in Symfony CLI


Application Setup
===================

Step 1: Install symfony console and other dependencies

        ➜  composer install


Step 2: Update database credentials in parameters.yml

        ➜  File Path : bankprojectnew/app/config/parameters.yml

	    database_host: localhost
	    database_port: null
	    database_name: bank_project
	    database_user: root
	    database_password: root

Step 3: Now to create a database with the name of bank_project.

        ➜  php bin/console doctrine:database:create

Step 4: Create the database schema based on defined entities.

        ➜  php bin/console doctrine:schema:create



Application Commands
=====================

[**Open account**] :- For opening a new account following details are required

         * Full Name 
         * Date of birth
         * mobile number (Mobile number should be unique)

        ➜ php bin/console account:open 'Avesh Srivastava' '08/27/1980' '9999399629' 

 On successful account creation, user will get a unique account number which will be required for any further transactions.


[**Deposit funds**] :- To deposit an amount into the user's account, following inputs are required

         * Account Number 
         * Mobile Number
         * Amount

        ➜ php bin/console fund:deposit 1001 9999399528 2000


[**Withdraw funds**] :- To withdrawal an amount from the user's account, following inputs are required

         * Account Number 
         * Mobile Number
         * Amount

        ➜ php bin/console fund:withdrawal

            * System will ask you to enter the account number
            * System will ask you to enter the mobile number (for dual verification)
            * System will ask you to the amount which you want to withdrawal
            * System will display the account balance after successful withdrawal.
            

[**Display balance**] :- To display the user's account balance, following inputs are required

         * Account Number 
         * Mobile Number

        ➜ php bin/console display:balance

            * System will ask you to enter the account number
            * System will ask you to enter the mobile number (for dual verification)
            * System will show you the account balance if given inputs were correct.


[**Close account**] :- In order to close any existing account, following inputs are required

         * Account Number 
         * Mobile Number

        ➜ php bin/console account:close

            * System will ask you to enter the account number
            * System will ask you to enter the mobile number (for dual verification)
            * If given inputs were correct, System will give you a prompt to confirm your action
            * After confirmation system will close the account.


[**overdraft facility**] :- Default overdraft limit given to every account is HK$ 20000. 



