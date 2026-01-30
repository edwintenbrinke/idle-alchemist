# 🧪 Idle Alchemist

## 📜 Project Summary
**Idle Alchemist** is a mobile-first idle RPG focused on farming, experimentation, and progression.  
Players grow ingredients on a farm, experiment with unknown alchemy recipes using deterministic RNG, and discover powerful potions through trial and failure. Failed experiments are not wasted — they generate knowledge, byproducts, and long-term progression.

The game is designed as a **server-authoritative idle game**, with offline progression, asynchronous combat, and a scalable backend architecture.

This project is built as a **learning playground** for:

- Laravel as a game backend
- Deterministic RNG
- Event-driven domain logic
- Mobile-first Vue + Ionic + Capacitor frontend

---

## 🎯 Core Gameplay Loop
```
Farm ingredients
→ Experiment with alchemy recipes
→ Discover potions or gain knowledge from failures
→ Use or sell potions
→ Upgrade farm, lab, and character
→ Explore & fight monsters for rare seeds
→ Repeat with deeper progression
```

---

## 🧠 Design Goals
- Server is the single source of truth
- Offline progress is fully deterministic
- RNG is seeded and reproducible
- Failures are meaningful
- Systems are modular and extensible
- Backend logic is testable and debuggable
- Mobile UX is idle-friendly and async

---

## ✅ Feature Checklist

### 🌱 Farming
- [ ] Farm with multiple plots
- [ ] Seed types with growth time, yield range, mutation chance
- [ ] Idle/offline growth calculation
- [ ] Harvesting & byproducts
- [ ] Farm upgrades (plots, growth speed, yield)
- [ ] Fertilizers and temporary buffs

---

### 🧪 Alchemy & Experiments
- [ ] Hidden recipes (unknown by default)
- [ ] Ingredient-based experiments
- [ ] Seeded RNG for experiment outcomes
- [ ] Success, partial success, and failure states
- [ ] Failures generate knowledge and byproducts
- [ ] Recipe discovery system
- [ ] Potion quality tiers

---

### 📚 Knowledge & Progression
- [ ] Alchemy XP & leveling
- [ ] Ingredient familiarity
- [ ] Recipe fragments / discovery progress
- [ ] School mastery (Fire, Nature, Poison, etc.)
- [ ] Permanent meta-progression bonuses

---

### ⚔️ Combat & Exploration
- [ ] Asynchronous expeditions
- [ ] Monster loot tables
- [ ] Rare seed drops
- [ ] Potion-based combat modifiers
- [ ] Elemental affinities
- [ ] Combat resolved via queued jobs

---

### 💰 Economy
- [ ] Gold & resource sinks
- [ ] Potion selling
- [ ] Seed & upgrade marketplace
- [ ] Balancing & scaling mechanics

---

### 🔔 UX & Mobile
- [ ] Push notifications (harvest ready, experiment done)
- [ ] Offline-first UI
- [ ] Server-driven timers
- [ ] Sync on reconnect

---

### 🧪 Technical
- [ ] Laravel API backend
- [ ] Sanctum authentication
- [ ] Queues & schedulers
- [ ] Event-driven domain logic
- [ ] Light event sourcing
- [ ] Redis caching
- [ ] Feature & probability tests
- [ ] Vue 3 + Ionic frontend
- [ ] Capacitor mobile builds

---

## 🏁 Project Goal
Build a fully functional idle RPG where all progression, RNG, and game logic lives on the backend, while the frontend focuses on presentation, interaction, and offline UX.

This project is not meant to be a production game, but a **complete end-to-end training project** covering real-world backend architecture, mobile integration, and complex domain logic.

---

## 🗂️ Monorepo Structure
```text
idle-alchemist/
├── backend/
├── frontend/
├── README.md