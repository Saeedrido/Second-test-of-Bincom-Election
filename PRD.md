# Bincom Election Results Dashboard - Product Requirements Document

## 1. Product Overview

A production-grade election results management dashboard for INEC (Independent National Electoral Commission) that enables viewing, analyzing, and entering polling unit election results across Delta State, Nigeria.

**Tech Stack:** Laravel 12, PHP 8.3, MySQL, Blade, TailwindCSS v4, Alpine.js, Vite

## 2. Database Analysis

### Tables (Provided - Do Not Modify)

| Table | Purpose | Key Relationships |
|-------|---------|-------------------|
| `states` | 37 Nigerian states | `state_id` (PK) |
| `lga` | 25 LGAs in Delta State | `uniqueid` (PK), `state_id` → states |
| `ward` | 263 wards | `uniqueid` (PK), `lga_id` → lga |
| `polling_unit` | 272 polling units | `uniqueid` (PK), `ward_id` → ward, `lga_id` → lga |
| `party` | 9 political parties | `id` (PK), `partyid` (abbreviation) |
| `announced_pu_results` | Polling unit results | `result_id` (PK), `polling_unit_uniqueid` → polling_unit.uniqueid |
| `announced_lga_results` | LGA results (DO NOT USE) | Pre-calculated totals |
| `announced_state_results` | Empty | N/A |
| `announced_ward_results` | Empty | N/A |
| `agentname` | Party agents | `name_id` (PK), `pollingunit_uniqueid` → polling_unit.uniqueid |

### Hierarchy
```
State (Delta, state_id=25)
  └── LGA (25 LGAs)
        └── Ward (263 wards)
              └── Polling Unit (272 units)
                    └── Results (announced_pu_results)
```

### Data Quirks
- Some polling units have `ward_id=0` or `lga_id=0` (incomplete data - filter these out)
- `announced_pu_results.polling_unit_uniqueid` is varchar but references `polling_unit.uniqueid` (int)
- Party abbreviations differ between tables: `LABO` in results vs `LABOUR` in party table
- No state_id column in polling_unit; state is derived from lga → state relationship

## 3. Functional Requirements

### Question 1: Display Polling Unit Results
- Search/select any polling unit
- Display unit info: name, number, ward, LGA, state
- Show all party results with vote counts
- Sort by highest votes
- Professional table with charts
- Export to PDF, Print support

### Question 2: LGA Aggregated Results
- Select LGA from dropdown
- Sum ALL party results from `announced_pu_results` for all PUs in that LGA
- NEVER use `announced_lga_results`
- Show totals, charts (pie + bar), winning party, margin
- Export to PDF

### Question 3: Enter New Polling Unit Results
- Chained dropdowns: State → LGA → Ward → Polling Unit
- Dynamic loading via AJAX
- Input for every political party
- Form validation
- Duplicate prevention
- Success notification

### Dashboard
- Statistics cards: Total PUs, LGAs, Wards, Parties
- Recent polling units table
- Quick action buttons
- Professional layout

### About Page
- Application info, database explanation, architecture overview

## 4. Non-Functional Requirements
- Responsive mobile-first design
- Dark mode support
- WCAG 2.1 AA accessibility
- Professional UI (Stripe/Vercel/Linear inspired)
- Sub-2-second page loads
- CSRF protection, XSS prevention

## 5. Architecture

### Folder Structure
```
app/
├── Http/Controllers/
│   ├── DashboardController.php
│   ├── PollingUnitController.php
│   ├── LgaController.php
│   └── AboutController.php
├── Models/
│   ├── State.php
│   ├── Lga.php
│   ├── Ward.php
│   ├── PollingUnit.php
│   ├── Party.php
│   ├── AnnouncedPuResult.php
│   └── AgentName.php
├── Services/
│   ├── ElectionResultService.php
│   └── StatisticsService.php
├── Repositories/
│   ├── PollingUnitRepository.php
│   ├── LgaRepository.php
│   └── ElectionResultRepository.php
├── Http/Requests/
│   ├── StorePollingUnitResultRequest.php
│   └── PollingUnitResultRequest.php
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── components/
│   │   ├── stat-card.blade.php
│   │   ├── data-table.blade.php
│   │   ├── chart-container.blade.php
│   │   └── empty-state.blade.php
│   ├── dashboard.blade.php
│   ├── polling-units/
│   │   ├── index.blade.php (Q1)
│   │   └── show.blade.php
│   ├── lga/
│   │   └── index.blade.php (Q2)
│   ├── results/
│   │   └── create.blade.php (Q3)
│   └── about.blade.php
routes/
├── web.php
```

### Routes
```
GET  /                          → DashboardController@index
GET  /polling-units             → PollingUnitController@index
GET  /polling-units/{id}        → PollingUnitController@show
GET  /lga-results               → LgaController@index
POST /lga-results/calculate     → LgaController@calculate
GET  /results/create            → ResultController@create
POST /results                   → ResultController@store
GET  /api/wards/{lga}           → Api\WardController@index
GET  /api/polling-units/{ward}  → Api\PollingUnitController@index
GET  /about                     → AboutController@index
```

## 6. UI Design System

### Color Palette (Light Mode)
- Background: `oklch(98.5% 0.002 247)` (near-white)
- Foreground: `oklch(14.5% 0.025 264)` (near-black)
- Primary: `oklch(45% 0.18 260)` (deep blue)
- Card: `oklch(100% 0 0)` (white)
- Muted: `oklch(96% 0.01 264)` (light gray)
- Border: `oklch(91% 0.01 264)` (subtle border)
- Success: `oklch(55% 0.18 145)` (green)
- Warning: `oklch(75% 0.15 75)` (amber)
- Destructive: `oklch(53% 0.22 27)` (red)

### Typography
- Font: Inter (Google Fonts)
- Headings: font-weight 700, letter-spacing -0.02em
- Body: font-weight 400, line-height 1.6

### Components
- Cards with `rounded-xl`, `shadow-sm`, border
- Buttons with hover transitions (200ms ease-out)
- Tables with alternating row colors
- Skeleton loaders for async content
- Toast notifications for success/error
- Breadcrumb navigation
- Search with debounced input
