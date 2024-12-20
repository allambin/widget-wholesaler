## Setup Instructions

### 1. Clone the Repository

Start by cloning the repository to your local machine:

```bash
git clone https://github.com/allambin/widget-wholesaler.git
```

Navigate into the project directory:

```bash
cd widget-wholesaler
```

### 2. Install PHP Dependencies

Install the PHP dependencies using Composer:

```bash
composer install
```

This will download and install all required packages listed in the composer.json file.

### 3. Set Up the Environment File

Create a .env file by copying the example provided:

```bash
cp .env.example .env
```

### 4. Generate the Application Key

Generate the application key for Laravel:

```bash
php artisan key:generate
```

This will set the APP_KEY in your .env file.

### 5. Set Up Node.js Version Using nvm

To set the correct version of Node.js as specified in the `.nvmrc` file, use the following command:

```bash
nvm use
```

### 6. Install Node.js Dependencies

Install the frontend dependencies using NPM:

```bash
npm install
```

### 7. Run Database Migrations + Seeder

Run the Laravel database migrations to set up your database tables:

```bash
php artisan migrate
```

Populate the database with initial data by running the seeder:

```bash
php artisan db:seed --class=PackSeeder
```

This will execute the default seeder and populate your database with the necessary test or initial data.

### 8. Serve the Application

After completing the setup, you can serve the application locally:

```bash
php artisan serve
```

This will start the Laravel development server at http://localhost:8000 (check the command line to be sure).

### 9. Run the Frontend

Compile the frontend assets with:

```bash
npm run dev
```

This will start the Vite development server, and the Vue.js components should be live and reactive. The frontend should now be available on your local machine.

### 10. Access the Application

Open your browser and navigate to:

```bash
http://localhost:8000
```

You should now be able to access the application and test the features.