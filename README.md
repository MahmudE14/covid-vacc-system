# COVID Vaccine Registration System

This project is a Laravel-based application designed to allow users to register for vaccination, schedule appointments based on vaccine center availability, and receive notifications. The system optimizes registration using a first-come, first-served strategy and provides a way for users to check their vaccination status.

### Requirements
- PHP 8.1 or higher
- MySQL 8.0
- Docker (optional but **recommended** for setting up the environment quickly)
- Composer
- Node.js & npm

# Installation

## Option 1: Automated Setup Using install.sh
This method uses a shell script to set up everything, including Docker containers, migrations, seeding, and front-end builds. Ensure that Docker is installed and running before proceeding.

### Requirements:
- Docker
- Git

### Steps:
1. Clone the repository:
    ```
    git clone git@github.com:MahmudE14/covid-vacc-system.git
    cd covid-vacc-system
    ```

    `Note` - `log` is set as the default mail driver right now. If you want to use `SMTP`, required settings are also available too as commented out code. Please change according to your need to make it run seamlessly.

2. Make install.sh executable and run:
    ```
    chmod +x install.sh
    ./install.sh
    
    ```
    If you don't want do it this way, or face any issue, try running it this way -
    ```
    bash install.sh
    ```
After the installation is complete, you can access the app at - http://localhost.


## Option 2: Manual Installation
If you prefer to set up the project manually or if the script is not feasible in your environment, follow these steps:

### Requirements:
- Composer
- Node.js and npm

### Steps
1. Open your project directory in terminal.

2. Install dependencies:

    ```
    composer install
    npm install
    ```

3. Make a copy of `.env.example` and rename it to `.env`

4. Make necessary change to `.env` file.

    - Change database related values:
        ```
        DB_CONNECTION
        DB_HOST
        DB_PORT
        DB_DATABASE
        DB_USERNAME
        DB_PASSWORD
        ```

    - And the mail related values, too:
        ```
        MAIL_MAILER
        MAIL_HOST
        MAIL_PORT
        MAIL_USERNAME
        MAIL_PASSWORD
        MAIL_FROM_ADDRESS
        MAIL_FROM_NAME
        ```

5. Generate the Application Key.

    In your terminal, run:
    ```
    php artisan key:generate
    ```
6. Set Up Database

    - Create a new database for the project. Make sure the name matches the one you provided in the .env file under DB_DATABASE.

    - Run Database Migrations

        Run migrations to set up the tables in your database. In the terminal, execute:
        ```
        php artisan migrate
        ```

    -  Seed the Database
        To insert some default data (such as the vaccine centers), run:
        ```
        php artisan db:seed
        ```

7. Install Frontend Dependencies

    - Install Node.js Dependencies
        ```
        npm install
        ```

    - Build Frontend Assets
        ```
        npm run build
        ```

8. Setting Up Background Jobs and Scheduler

    - Start the queue worker:
        ```
        php artisan queue:work --daemon
        ```
    - Start cron/scheduler:
        ```
        php artisan schedule:run >> /dev/null 2>&1
        ```
9. Running the Application

    - Start the Laravel application by running:
        ```
        php artisan serve
        ```
    - Open a browser and navigate to `http://localhost:8000` to access the project

## Notes for Optimization and SMS Integration

If sending SMS notifications in the future is required, we follow the present structure to add the SMS notification feature.

Right now there are jobs which handle the email sending logic (e.g.- `SendVaccinationReminder` and `SendWelcomeEmailJob`). Here `SendVaccinationReminder` runs inside a scheduler task, and the `SendWelcomeEmailJob` is dispatched once an user is registered in the system.

We need to make two more jobs to extend this feature to send SMS - `SendVaccinationReminderSMSJob` and `SendWelcomeSMSJob` inside `app/Jobs` directory.

    - The `SendWelcomeSMSJob` will inside the `ScheduleVaccineAppointment`'s `handle` method right after the `SendWelcomeEmailJob::dispatch($user, $appointment)`.

    - And the `SendVaccinationReminderSMSJob` need to be added in the scheduler. In the `routes/console.php` file, we need to add -
        ```
        Schedule::job(new SendVaccinationReminder)
            ->timezone('Asia/Dhaka')
            ->dailyAt('21:00');
        ```

Good luck! 🙌
