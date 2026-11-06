# Manager Library — Backend API Implementation

This repository contains the backend service for *Manager Library*, built using PHP with the **Laravel** framework, adhering strictly to the Spec-Driven Development (SDD) methodology.

##  Core SDD Architectural Decisions

Following the constraints mapped out from `spec-python/`, this backend project translates architectural patterns into Laravel entities:

### 1. Database & Schema Structural Adaptations
- **Strict Singular Naming Conventions:** Applied singular snake_case across all tables (e.g., `category`, `book`, `member`, `loan`, `loan_item`).
- **Domain-Generated Keys:** Primary keys are generated as non-sequential `UUID` string values on the domain/application layer.
- **Zero Default Values:** No implicit defaults are set on the schema tables to enforce domain-level absolute validation control.
- **No Automatic Timestamps:** Standard framework tracking columns (`created_at` and `updated_at`) were omitted entirely per system design parameters.
- **Database Concurrency Check Constraints:** Added database-level data integrity protection (`ck_book_available_range`) using direct sql check limits:
  `available_copies >= 0 AND available_copies <= total_copies`
- **Audit Immutability & Denormalization:** Implemented data-freezing columns (`book_title`, `isbn`, `category_name`) inside the `loan_item` table to isolate historical transactions from subsequent catalog updates.

### 2. API Contract Mapping (`/routes/api.php`)
Endpoints are designed explicitly under the `/api/v1/` prefix block to serve internal client request states securely under token-based auth middlewares:
- `POST /api/v1/auth/login` -> Authenticates internal administrative operators (`admin` / `librarian`).
- `GET /api/v1/books` -> Implements strict text filtering, category filtering, and mandatory item pagination parameters.
- `POST /api/v1/loans` -> Manages multi-line borrowing events inside a safe transactional layer (blocking operations if loan selections break the required 1-to-3 books rule or if the targeted member profile carries overdue lines).

## Execution Sequences

### Schema Migrations Setup
To verify and append the database structural restrictions onto the live environment instance, execute the native Artisan schema processing script:
```bash
php artisan migrate
```
