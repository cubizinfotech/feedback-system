# Feedback System for C2C Restoration

A comprehensive feedback management system designed for C2C Restoration company to collect, manage, and analyze customer feedback.

## Purpose

This application serves as a centralized platform for:
- Collecting customer feedback through email requests
- Managing customer feedback submissions
- Analyzing feedback ratings and comments
- Tracking customer interactions and feedback history
- Sending automated feedback request emails to customers

## Features

- **Customer Management**
  - Add and manage customer information
  - Track customer feedback history
  - Send feedback request emails to customers

- **Feedback Collection**
  - 5-star rating system
  - Detailed feedback message collection
  - Automated email notifications for new feedback

- **Dashboard Analytics**
  - View total customers and feedback count
  - Track total emails sent
  - Visual representation of rating distribution
  - Recent feedback display

- **Feedback Management**
  - View all customer feedbacks
  - Filter and search feedbacks
  - Detailed feedback information display

## Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM (for frontend assets)
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/cubizinfotech/feedback-system.git
cd feedback-system
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install frontend dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=feedback_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Compile frontend assets:
```bash
npm run dev
```

9. Start the development server:
```bash
php artisan serve
```

## Configuration

1. Configure your mail settings in `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=your_smtp_port
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

2. Set up the following environment variables:
```
REVIEW_URL=your_google_review_url
SUPPORT_EMAIL=your_support_email
```

## Usage

1. Access the dashboard at `http://localhost:8000`
2. Add customers through the customer management interface
3. Send feedback request emails to customers
4. View and manage feedback submissions
5. Monitor feedback analytics through the dashboard

## Security

- All routes except feedback submission are protected by authentication
- CSRF protection enabled for all forms
- Input validation for all user submissions
- Secure password hashing
- Environment-based configuration

## Support

For support, please contact the development team or raise an issue in the repository.
