# Database Tables Explanation

## Overview
The hospital management system uses two different tables for different purposes:

## 1. `patient_register` Table
**Purpose**: User account management and authentication
**Used for**: Patient login, registration, and account management

**Key Fields**:
- `mobile_no` (Primary identifier)
- `name`
- `gender`
- `password`
- `register_date`
- `register_time`

**Usage**:
- Patient login system
- User registration
- Account management
- Dashboard "REG_PERSON" count

## 2. `patient_data` Table
**Purpose**: Patient medical records and management
**Used for**: Hospital patient management system

**Key Fields**:
- `id` (Auto-increment primary key)
- `name`
- `age`
- `gender`
- `contact`
- `address`
- `medical_history` (optional)
- `submission_time`
- `submission_date`

**Usage**:
- Patient management (Add/Edit/Delete)
- Dashboard "Total Patients" count
- Medical records

## Dashboard Counts

### Total Patients
- **Source**: `patient_data` table
- **File**: `admin/php/get_total_patients.php`
- **Query**: `SELECT COUNT(*) AS total FROM patient_data`

### REG_PERSON (Registered Users)
- **Source**: `patient_register` table
- **File**: `admin/php/get_total_registered_persons.php`
- **Query**: `SELECT COUNT(*) AS total FROM patient_register`

## Why Two Tables?

1. **Separation of Concerns**:
   - `patient_register`: Authentication and user accounts
   - `patient_data`: Medical records and patient management

2. **Different Data Requirements**:
   - Registration needs: mobile, password, basic info
   - Medical records need: age, address, medical history

3. **Security**:
   - Login credentials separate from medical data
   - Different access levels for different purposes

## Recent Fix
**Issue**: Dashboard "Total Patients" was showing count from `patient_register` instead of `patient_data`
**Fix**: Updated `admin/php/get_total_patients.php` to count from `patient_data` table
**Result**: Dashboard now correctly shows the number of patients in the management system 