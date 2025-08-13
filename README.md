# Laravel Task Manager

A comprehensive task management web application built with Laravel that allows users to create, manage, and organize their personal tasks with advanced features like soft deletion, filtering, and user authentication.

## 🚀 Features

### Authentication System
- *User Registration*: Create new accounts with name, email, and password
- *User Login*: Secure login with email and password
- *Seamless Toggle*: Easy navigation between login and signup forms done using bootstrap
- *Session Management*: Secure logout functionality
- *Password Security*: All passwords are hashed and stored securely

### Custom Welcome Page
- *Call-to-Action Buttons*: Clear navigation to login or signup
- *Responsive Design*: Mobile-friendly layout using Bootstrap 5

### Task Management System
- *Create Tasks*: Add new tasks with title, description, and due date
- *View All Tasks*: Display all your personal tasks in an organized list
- *Update Tasks*: Edit task details, descriptions, due dates, and completion status
- *Mark Complete/Pending*: Toggle task completion status
- *Delete Tasks*: Soft delete tasks (move to trash)

### Advanced Task Features
- *Smart Filtering*: Filter tasks by status (All Tasks, Completed Only, Pending Only)
- *Due Date Management*: Set and display due dates for better planning
- *Timestamps*: Track when tasks were created and last updated

### Trash & Recovery System
- *Recently Deleted View*: Separate page for managing deleted tasks
- *Restore Functionality*: Recover accidentally deleted tasks
- *30-Day Auto-Deletion*: Tasks are permanently removed after 30 days in trash
- *Permanent Delete Option*: Immediately and permanently remove tasks
- *Deletion Warnings*: Clear warnings before permanent deletion


## 🛠 Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL or another supported database
- Node.js and npm (optional, for asset compilation)

### Installation Steps

1. *Clone the repository*
   
bash
   git clone <repository-url>
   cd laravel-task-manager


2. *Install dependencies*
   
bash
   composer install

3. *Create Create environment file*
   bash
   cp .env.example .env

4. *Generate App Key*
    php artisan key:generate
   
5. *Run migrations*
   
bash
   php artisan migrate

6. *Seed the database*
   
bash
   php artisan db:seed


7. *Start the development server*
   
bash
   php artisan serve


8. *Access the application*
   
Visit: http://localhost:8000


## 👥 Demo Users

The application comes with pre-seeded demo users for testing:

### User 1
- *Email*: test1@example.com
- *Password*: 123456
- *Tasks*: 10 randomly generated tasks with various statuses

### User 2
- *Email*: test2@example.com
- *Password*: 123456
- *Tasks*: 10 randomly generated tasks with various statuses

Each demo user has their own set of tasks with:
- Random titles and descriptions
- Mixed completion statuses (completed/pending)
- Various creation dates for realistic testing

## 🎯 Usage Guide

### Getting Started
1. Visit the welcome page at http://localhost:8000
2. Click "Login" or "Sign Up" to access the application
3. Use demo credentials or create a new account

### Managing Tasks
1. *Creating Tasks*:
   - Click "Add New Task" button
   - Fill in title, description (optional), and due date (optional) (notice: you can't create a date that has already passed will give error)
   - Submit to create your task

2. *Viewing Tasks*:
   - All tasks are displayed on the main tasks page
   - Use the filter dropdown to view specific task types
   - Clear filters to see all tasks again

3. *Editing Tasks*:
   - Click the pencil icon next to any task
   - Modify details and completion status
   - Save changes

4. *Deleting Tasks*:
   - Click the trash icon next to any task
   - Confirm deletion in the modal dialog
   - Task moves to "Recently Deleted"

### Trash Management
1. *Accessing Trash*:
   - Click "Recently Deleted" in the navigation
   - View all deleted tasks with deletion timestamps

2. *Restoring Tasks*:
   - Click "Restore" button next to any deleted task
   - Task returns to your active task list

3. *Permanent Deletion*:
   - Click "Delete Forever" for immediate permanent removal
   - Or wait 30 days for automatic permanent deletion
