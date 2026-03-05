# 📚 E-Learning Laravel

A web-based Learning Management System (LMS) built with Laravel 10. This platform is designed to support online teaching and learning with complete features for admins, teachers, and students.

## 🚀 Key Features

### 👨‍💼 Admin
- **User Management**: Manage admin, teacher, and student data
- **Class Management**: Create and manage classes and subjects
- **Data Import/Export**: Import and export student, teacher, class, and subject data via Excel
- **Activity Monitoring**: Track all user activities in the system
- **Survey Management**: Create and manage surveys for feedback

### 👨‍🏫 Teacher
- **Material Management**: Upload and manage learning materials with supporting files (PDF, documents, videos)
- **Assignments**:
  - Create and manage assignments for students
  - Upload supporting assignment files
  - Review and grade student submissions
  - Export assignment scores to Excel
- **Exams**:
  - Create exams with Essay or Multiple Choice types
  - Import exam questions from Excel
  - Configure start time, duration, and passing grade
  - Review and grade student answers
  - Export exam scores to Excel
- **Discussion Forum**: Create discussion topics for student interaction
- **Announcements**: Post announcements for classes
- **Recommendations**: Share additional learning recommendations with supporting files
- **Chat**: Real-time communication with students

### 👨‍🎓 Student
- **Dashboard**: View all activities and pending tasks
- **Material Access**: Read and download learning materials
- **Assignments**:
  - Submit assignments by uploading files
  - View grades and teacher feedback
- **Exams**:
  - Take exams with an automatic timer
  - Supports Essay and Multiple Choice
  - View exam results and scores
- **Discussion Forum**: Read and comment in discussion forums
- **Chat**: Communicate with teachers and other students
- **Survey**: Fill out surveys created by admins
- **Recommendations**: Access recommended materials from teachers

## 🛠️ Technology Stack

### Backend
- **Laravel 10** - PHP Framework
- **PHP 8.1+** - Programming Language
- **MySQL** - Database
- **Laravel Sanctum** - API Authentication
- **Livewire 3.5** - Real-time Components (Chat, Discussion)

### Frontend
- **Blade Templates** - Templating Engine
- **Vite** - Asset Bundling
- **Bootstrap/CSS** - Styling
- **JavaScript/Alpine.js** - Interactivity

### Libraries & Packages
- **Maatwebsite Excel** - Import/Export Excel files
- **Laravel Tinker** - Command-line tool
- **Guzzle HTTP** - HTTP Client
- **Laravel Pint** - Code Style Fixer

## 📋 System Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL >= 5.7 or MariaDB >= 10.3
- Web Server (Apache/Nginx)

## 🔧 Installation

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/E-learning-Laravel.git
cd E-learning-Laravel
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy the .env file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit the `.env` file and adjust the database configuration:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_learning
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Database Migration
```bash
# Run migrations
php artisan migrate

# (Optional) Seed the database with dummy data
php artisan db:seed
```

### 6. Link Storage
```bash
php artisan storage:link
```

### 7. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Run the Application
```bash
# Run the development server
php artisan serve
```

Access the application at `http://localhost:8000`

## 📱 Roles & Access

The system has 3 main roles:

1. **Admin** - Full access to all system features
2. **Teacher** - Access to manage learning activities in assigned classes
3. **Student** - Access to participate in enrolled classes

## 📂 Database Structure

### Main Tables
- `users` - User data (admin, teacher, student)
- `roles` - User roles
- `kelas` - Class data
- `mapels` - Subject data
- `kelas_mapels` - Class-subject relationship
- `data_siswas` - Student detail data
- `materis` - Learning materials
- `materi_files` - Material attachments
- `tugas` - Assignment data
- `tugas_files` - Assignment attachments
- `user_tugas` - Student assignment submissions
- `user_tugas_files` - Student submission files
- `ujians` - Exam data
- `soal_ujian_essays` - Essay exam questions
- `soal_ujian_multiples` - Multiple-choice exam questions
- `user_ujians` - Student exam data
- `user_jawabans` - Student exam answers
- `diskusis` - Discussion topics
- `komentars` - Discussion comments
- `pengumuman` - Announcements
- `rekomendasis` - Material recommendations
- `rekomendasi_files` - Recommendation attachments
- `messages` - Chat messages
- `surveys` - Surveys
- `survey_questions` - Survey questions
- `survey_responses` - Survey responses
- `user_commits` - Activity logs
- `notifications` - System notifications

## 📥 Import/Export

The system supports Excel import/export for:
- Student Data
- Teacher Data
- Class Data
- Subject Data
- Exam Questions (Essay & Multiple Choice)
- Assignment Scores
- Exam Scores

Excel templates for imports can be downloaded from the export menu on each page.

## 🔐 Security

- Authentication using Laravel built-in authentication
- Authorization with custom middleware (admin, teacher)
- Access control policy (UserTugasPolicy)
- CSRF Protection
- Password Hashing
- Sanctum for API authentication

## 🎨 Real-time Features

Using Livewire for real-time features:
- **Chat Component** - Real-time messaging
- **Discussion Component** - Dynamic discussion updates

## 📝 Testing

```bash
# Run tests
php artisan test

# Run tests with coverage
php artisan test --coverage
```

## 🤝 Contributing

1. Fork repository
2. Create a new feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Create a Pull Request

## 📄 License

This project uses the MIT license. See the `LICENSE` file for more details.

## 👥 Development Team

If you want to contribute or have questions, please contact the development team.

## 🐛 Bug Report

If you find a bug or issue, please create an issue in this repository with details:
- Problem description
- Steps to reproduce
- Expected behavior
- Screenshots (if any)
- Environment (PHP version, Laravel version, etc.)



**Built with ❤️ using Laravel**
