# COMP351 Term Project

## Installation

### Database Setup

1. **Install MySQL**: Ensure MySQL is installed on your system.
2. **Create Database**: Import the `db.sql` file to create the database schema. Use the MySQL command line or a GUI tool:
   ```
   mysql -u root -p <path_to_db.sql>
   ```
3. **Create MySQL User**: For security, create a MySQL user dedicated to this application:
   - Log in to MySQL as root: `mysql -u root -p`
   - Create a new user: `CREATE USER 'comp351user'@'localhost' IDENTIFIED BY 'password';`
   - Grant privileges: `GRANT ALL PRIVILEGES ON blog_project.* TO 'comp351user'@'localhost';`
   - Flush privileges: `FLUSH PRIVILEGES;`

### Application Setup

1. **Clone Repository**: `git clone https://github.com/devnull03/comp351-term-project.git`
2. **Configure Application**:
   - Navigate to the cloned directory.
   - Update `model/database.php` with the MySQL user credentials created earlier.
3. **Install Dependencies**: If required, install any dependencies mentioned in the repository.

### Running the Application

- Use a PHP server to run the application. From the terminal, you can use:
  ```
  php -S localhost:8000
  ```
- Open your browser and navigate to `http://localhost:8000`.
