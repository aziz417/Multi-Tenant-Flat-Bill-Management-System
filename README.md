# Multi-Tenant Flat & Bill Management System

A comprehensive Laravel-based system for managing buildings, flats, tenants, and bills with multi-tenant architecture ensuring complete data isolation between house owners.

## Features

### Admin Panel
- Create and manage House Owners
- Create and manage Tenants
- Assign tenants to buildings
- View all system data
- Complete oversight of the platform

### House Owner Panel
- Manage multiple buildings
- Create and manage flats with owner details
- Create custom bill categories (Electricity, Gas, Water, etc.)
- Generate bills for flats
- Track bill payments
- Automatic due calculation for unpaid bills
- View tenants assigned to their buildings
- Email notifications for bill creation and payment

## Technical Stack

- **Backend**: Laravel 11.x
- **Frontend**: Bootstrap 5.3
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Auth
- **Permissions**: Spatie Laravel Permission
- **Email**: Laravel Mail

## Multi-Tenant Implementation

This system implements column-based multi-tenancy where:

- Each House Owner can only access their own buildings, flats, and bills
- Data isolation is enforced at the query level using Eloquent scopes
- Middleware ensures proper context is set for house owners
- Policies authorize access to resources
- All queries are automatically scoped to the authenticated user's resources

### Key Security Features

1. **Middleware Protection**: `house_owner_context` middleware ensures proper user context
2. **Policy Authorization**: Laravel policies verify resource ownership
3. **Query Scoping**: All database queries are scoped to house owner's data
4. **Route Protection**: Separate route groups for admin and house owners

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL/PostgreSQL
- Node.js & NPM

### Setup Instructions

1. **Clone the repository**
```bash
git clone https://github.com/aziz417/Multi-Tenant-Flat-Bill-Management-System.git
cd flat-management-system
