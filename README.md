# <img src="https://github.com/user-attachments/assets/e0ccc039-068c-4294-a5f3-79a29f5c1880" width="60" height="60" align="center" /> MyWatchList

**MyWatchList** is a web application that allows users to manage their personal list of favorite movies. The project was created to make it easy to store information about movies, organize them, edit their details, and remove them when needed.

## ⚙️Technologies
### Backend:
- **PHP with Laravel:**
  - MVC (Model-View-Controller) pattern
  - Routing and controllers
  - Authentication and authorization powered by Laravel Breeze

### Frontend:
- **HTML + Tailwind CSS:** Responsive and modern user interface

- **Blade Templates:** HTML templates integrated with the backend

### API:
- **TMDB API:** Search for movies and fetch detailed movie information

## ⭐️Features
### Home Page
- **Search for Movies:** Enter a movie title, and the app will display results from the TMDB API. For each movie, the following details are available:
  - Title
  
- **Add Movies to WatchList:** Movies found in the search results can be added to your WatchList.

### WatchList
- **View Added Movies:** See all the movies you’ve added to your personal list.

- **Add Notes:** Add custom notes to each movie.

- **Edit Movie Details:** Update movie information (title, description, release date, etc.) using a modal with an edit form.

- **Remove Movies:** Delete any movie from your list at any time.

### Movie Details
- **Movie Description:** View detailed information about a selected movie.

- **Edit and Delete Movies:** Modify movie details or remove the movie directly from the details screen.

## Installation
1. Clone the repository:
```bash
git clone https://github.com/AdamDawi/MyWatchList
```
2. Install PHP dependencies:
```bash
composer install
```
3. Configure the `.env` file (TMDB API key, database credentials, etc.).
4. Run database migrations:
```bash
php artisan migrate
```
5. Start the development server:
```bash
php artisan serve
```
6. Open the app in your browser:
http://localhost:8000

## Here are some PC overview pictures:
![Image](https://github.com/user-attachments/assets/0ab974f7-d5a0-4638-b914-ca3c4e9048d3)
![Image](https://github.com/user-attachments/assets/84877531-5eac-4a0d-a5e9-da4c65162606)
![Image](https://github.com/user-attachments/assets/59b64023-d9ad-4ec4-8a58-11e53d8367ce)
![Image](https://github.com/user-attachments/assets/e9072562-7dc7-4390-b89a-407bcb3ec689)
![Image](https://github.com/user-attachments/assets/9bf05122-6d4c-4d84-aab5-1ab69f1727a5)

## Here are some phone overview pictures:
![Image](https://github.com/user-attachments/assets/ac107792-c1c1-4c20-8246-679cb9620181)
![Image](https://github.com/user-attachments/assets/170316b3-4d69-4bb9-b3bf-9f2fbd1bf941)
![Image](https://github.com/user-attachments/assets/5c6702ba-2a54-4955-a6c1-9325c1109fdd)

## Requirements
- PHP 8.1+
- Composer
- MySQL or another compatible database
- TMDB API Key

## Author

Adam Dawidziuk🧑‍💻
