# FoxBrain ERP — Development Phases

## Project

**FoxBrain ERP — Sales Management & School Education ERP**

**Company:** FoxBrain Pvt. Ltd.  
**Backend:** PHP 8.3+ / Laravel  
**Database:** MySQL 8+  
**Frontend:** Blade / Bootstrap 5 / JavaScript / Vite  
**Authentication:** Laravel Breeze  
**Architecture:** Modular Laravel ERP  
**Database:** `foxbrain_erp`

---

# 1. Purpose of This Document

This document is the **development execution plan** for FoxBrain ERP.

The project requirements are defined in `README.md` / `BRAIN.md`, while the database foundation is defined in `FoxBrain_ERP_Complete.sql`.

This file decides:

- What should be developed first
- Which modules belong to each phase
- Which database tables are required
- Which Laravel components are required
- What must be completed before moving to the next phase
- What functionality is intentionally postponed
- What the final ERP should contain

## Development Rule

**Do not skip phases.**

A phase is considered complete only when:

1. Database structure is ready.
2. Models and relationships are ready.
3. Controllers/services are implemented.
4. Routes are protected.
5. Validation is implemented.
6. Permissions are implemented.
7. UI is functional.
8. Important workflows are tested.
9. Activity/audit requirements are handled.
10. Documentation is updated.

---

# 2. Overall Development Roadmap

```text
PHASE 1
Foundation + Authentication + RBAC
        ↓
PHASE 2
Admin Portal + System Administration
        ↓
PHASE 3
Sales Management
        ↓
PHASE 4
School Management
        ↓
PHASE 5
Coordinator + Student + Parent Management
        ↓
PHASE 6
Academic Management
        ↓
PHASE 7
Attendance + Assignments + Activities
        ↓
PHASE 8
Examination + Results
        ↓
PHASE 9
Finance + Fee Management
        ↓
PHASE 10
Communication
        ↓
PHASE 11
Reports + Analytics
        ↓
PHASE 12
Security + Testing + Production Hardening
        ↓
PHASE 13
Advanced ERP + API + Mobile Readiness
```

---

# 3. Phase 1 — Foundation

## Objective

Create the stable Laravel foundation on which every future FoxBrain ERP module will depend.

This is the **current starting phase**.

## Modules

- Laravel project configuration
- Authentication
- Users
- Roles
- Permissions
- RBAC
- Admin access
- Database configuration
- System settings foundation
- Activity log foundation
- Base admin layout

## Database

Primary tables:

```text
users
roles
permissions
role_permissions
settings
activity_logs
```

Laravel Breeze will provide the authentication foundation.

## Laravel Work

Create:

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Services/
└── Policies/
```

Create:

- User model
- Role model
- Permission model
- Settings model
- ActivityLog model
- Role/permission relationships
- Permission checking system
- Admin middleware
- Authorization policies where required

## Authentication

Implement:

- Login
- Logout
- Registration policy
- Password reset
- Email verification if enabled
- Authenticated sessions
- User status checking

## RBAC

Initial roles:

```text
Super Admin
Admin
Sales Manager
Sales Executive
Coordinator
Student
Parent
```

Initial permissions should follow the SQL/README permission structure.

Examples:

```text
users.view
users.create
users.edit
users.delete

roles.view
roles.create
roles.edit
roles.delete

leads.view
leads.create
leads.edit
leads.delete

schools.view
schools.create
schools.edit
schools.delete

students.view
students.create
students.edit
students.delete

parents.view
parents.create
parents.edit
parents.delete

attendance.view
attendance.create
attendance.edit

fees.view
fees.create
fees.edit

reports.view

settings.view
settings.edit

activity_logs.view
```

## Admin Layout

Create the common ERP shell:

```text
Sidebar
Top Navbar
Breadcrumb
Page Header
Flash Messages
Validation Messages
Footer
```

Sidebar should be permission-aware.

## Phase 1 Deliverables

- Laravel project running
- MySQL connection working
- Breeze authentication working
- User model working
- Roles working
- Permissions working
- RBAC middleware working
- Admin dashboard shell
- Settings foundation
- Activity log foundation
- Common admin layout

## Completion Criteria

A user can:

```text
Login
  ↓
Authentication
  ↓
Role Detection
  ↓
Permission Check
  ↓
Correct Dashboard
```

---

# 4. Phase 2 — Admin Portal

## Objective

Build the main administrative control center.

## Modules

- Admin Dashboard
- User Management
- Role Management
- Permission Management
- System Settings
- Activity Logs

## User Management

Features:

- User list
- Create user
- Edit user
- View user
- Activate/deactivate user
- Assign role
- Reset password
- Search
- Filter
- Pagination

## Role Management

Features:

- Role list
- Create role
- Edit role
- Delete role
- Assign permissions
- Permission matrix

## Permission Management

Features:

- Permission list
- Permission groups
- Module grouping
- Permission assignment

## Settings

Initial groups:

```text
General
Company
Finance
System
```

## Activity Logs

Track important actions:

```text
Create
Update
Delete
Login
Logout
Permission changes
Settings changes
```

## Dashboard

Initial dashboard should show system-level information such as:

- Total users
- Active users
- Roles
- Recent activities
- System status

---

# 5. Phase 3 — Sales Management

## Objective

Build the complete sales lifecycle from lead generation to school conversion.

## Modules

```text
Sales Team
Lead Sources
Leads
Lead Activities
Lead Follow-ups
Proposals
Sales Dashboard
Sales Reports
```

## Database

```text
sales_employees
lead_sources
leads
lead_activities
lead_followups
proposals
```

## Sales Workflow

```text
Lead Generation
      ↓
Contacted
      ↓
Qualified
      ↓
Requirement Collected
      ↓
Proposal Sent
      ↓
Negotiation
      ↓
Won / Lost
      ↓
School Conversion
```

## Sales Team

Features:

- Employee profile
- Employee code
- Manager
- Designation
- Joining date
- Status
- Assigned leads
- Sales activity

## Lead Management

Features:

- Lead creation
- Lead assignment
- Lead status
- Priority
- Source
- School information
- Contact information
- Required program
- Student strength
- Remarks

## Follow-ups

Features:

- Schedule follow-up
- Call
- School visit
- Meeting
- Email
- WhatsApp record
- Notes
- Outcome
- Reminder
- Follow-up history

## Proposals

Features:

- Proposal number
- Lead
- School
- Proposal date
- Validity
- Pricing
- Discount
- Tax
- Total
- Status
- Notes

## Phase 3 Deliverables

- Sales dashboard
- Sales employee management
- Lead management
- Lead source management
- Follow-up management
- Activity management
- Proposal management
- Sales permissions
- Sales reports foundation

---

# 6. Phase 4 — School Management

## Objective

Convert successful sales opportunities into operational school clients.

## Modules

- Schools
- School Contacts
- School Documents
- School Programs
- School Onboarding

## Database

```text
schools
school_contacts
school_documents
school_programs
```

## School Workflow

```text
Won Lead
   ↓
School Creation
   ↓
School Profile
   ↓
Contacts
   ↓
Agreement
   ↓
Program Setup
   ↓
Coordinator Assignment
   ↓
Academic Setup
```

## School Profile

Store:

- School code
- School name
- Registration number
- School type
- Email
- Phone
- Website
- Address
- City
- State
- Pincode
- Capacity
- Status

## Onboarding

Statuses:

```text
Pending
In Progress
Completed
Suspended
```

## School Programs

A school may have:

- Multiple programs
- Multiple academic years
- Multiple batches
- Different agreed fees
- Different capacities

## Phase 4 Deliverables

- School CRUD
- School contacts
- School documents
- Program allocation
- Onboarding workflow
- Lead-to-school conversion
- School permissions

---

# 7. Phase 5 — Coordinator, Student & Parent Management

## Objective

Build the people-management layer connecting schools, coordinators, students, and parents.

## Modules

```text
Coordinator Management
Student Management
Parent Management
Parent-Student Relationship
Student Enrollment
Student Accounts
Parent Accounts
```

## Database

```text
coordinators
coordinator_school
students
parents
parent_student
```

## Coordinator Workflow

```text
Coordinator
    ↓
Assigned School
    ↓
Assigned Program
    ↓
Classes / Batches
    ↓
Students
```

## Coordinator Features

- Profile
- Employee code
- Designation
- Assigned schools
- Status
- Student access
- Attendance access
- Academic operations
- Reports

## Student Features

- Admission number
- Student code
- Personal profile
- School
- Academic year
- Class
- Section
- Batch
- Program
- Parent relationship
- Enrollment status
- Student account

## Student Enrollment

```text
School
  ↓
Program
  ↓
Student Registration
  ↓
Parent Information
  ↓
Class / Section / Batch
  ↓
Student Account
  ↓
Enrollment Confirmed
```

## Parent Features

- Parent profile
- Parent login
- Contact information
- Multiple children
- Child selection
- Academic access
- Attendance access
- Fee access
- Examination access

## Parent-Child Model

```text
Parent
 ├── Student 1
 ├── Student 2
 └── Student 3
```

Access must be restricted to linked children.

---

# 8. Phase 6 — Academic Management

## Objective

Create the academic structure used by students, coordinators, and future teaching operations.

## Modules

- Academic Years
- Classes
- Sections
- Batches
- Programs
- Subjects
- Class Subjects
- Academic Structure

## Database

```text
academic_years
classes
sections
batches
programs
subjects
class_subjects
```

## Academic Structure

```text
School
   ↓
Academic Year
   ├── Classes
   │     └── Sections
   │           └── Students
   │
   └── Programs
         └── Batches
               └── Students
```

## Features

### Academic Years

- Create
- Edit
- Activate
- Complete
- Set current year

### Classes

- School
- Academic year
- Class name
- Code
- Order
- Status

### Sections

- Class
- Section name
- Capacity
- Status

### Batches

- School
- Program
- Academic year
- Start date
- End date
- Capacity
- Status

### Subjects

- Subject name
- Code
- Description
- Status

### Class Subjects

Connect:

```text
Class
+
Subject
+
Teacher/User
```

---

# 9. Phase 7 — Attendance, Assignments & Activities

## Objective

Manage daily academic activities and student participation.

## Modules

```text
Attendance
Assignments
Homework
Robotics Projects
Coding Activities
STEM Activities
Practical Activities
Submission Tracking
Evaluation
Student Progress
```

## Database

```text
attendance
assignments
assignment_submissions
```

## Attendance

Statuses:

```text
Present
Absent
Late
Leave
Holiday
```

Features:

- Daily attendance
- Class-wise attendance
- Section-wise attendance
- Batch-wise attendance
- Student history
- Correction
- Monthly reports
- Attendance percentage

## Assignment Workflow

```text
Create Assignment
       ↓
Publish
       ↓
Student Receives
       ↓
Submission
       ↓
Evaluation
       ↓
Marks / Remarks
```

## Activity Types

```text
Assignment
Homework
Robotics Project
Coding Activity
STEM Activity
Practical
Other
```

---

# 10. Phase 8 — Examination & Results

## Objective

Manage examinations, marks, grades, results, and report cards.

## Modules

- Examination Management
- Examination Schedule
- Marks
- Grades
- Results
- Report Cards

## Database

```text
examinations
examination_schedules
results
```

## Examination Workflow

```text
Create Examination
       ↓
Schedule Subjects
       ↓
Conduct Examination
       ↓
Enter Marks
       ↓
Calculate Result
       ↓
Grade
       ↓
Publish Result
       ↓
Report Card
```

## Examination Features

- Examination name
- Type
- Academic year
- Start date
- End date
- Schedule
- Subject
- Maximum marks
- Passing marks
- Room
- Instructions

## Result Features

- Student
- Examination
- Subject
- Marks obtained
- Maximum marks
- Grade
- Grade point
- Result status
- Remarks

---

# 11. Phase 9 — Finance & Fee Management

## Objective

Manage school and student financial records.

## Modules

- Fee Types
- Fee Structures
- Student Fees
- Payments
- Receipts
- Discounts
- Outstanding Fees
- Financial Records

## Database

```text
fee_types
fee_structures
student_fees
payments
receipts
```

## Fee Workflow

```text
Fee Structure
      ↓
Student Fee
      ↓
Invoice
      ↓
Payment
      ↓
Receipt
      ↓
Outstanding Updated
```

## Fee Types

Initial types:

```text
Admission Fee
Tuition Fee
Program Fee
Examination Fee
Activity Fee
Other Fee
```

## Payment Methods

```text
Cash
Bank Transfer
UPI
Card
Cheque
Online
Other
```

## Fee Status

```text
Unpaid
Partial
Paid
Overdue
Cancelled
```

---

# 12. Phase 10 — Communication

## Objective

Create centralized communication between the organization, schools, students, parents, coordinators, and sales users.

## Modules

- Notices
- Announcements
- Notifications
- Internal Messages
- Email Notifications
- School Communication
- Parent Communication
- Student Communication
- Sales Communication

## Database

```text
notices
notifications
```

## Notice Workflow

```text
Create
  ↓
Draft
  ↓
Publish
  ↓
Target Audience
  ↓
Notification
```

## Audiences

```text
All
Staff
Students
Parents
Coordinators
Sales
```

## Future Integrations

```text
WhatsApp
SMS
Push Notifications
Mobile Applications
```

---

# 13. Phase 11 — Reports & Analytics

## Objective

Create management-level reporting across sales, schools, students, academics, and finance.

## Sales Reports

- Lead reports
- Sales employee reports
- Follow-up reports
- Lead source reports
- Proposal reports
- Won/Lost reports
- School onboarding reports

## School Reports

- School-wise students
- School-wise programs
- School enrollment
- Active schools
- Student status

## Academic Reports

- Attendance
- Assignments
- Examination
- Results
- Student progress

## Finance Reports

- Fee collection
- Outstanding fees
- Payment history
- School-wise financial reports
- Student-wise fee reports

## Dashboard Analytics

Management dashboards can combine:

```text
Sales
+
Schools
+
Students
+
Attendance
+
Examinations
+
Finance
```

---

# 14. Phase 12 — Security, Testing & Production Hardening

## Objective

Prepare FoxBrain ERP for reliable real-world operation.

## Security

Verify:

- Authentication
- Authorization
- RBAC
- Policies
- CSRF protection
- Form validation
- Mass assignment protection
- SQL injection protection through Eloquent/query binding
- File validation
- Session security
- Record-level access
- Parent-child access restrictions
- Coordinator school restrictions
- Sales assigned-lead restrictions

## Record-Level Access

Examples:

```text
Sales Executive
    → Assigned Leads

Coordinator
    → Assigned Schools
    → Related Students

Student
    → Own Records

Parent
    → Linked Children

Admin
    → Permission-controlled Records
```

## Testing

Run:

```bash
php artisan test
```

Test:

- Authentication
- Authorization
- RBAC
- Sales
- Leads
- Schools
- Students
- Parents
- Coordinator access
- Academic management
- Attendance
- Assignments
- Examinations
- Results
- Fees
- Reports
- Validation
- Security
- Record-level access

## Production Hardening

Check:

```text
.env security
APP_DEBUG=false
Database backups
Storage permissions
Queue configuration
Cache configuration
Logging
Error handling
HTTPS
File upload security
```

---

# 15. Phase 13 — Advanced ERP

This phase starts only after the core ERP is stable.

## Future Modules

- Library Management
- Transport Management
- Inventory
- Staff Management
- Payroll
- REST API
- Advanced Analytics
- Parent Mobile Application
- Student Mobile Application

## API Foundation

Future API areas:

```text
Authentication API
Users API
Schools API
Students API
Parents API
Attendance API
Assignments API
Examinations API
Results API
Fees API
Notifications API
Reports API
```

---

# 16. Database Phase Mapping

| Phase | Main Database Tables |
|---|---|
| Phase 1 | `users`, `roles`, `permissions`, `role_permissions`, `settings`, `activity_logs` |
| Phase 2 | Same foundation tables + administrative relationships |
| Phase 3 | `sales_employees`, `lead_sources`, `leads`, `lead_activities`, `lead_followups`, `proposals` |
| Phase 4 | `schools`, `school_contacts`, `school_documents`, `school_programs` |
| Phase 5 | `coordinators`, `coordinator_school`, `students`, `parents`, `parent_student` |
| Phase 6 | `academic_years`, `classes`, `sections`, `batches`, `programs`, `subjects`, `class_subjects` |
| Phase 7 | `attendance`, `assignments`, `assignment_submissions` |
| Phase 8 | `examinations`, `examination_schedules`, `results` |
| Phase 9 | `fee_types`, `fee_structures`, `student_fees`, `payments`, `receipts` |
| Phase 10 | `notices`, `notifications` |
| Phase 11 | Reporting queries/views/services across all modules |
| Phase 12 | Testing/security/audit across all modules |
| Phase 13 | Future modules and APIs |

---

# 17. Laravel Development Pattern

Every module should follow the same implementation sequence.

```text
Business Requirement
        ↓
Workflow
        ↓
Database
        ↓
Migration
        ↓
Model
        ↓
Relationships
        ↓
Seeder
        ↓
Form Request
        ↓
Service / Business Logic
        ↓
Policy / Authorization
        ↓
Controller
        ↓
Routes
        ↓
Blade Views
        ↓
Validation
        ↓
Activity Log
        ↓
Testing
        ↓
Documentation
```

Do not implement important ERP modules as uncontrolled basic CRUD only.

---

# 18. Module Folder Standard

Controllers should follow the module/portal structure:

```text
app/Http/Controllers/

Admin/
Sales/
Coordinator/
Student/
Parent/
```

Models:

```text
app/Models/
```

Business logic:

```text
app/Services/
```

Authorization:

```text
app/Policies/
```

Requests:

```text
app/Http/Requests/
```

Views:

```text
resources/views/

admin/
sales/
coordinator/
student/
parent/
```

---

# 19. Portal Structure

## Admin Portal

```text
/dashboard
/users
/roles
/permissions
/schools
/coordinators
/students
/parents
/academic-years
/classes
/sections
/programs
/attendance
/examinations
/results
/fees
/reports
/settings
/activity-logs
```

## Sales Portal

```text
/sales/dashboard
/sales/employees
/sales/leads
/sales/followups
/sales/activities
/sales/proposals
/sales/schools
/sales/reports
```

## Coordinator Portal

```text
/coordinator/dashboard
/coordinator/schools
/coordinator/students
/coordinator/attendance
/coordinator/assignments
/coordinator/examinations
/coordinator/results
/coordinator/reports
```

## Student Portal

```text
/student/dashboard
/student/profile
/student/school
/student/attendance
/student/assignments
/student/examinations
/student/results
/student/fees
/student/notices
```

## Parent Portal

```text
/parent/dashboard
/parent/children
/parent/children/{student}
 /parent/attendance
/parent/assignments
/parent/examinations
/parent/results
/parent/fees
/parent/receipts
/parent/notices
```

Actual route names and URLs may be refined during implementation, but access must remain separated by role and permission.

---

# 20. Phase Completion Rule

Each phase must have a completion checklist.

## Example

```text
[ ] Database ready
[ ] Migration ready
[ ] Models ready
[ ] Relationships ready
[ ] Seeders ready
[ ] Form Requests ready
[ ] Services ready
[ ] Controllers ready
[ ] Routes ready
[ ] Policies ready
[ ] Views ready
[ ] Validation ready
[ ] Permissions ready
[ ] Activity logging ready
[ ] Search/filter ready where required
[ ] Pagination ready where required
[ ] Tests ready
[ ] Documentation updated
```

Only after all required items are completed should the phase be marked:

```text
STATUS: COMPLETED
```

---

# 21. Current Project Status

At the creation of this document:

```text
Project: FoxBrain ERP
Database Design: Ready
Complete SQL: Ready
Laravel Project: Created
Git Repository: Connected
Node.js / NPM: Installed
Laravel Breeze: Being configured
```

## Current Phase

```text
PHASE 1 — FOUNDATION
```

## Current Focus

The immediate development order is:

```text
1. Laravel + Breeze authentication
2. Database connection
3. Users
4. Roles
5. Permissions
6. RBAC
7. Admin middleware
8. Admin dashboard
9. Settings
10. Activity logs
11. Phase 1 testing
```

Do not start Sales Management until the Phase 1 foundation is stable.

---

# 22. Git Development Strategy

Recommended branches:

```text
main
develop

feature/phase-1-foundation
feature/phase-2-admin
feature/phase-3-sales
feature/phase-4-schools
feature/phase-5-students-parents
feature/phase-6-academic
feature/phase-7-attendance
feature/phase-8-examinations
feature/phase-9-finance
feature/phase-10-communication
feature/phase-11-reports
feature/phase-12-security-testing
feature/phase-13-advanced-erp
```

Example:

```bash
git checkout -b feature/phase-1-foundation
```

After completing a logical task:

```bash
git add .
git commit -m "Build Phase 1 foundation"
git push origin feature/phase-1-foundation
```

Merge to the appropriate development branch only after testing.

---

# 23. Development Environment

Required:

```text
PHP 8.3+
Composer
Laravel
MySQL 8+
Node.js
NPM
Git
Apache/Nginx
```

Common commands:

```bash
composer install

npm install

php artisan key:generate

php artisan migrate

npm run dev

php artisan serve

php artisan test
```

For a fresh development database only:

```bash
php artisan migrate:fresh --seed
```

Never use `migrate:fresh` against production data.

---

# 24. Final ERP Lifecycle

The completed core ERP should support this business lifecycle:

```text
LEAD
  ↓
SALES FOLLOW-UP
  ↓
PROPOSAL
  ↓
NEGOTIATION
  ↓
WON
  ↓
SCHOOL ONBOARDING
  ↓
PROGRAM SETUP
  ↓
COORDINATOR ASSIGNMENT
  ↓
ACADEMIC SETUP
  ↓
STUDENT ENROLLMENT
  ↓
PARENT LINKING
  ↓
CLASS / SECTION / BATCH
  ↓
ATTENDANCE
  ↓
ASSIGNMENTS / ACTIVITIES
  ↓
EXAMINATION
  ↓
RESULTS
  ↓
FEES / PAYMENTS
  ↓
COMMUNICATION
  ↓
REPORTS & ANALYTICS
```

---

# 25. Final Phase Order

The official implementation order is:

```text
PHASE 1  → Foundation
PHASE 2  → Admin Portal
PHASE 3  → Sales Management
PHASE 4  → School Management
PHASE 5  → Coordinator + Student + Parent
PHASE 6  → Academic Management
PHASE 7  → Attendance + Assignments
PHASE 8  → Examination + Results
PHASE 9  → Finance + Fees
PHASE 10 → Communication
PHASE 11 → Reports + Analytics
PHASE 12 → Security + Testing + Production
PHASE 13 → Advanced ERP + API + Mobile
```

---

# 26. Project Rule

**FoxBrain ERP is developed phase-by-phase, not module-by-module without an architecture plan.**

Every new feature must belong to a defined phase.

Every phase must respect:

```text
Database
+
Business Logic
+
Authorization
+
UI
+
Validation
+
Security
+
Testing
+
Documentation
```

The current development target is:

```text
================================================
PHASE 1 — FOUNDATION
================================================

Authentication
Users
Roles
Permissions
RBAC
Admin Access
Dashboard Foundation
Settings
Activity Logs

================================================
```

After Phase 1 is fully tested and stable, development proceeds to **Phase 2 — Admin Portal**.
