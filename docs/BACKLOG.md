# PROJECT BACKLOG - LSDJ Portal

**Project:** Les Saveurs Du Jardin - Multi-Store Management Portal  
**Methodology:** Scrum (2-week sprints) + Kanban  
**Last Updated:** April 2, 2026  

---

## 📋 PRODUCT BACKLOG (Priorized)

| ID | User Story | Priority | Estimation | Sprint |
|----|-----------|----------|------------|--------|
| US-001 | As a Director, I want to see dashboard KPIs so that I can monitor business performance | High | 3 SP | 1 ✅ |
| US-002 | As a User, I want to login with email/password so that I can access the portal securely | High | 5 SP | 1 ✅ |
| US-003 | As a Director, I want to manage user roles so that I can control access permissions | High | 8 SP | 1 ✅ |
| US-004 | As a Manager, I want to validate employee schedules so that I can track attendance | High | 5 SP | 2 ✅ |
| US-005 | As an Employee, I want to request leave so that I can plan my vacation | High | 5 SP | 2 ✅ |
| US-006 | As a Manager, I want to approve/reject leave requests so that I can manage staffing | High | 5 SP | 3 🔄 |
| US-007 | As a User, I want to view the calendar agenda so that I can see my schedule | High | 8 SP | 3 🔄 |
| US-008 | As a Director, I want to manage products so that I can maintain the catalog | Medium | 8 SP | 3 🔄 |
| US-009 | As a Customer, I want to place orders so that I can buy products | Medium | 8 SP | 4 |
| US-010 | As a Manager, I want to track order status so that I can fulfill orders | Medium | 5 SP | 4 |
| US-011 | As an Employee, I want to sign documents electronically so that I can complete HR paperwork | Medium | 8 SP | 5 |
| US-012 | As a User, I want to receive notifications so that I stay informed | Low | 5 SP | 5 |
| US-013 | As a Director, I want to generate reports so that I can analyze business data | Low | 13 SP | 6 |

**Legend:** SP = Story Points | ✅ Done | 🔄 In Progress

---

## 🏃 SPRINT BACKLOGS

### Sprint 1: Foundation (Completed ✅)
**Dates:** March 15 - March 28, 2026  
**Goal:** Establish secure authentication and database foundation  
**Velocity:** 16 SP  

| Task | Status | Assignee | Actual Hours |
|------|--------|----------|--------------|
| Database schema design | ✅ Done | Armend | 4h |
| User & Role entities | ✅ Done | Armend | 6h |
| Security configuration | ✅ Done | Armend | 8h |
| Login/logout functionality | ✅ Done | Armend | 6h |
| CI/CD pipeline setup | ✅ Done | Armend | 4h |

**Sprint Review:** Authentication working, CI/CD operational  
**Retrospective:** Good foundation, need to improve Docker build speed  

---

### Sprint 2: HR Core (Completed ✅)
**Dates:** March 29 - April 11, 2026  
**Goal:** Implement HR modules (agenda, leave requests)  
**Velocity:** 13 SP  

| Task | Status | Assignee | Actual Hours |
|------|--------|----------|--------------|
| Calendar/agenda view | ✅ Done | Armend | 12h |
| Leave request form | ✅ Done | Armend | 8h |
| Leave status tracking | ✅ Done | Armend | 6h |
| Manager validation UI | ✅ Done | Armend | 8h |

**Sprint Review:** HR workflows functional, ready for approval workflow  
**Retrospective:** Complex workflow logic took longer than estimated  

---

### Sprint 3: Security & Infrastructure (Completed ✅)
**Dates:** April 12 - April 25, 2026  
**Goal:** Resolve security issues, migrate to Symfony 7.4  
**Velocity:** 16 SP  

| Task | Status | Assignee | Actual Hours |
|------|--------|----------|--------------|
| CVE-2024-50342 fix | ✅ Done | Armend | 2h |
| CVE-2025-64500 fix | ✅ Done | Armend | 2h |
| Symfony 7.4 migration | ✅ Done | Armend | 4h |
| Docker optimization | ✅ Done | Armend | 4h |
| Product catalog CRUD | 🔄 WIP | Armend | 12h |
| Permission voters | ✅ Done | Armend | 6h |

**Sprint Review:** All CVEs resolved, zero security vulnerabilities  
**Retrospective:** Security-first approach paid off, CI pipeline stable  

---

### Sprint 4: Catalog & Agenda (Current 🔄)
**Dates:** April 26 - May 9, 2026  
**Goal:** Complete product management and agenda features  
**Planned Velocity:** 13 SP  

| Task | Status | Assignee | Estimated Hours |
|------|--------|----------|-----------------|
| Product CRUD operations | 🔄 WIP | Armend | 8h |
| Product image upload | 🔄 WIP | Armend | 6h |
| Category management | 📋 To Do | Armend | 4h |
| Calendar time slots | 🔄 WIP | Armend | 8h |
| Leave approval workflow | 🔄 WIP | Armend | 8h |

**Definition of Done:**
- [ ] All features tested locally
- [ ] Docker build passes
- [ ] No new security vulnerabilities
- [ ] Code committed with conventional messages

---

### Sprint 5: Orders & Documents (Planned 📅)
**Dates:** May 10 - May 23, 2026  
**Goal:** Implement order management and document workflow  
**Planned Velocity:** 13 SP  

| Task | Status | Assignee | Estimated Hours |
|------|--------|----------|-----------------|
| Shopping cart session | 📋 To Do | Armend | 6h |
| Order creation workflow | 📋 To Do | Armend | 8h |
| Order status tracking | 📋 To Do | Armend | 6h |
| Document upload | 📋 To Do | Armend | 4h |
| Electronic signature | 📋 To Do | Armend | 10h |

---

### Sprint 6: Notifications & Reports (Planned 📅)
**Dates:** May 24 - June 6, 2026  
**Goal:** Real-time notifications and reporting  
**Planned Velocity:** 18 SP  

| Task | Status | Assignee | Estimated Hours |
|------|--------|----------|-----------------|
| Notification system | 📋 To Do | Armend | 8h |
| Email integration | 📋 To Do | Armend | 6h |
| Business reports | 📋 To Do | Armend | 10h |
| Data export (PDF/Excel) | 📋 To Do | Armend | 8h |
| Final testing & polish | 📋 To Do | Armend | 10h |

---

## 📊 KANBAN BOARD (Current State)

### 🎯 To Do (Ready for Development)
```
┌─────────────────────────────────────────────────────────────┐
│ 📋 CATEGORY MANAGEMENT                                      │
│    - Create/edit/delete categories                          │
│    - Assign products to categories                          │
│    Priority: Medium | Estimated: 4h                       │
├─────────────────────────────────────────────────────────────┤
│ 📋 SHOPPING CART SESSION                                    │
│    - Session-based cart (non-persistent)                  │
│    - Add/remove/update quantities                           │
│    Priority: Medium | Estimated: 6h                       │
├─────────────────────────────────────────────────────────────┤
│ 📋 NOTIFICATION SYSTEM                                      │
│    - Real-time notifications                                │
│    - Badge count on UI                                      │
│    Priority: Low | Estimated: 8h                            │
└─────────────────────────────────────────────────────────────┘
```

### 🔄 In Progress (Work Started)
```
┌─────────────────────────────────────────────────────────────┐
│ 🔄 PRODUCT CRUD OPERATIONS                                  │
│    ✅ Entity & Repository created                           │
│    ✅ Controller structure                                    │
│    🔄 Form validation                                         │
│    ⏳ Image upload handler                                    │
│    Started: Apr 26 | Estimated remaining: 4h                │
├─────────────────────────────────────────────────────────────┤
│ 🔄 CALENDAR TIME SLOTS                                      │
│    ✅ Calendar view component                                 │
│    🔄 Time slot creation form                                 │
│    ⏳ Color coding by employee                                │
│    Started: Apr 28 | Estimated remaining: 6h                │
└─────────────────────────────────────────────────────────────┘
```

### ✅ Done (Completed)
```
┌─────────────────────────────────────────────────────────────┐
│ ✅ DATABASE SCHEMA                                          │
│    All entities created with proper relationships           │
│    Completed: Mar 20                                        │
├─────────────────────────────────────────────────────────────┤
│ ✅ SECURITY & AUTHENTICATION                                │
│    Multi-role system, voters, CSRF protection               │
│    Completed: Apr 5                                         │
├─────────────────────────────────────────────────────────────┤
│ ✅ CI/CD PIPELINE                                           │
│    GitHub Actions, Docker build, security scanner           │
│    Completed: Apr 10                                        │
│    Status: All CVEs resolved ✅                             │
├─────────────────────────────────────────────────────────────┤
│ ✅ CVE SECURITY FIXES                                       │
│    - CVE-2024-50342, CVE-2024-50345, CVE-2025-64500       │
│    - CVE-2024-51736, CVE-2024-50340, CVE-2024-51996       │
│    - CVE-2024-50343, plus Symfony 7.4 migration           │
│    Completed: Apr 25                                        │
└─────────────────────────────────────────────────────────────┘
```

---

## 📈 VELOCITY CHART

```
Velocity (Story Points per Sprint)
    │
 20 │                                        ┌─── Sprint 6
    │                                        │   (Planned)
 18 │                                    ┌───┘
    │                                    │
 16 │    ┌─── Sprint 1                   │
    │    │   (16 SP)                    │
 14 │────┘                               │
    │        ┌─── Sprint 2               │
 13 │        │   (13 SP)             ┌───┘─── Sprint 5
    │    ┌───┘                     │   (13 SP)
 12 │    │                         │
    │    │     ┌─── Sprint 3       │
 10 │    │     │   (16 SP)         │
    │    │     │                   │
  8 │────┘─────┘───────────────────┘
    │
  6 │
    │
  4 │
    │
  2 │
    │
  0 └───────────────────────────────────────
         S1    S2    S3    S4    S5    S6
```

---

## 🔍 BURN-DOWN CHART (Sprint 3)

```
Remaining Work (Hours)
    │
 40 │●
    │  ●
 35 │    ●
    │      ●
 30 │        ●
    │          ●
 25 │            ●
    │              ●
 20 │                ●
    │                  ●
 15 │                    ●
    │                      ●
 10 │                        ●
    │                          ●
  5 │                            ●
    │                              ● ✅
  0 └──────────────────────────────────
     Day 1  3   5   7   9  11  13  14
```

**Sprint 3 Status:** 100% Complete | All security issues resolved

---

## 🎯 DEFINITION OF READY (DoR)

A user story is ready when:
- [x] User story format (As X, I want Y, so that Z)
- [x] Acceptance criteria defined
- [x] Technical approach discussed
- [x] Estimated in story points
- [x] No blocking dependencies

## ✅ DEFINITION OF DONE (DoD)

A task is done when:
- [x] Code written and self-reviewed
- [x] Local testing passed
- [x] Commits follow convention: `type(scope): message`
- [x] CI pipeline passed (no errors)
- [x] Security scan clean (no CVEs)
- [x] Docker build successful
- [x] Feature works in container
- [x] Documentation updated (if needed)

---

## 📝 RETROSPECTIVE NOTES

### Sprint 3 Retrospective (April 25, 2026)

**What Went Well:**
- ✅ Security-first approach: all CVEs resolved
- ✅ Migration to Symfony 7.4 completed smoothly
- ✅ CI/CD pipeline very stable
- ✅ Docker multi-stage build optimized

**What Could Improve:**
- ⏳ Product CRUD took longer than expected
- ⏳ Need better estimation for complex forms
- ⏳ Image upload handling needs more testing

**Action Items:**
1. Add automated tests for file uploads
2. Increase estimates for features with complex validation
3. Document common Docker issues in README

---

**Next Review:** May 9, 2026 (End of Sprint 4)
