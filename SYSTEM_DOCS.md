# Strategic Force Manager - System Documentation

This document provides a comprehensive overview of the **Soldier Management System**, detailing its architecture, data hierarchy, and operational protocols.

---

## 🎖️ 1. Tactical Hierarchy (5-Layer Model)

The system is built on a rigid **5-Layer Organizational Hierarchy** designed for military force management.

1.  **Level 1: Battalion [ব্যাটালিয়ন]** - The root command node (e.g., 9 East Bengal).
2.  **Level 2: Company [কোম্পানি]** - Strategic subdivisions (e.g., Alpha Coy).
3.  **Level 3: Platoon [প্লাটুন]** - Tactical units within a company.
4.  **Level 4: Section [সেকশন]** - The smallest combat node.
5.  **Level 5: Personnel [সদস্য]** - Individual soldiers attached to a node.

### 🗺️ Data Flow:
`Battalion` → `Company` → `Platoon` → `Section` → `Personnel (Soldier)`

---

## 🛠️ 2. Core Modules

### 📂 Unit Management (Structural Skeleton)
Used to build the organizational tree.
- **Location:** Admin Sidebar > Unit Management.
- **Protocol:** You must establish parent nodes (Battalion/Company) before creating child nodes (Platoon/Section).

### 👥 Personnel Enrollment (Combat Assets)
Used to add individual soldiers into the hierarchy.
- **Location:** Admin Dashboard > Enroll Personnel.
- **Logic:** Each soldier is assigned to a specific **Unit Node**. If an officer belongs to the Battalion HQ, they are assigned directly to the Battalion level.

### 🔢 Position Sequencing (Sort Order)
Manual ordering of personnel in the directory.
- **Mechanism:** Every soldier has a **Position Number**.
- **Rule:** Lower numbers (e.g., 1, 2, 3) appear first.
- **Benefit:** Provides a stable, professional sequence that persists across all reports and page refreshes.

---

## 💾 3. Technical Architecture

### 📊 Database Schema (Key Relationships)

#### `units` table:
- `id` (PK)
- `parent_id` (Self-referencing FK to `units.id`)
- `name` (Node name)
- `type` (Enum: battalion, company, platoon, section)
- `appointment` (Node commander info)

#### `soldiers` table:
- `id` (PK)
- `unit_id` (FK to `units.id`)
- `name` (Full Name)
- `number` (Service Number - Unique)
- `sort_order` (Integer for manual sequencing)

---

## 🚀 4. Operational Procedures

### Establishing a New Force Structure:
1.  Navigate to **Unit Management**.
2.  Create the **Battalion** node.
3.  Create **Companies** and set the Battalion as their parent.
4.  Repeat for **Platoons** (parent = Company) and **Sections** (parent = Platoon).

### Moving a Soldier:
1.  Go to **Personnel Directory**.
2.  Click **Edit** on a soldier's profile.
3.  Change the **Position Number** to move them up or down in the list.
4.  Select a new **Combat Node** from the cascading dropdowns to reassign them to a different unit.

---
> [!NOTE]
> This system is designed for high-integrity data management. Avoid deleting parent units if they contain active personnel.
