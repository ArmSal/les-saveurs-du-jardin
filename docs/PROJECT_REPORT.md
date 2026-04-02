# PROJECT REPORT - Les Saveurs Du Jardin Portal

**Project:** LSDJ Multi-Store Management Portal  
**Student:** Armend Salihu  
**Date:** April 2026  
**Course:** IT Project Management (B1-CP4)  

---

## 1. PROJECT CONTEXT

### 1.1 Background
LSDJ (Les Saveurs Du Jardin) is a retail company operating multiple stores. The company needed a centralized web-based portal to manage:
- Human Resources (employees, leaves, schedules)
- Product catalog across all stores
- Customer and internal orders
- Document management with electronic signatures
- Real-time notifications

### 1.2 Objectives
- **Primary:** Build a secure, role-based multi-store management platform
- **Secondary:** Implement agile workflows (leave approval, order tracking)
- **Technical:** Achieve zero security vulnerabilities in CI/CD pipeline

---

## 2. TECHNICAL CHOICES

### 2.1 Architecture Decisions
| Component | Technology | Justification |
|-----------|------------|---------------|
| Framework | Symfony 7.4 | Enterprise-grade, robust security, long-term support |
| Language | PHP 8.2 | Performance improvements, type safety |
| Database | MySQL 8.0 | Relational data with complex relationships |
| ORM | Doctrine | Database abstraction, migrations support |
| Frontend | Twig + TailwindCSS | Clean separation, responsive design |
| Auth | Symfony Security | Built-in CSRF, password hashing, voters |
| CI/CD | GitHub Actions | Automated testing, security scanning |
| Container | Docker + Alpine Linux | Lightweight, production-ready deployment |

### 2.2 Security Implementation
- **6-level permission system:** From personal access to full admin rights
- **Role hierarchy:** Director → Store Manager → Employee → Customer
- **Voters:** Custom Symfony voters for entity-level access control
- **CSRF protection:** All forms protected against cross-site attacks
- **Security fixes applied:**
  - CVE-2024-50342 (HTTP Client)
  - CVE-2024-50345, CVE-2025-64500 (HTTP Foundation)
  - CVE-2024-51736 (Process)
  - CVE-2024-50340 (Runtime)
  - CVE-2024-51996 (Security HTTP)
  - CVE-2024-50343 (Validator)

### 2.3 DevOps & CI/CD
```yaml
Pipeline Stages:
1. composer validate --strict
2. security-checker-action (CVE scanning)
3. docker build -t lsj-web-prod
4. Tests (PHPUnit)
5. Deployment
```

**Docker Configuration:**
- Multi-stage build (base → dev → prod)
- Production: php:8.2-fpm-alpine with OPcache
- Optimized PHP config for performance

---

## 3. PROJECT PROGRESS

### 3.1 Completed (Sprint 1-3)
| Module | Status | Features |
|--------|--------|----------|
| Authentication | ✅ Done | Multi-role login, CSRF protection, password hashing |
| Database | ✅ Done | 12 entities, migrations, relationships |
| Security | ✅ Done | Voters, AccessHelper service, permissions system |
| Dashboard | ✅ Done | KPI display, recent orders, employee stats |
| CI/CD | ✅ Done | GitHub Actions, Docker, zero vulnerabilities |

### 3.2 In Progress (Sprint 4)
| Module | Status | Features |
|--------|--------|----------|
| Agenda/Planning | 🔄 In Progress | Calendar view, time slots, color coding |
| Leave Management | 🔄 In Progress | Workflow: PENDING → MODIFIED → ACCEPTED → APPROVED |
| Product Catalog | 🔄 In Progress | CRUD, image upload, pagination |

### 3.3 Planned (Sprint 5-6)
- Orders module with shopping cart
- Document management with e-signature
- Notifications system
- Monthly validation workflow

---

## 4. AGILE METHODS APPLIED

### 4.1 Scrum Elements
- **Sprints:** 2-week iterations
- **Backlog:** Prioritized user stories in GitHub Projects
- **Daily Standups:** Self-organized progress tracking
- **Retrospectives:** After each sprint (documented)

### 4.2 Kanban Board
| To Do | In Progress | Done |
|-------|-------------|------|
| Order workflow | Agenda calendar | Authentication |
| PDF generation | Leave validation | Database schema |
| Notifications | Product CRUD | CI/CD pipeline |

### 4.3 Definition of Done
- Code written and tested
- Security scan passed (no CVEs)
- Docker build successful
- Commits follow conventional format (feat:, fix:, docs:)

---

## 5. CHALLENGES & SOLUTIONS

### 5.1 Security Vulnerabilities
**Challenge:** CI pipeline failed with 6 CVEs in Symfony 7.0  
**Solution:** Migrated to Symfony 7.4.8, all CVEs resolved  
**Time:** 2 hours  

### 5.2 Dependency Compatibility
**Challenge:** phpstan/phpdoc-parser v2.3 broke Symfony 7.0  
**Solution:** Downgraded to v1.0, updated related packages  
**Impact:** Minimal, maintained functionality  

### 5.3 Docker Build Issues
**Challenge:** Missing prod.ini file, casing warnings  
**Solution:** Created docker/php/prod.ini, fixed FROM...AS casing  
**Result:** Clean build with zero warnings  

---

## 6. METRICS

### 6.1 Code Quality
- **Commits:** 12+ with conventional messages
- **Branches:** main (protected), feature branches
- **Tests:** PHPUnit configured, awaiting full coverage

### 6.2 Security
- **CVEs:** 0 (all resolved)
- **Dependencies:** 113 packages, all up-to-date
- **Docker image:** Alpine-based, minimal attack surface

### 6.3 Documentation
- Functional specification (CAHIER_DES_CHARGES.md)
- Architecture diagrams (Desktop/Mobile/Tablet mockups)
- README.md with setup instructions

---

## 7. NEXT STEPS

1. **Complete Sprint 4:** Agenda and Leave modules
2. **Sprint 5:** Orders and shopping cart
3. **Sprint 6:** Documents and notifications
4. **Final:** Testing, documentation, presentation

---

## 8. CONCLUSION

The LSDJ Portal project demonstrates enterprise-level PHP development with:
- ✅ Modern Symfony 7.4 framework
- ✅ Zero-tolerance security policy (all CVEs resolved)
- ✅ Agile methodology (Scrum + Kanban)
- ✅ Production-ready CI/CD pipeline

The project is on track for completion with all critical security and infrastructure components operational.

---

**Report Date:** April 2, 2026  
**Status:** On Track 🟢
