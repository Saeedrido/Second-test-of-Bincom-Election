# INEC Election Results Dashboard

A modern, production-quality election results dashboard built for the Bincom PHP/MySQL Developer Technical Interview Assessment. This application provides real-time polling unit results, LGA aggregation, and new result entry capabilities.

## Features

- **Dashboard Overview**: Real-time statistics, top performing parties, and recent activity
- **Polling Unit Results**: Search and view detailed results for individual polling units
- **LGA Aggregated Results**: Dynamic aggregation of results across all polling units in an LGA
- **New Result Entry**: Form with chained dropdowns for entering new polling unit results
- **PDF Export**: Print-friendly HTML views for downloading reports (use browser's Print → Save as PDF)
- **Dark Mode**: Full dark mode support with smooth transitions
- **Responsive Design**: Mobile-first design that works on all screen sizes
- **Print Support**: Optimized print styles for physical reports

## Technology Stack

- **Backend**: Laravel 12, PHP 8.3
- **Database**: MySQL 8.0+
- **Frontend**: Blade Templates, TailwindCSS 3.4 (CDN), Alpine.js 3.x
- **Build Tools**: Vite 6.x
- **Icons**: Lucide Icons

## Architecture

### SOLID Principles

The application follows SOLID principles throughout:

- **Single Responsibility**: Each class has a single, well-defined purpose
- **Open/Closed**: Extensible through interfaces without modifying existing code
- **Liskov Substitution**: Eloquent models can be substituted without affecting functionality
- **Interface Segregation**: Repository and Service interfaces are focused
- **Dependency Inversion**: Controllers depend on abstractions (services/repositories), not concretions

### Design Patterns

1. **Repository Pattern**: All database access is encapsulated in repository classes
   - `PollingUnitRepository`: Polling unit CRUD and search
   - `LgaRepository`: LGA data access
   - `WardRepository`: Ward data access
   - `ElectionResultRepository`: Results aggregation and storage
   - `PartyRepository`: Party data access
   - `StateRepository`: State data access

2. **Service Layer**: Business logic is separated into service classes
   - `ElectionResultService`: Core election result operations
   - `StatisticsService`: Dashboard statistics and aggregations

3. **Form Requests**: Input validation is handled by dedicated request classes
   - `StorePollingUnitResultRequest`: Validates new result entries

4. **Service Provider**: Dependency injection container configuration
   - `AppServiceProvider`: Binds all repositories and services

### Database Schema

The application uses the following tables (from `bincom_test.sql`):

- `states` (PK: `state_id`): Nigerian states (37 total, Delta = state_id 25)
- `lga` (PK: `uniqueid`): Local Government Areas (25 in Delta State)
- `ward` (PK: `uniqueid`): Wards (263 total)
- `polling_unit` (PK: `uniqueid`): Polling units (272 total)
- `party` (PK: `id`): Political parties (9 parties)
- `announced_pu_results` (PK: `result_id`): Polling unit results
- `announced_lga_results` (PK: `result_id`): LGA aggregated results (DO NOT USE)
- `agentname` (PK: `agent_id`): Party agents

**Important**: Question 2 (LGA aggregation) dynamically SUMs results from `announced_pu_results` instead of using the pre-calculated `announced_lga_results` table, as per requirements.

### Data Quirks

- Some polling units have `ward_id=0` or `lga_id=0` (filtered out in queries)
- The `LABO` abbreviation in results maps to `LABOUR` in the party table
- Primary keys vary across tables (`state_id`, `uniqueid`, `id`, `result_id`)

## Installation

### Prerequisites

- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer
- Node.js 18+ and npm

### Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd bincom-election-assessment
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   
   Edit `.env` file with your MySQL credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bincomphptest
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Create database and import data**
   ```bash
   mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS bincomphptest;"
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```bash
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   
   Open your browser and navigate to: http://localhost:8000

## API Endpoints

### Web Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/` | `dashboard` | Dashboard overview |
| GET | `/polling-units` | `polling-units.index` | List all polling units |
| GET | `/polling-units/{id}` | `polling-units.show` | View polling unit results |
| GET | `/lga-results` | `lga.index` | List all LGAs |
| POST | `/lga-results/calculate` | `lga.calculate` | Calculate LGA aggregated results |
| GET | `/results/create` | `results.create` | New result entry form |
| POST | `/results` | `results.store` | Store new results |
| GET | `/about` | `about` | About page |
| GET | `/pdf/polling-unit/{id}` | `pdf.polling-unit` | Export polling unit PDF |
| GET | `/pdf/lga/{lgaId}` | `pdf.lga` | Export LGA results PDF |
| GET | `/pdf/dashboard` | `pdf.dashboard` | Export dashboard PDF |

### API Routes (JSON)

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/api/lgas/{stateId}` | Get LGAs for a state |
| GET | `/api/wards/{lgaId}` | Get wards for an LGA |
| GET | `/api/polling-units/{wardId}` | Get polling units for a ward |

## Project Structure

```
bincom-election-assessment/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── LgaController.php
│   │   │   │   ├── PollingUnitController.php
│   │   │   │   └── WardController.php
│   │   │   ├── AboutController.php
│   │   │   ├── Controller.php
│   │   │   ├── DashboardController.php
│   │   │   ├── LgaController.php
│   │   │   ├── PdfController.php
│   │   │   ├── PollingUnitController.php
│   │   │   └── ResultController.php
│   │   ├── Middleware/
│   │   │   └── VerifyCsrfToken.php
│   │   └── Requests/
│   │       └── StorePollingUnitResultRequest.php
│   ├── Models/
│   │   ├── AgentName.php
│   │   ├── AnnouncedLgaResult.php
│   │   ├── AnnouncedPuResult.php
│   │   ├── Lga.php
│   │   ├── Party.php
│   │   ├── PollingUnit.php
│   │   ├── State.php
│   │   └── Ward.php
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   ├── Repositories/
│   │   ├── ElectionResultRepository.php
│   │   ├── LgaRepository.php
│   │   ├── PartyRepository.php
│   │   ├── PollingUnitRepository.php
│   │   ├── StateRepository.php
│   │   └── WardRepository.php
│   └── Services/
│       ├── ElectionResultService.php
│       └── StatisticsService.php
├── bootstrap/
├── config/
├── database/
│   └── seeders/
│       └── DatabaseSeeder.php
├── public/
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── components/
│       ├── errors/
│       ├── layouts/
│       ├── lga/
│       ├── pdf/
│       ├── polling-units/
│       ├── results/
│       └── vendor/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env
├── .env.example
├── bincom_test.sql
├── composer.json
├── package.json
├── postcss.config.js
├── tailwind.config.js
├── vite.config.js
└── artisan
```

## Key Features Explained

### Question 1: Polling Unit Results

Displays detailed results for individual polling units with:
- Polling unit information (name, number, ward, LGA, state)
- Vote breakdown by party with visual progress bars
- Winner announcement with margin of victory
- PDF export capability

### Question 2: LGA Aggregated Results

Dynamically aggregates results from `announced_pu_results`:
- Select an LGA from the dropdown
- Results are calculated by SUMming all polling unit results within the LGA
- Displays winner, runner-up, and margin of victory
- Includes bar and pie charts for visualization
- PDF export capability

### Question 3: Enter New Results

Form with chained dropdowns:
1. Select State → loads LGAs
2. Select LGA → loads Wards
3. Select Ward → loads Polling Units
4. Enter vote counts for each party
5. Submit validates and stores results

## Design Principles

- **Professional UI**: Inspired by Stripe/Vercel/Linear dashboards
- **Dark Mode**: Full dark mode support with system preference detection
- **Responsive**: Works seamlessly on mobile, tablet, and desktop
- **Accessible**: Semantic HTML, ARIA labels, keyboard navigation
- **Performant**: Lazy loading, pagination, optimized queries
- **Print-ready**: Optimized print styles for reports

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

The project uses Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

### Building Assets

For development with hot reloading:
```bash
npm run dev
```

For production build:
```bash
npm run build
```

## License

MIT License - See LICENSE file for details

## Acknowledgments

- Built as part of the Bincom PHP/MySQL Developer Technical Interview Assessment
- INECElection Commission for domain knowledge
- Laravel community for excellent documentation and packages