# TODO - ProMa Time Entry & Excel Module

- [x] Install Excel package (maatwebsite/excel)
- [ ] Create migrations for collaborators and time_entries
- [ ] Create models (Collaborator, TimeEntry) with relationships
- [ ] Create controllers (CollaboratorController, TimeEntryController)
- [ ] Create Excel import class (TimeEntriesImport)
- [ ] Update web routes
- [ ] Create Blade layout and CRUD views for collaborators
- [ ] Create Blade CRUD + import views for time entries
- [ ] Add JS auto-fill (Estabelecimento, Carga Horaria) from selected collaborator
- [ ] Update `.env` DB name to `promaDb`
- [ ] Run migrations
- [ ] Validate routes and basic app checks
- [ ] Add filters on time entries list (date range and collaborator)
- [ ] Add establishment operational state (Aberto/Fechado/Parcialmente) to time entries
- [ ] Add dashboard optional filters (collaborator, presence, establishment state)
- [ ] Show establishment operational state in dashboard latest-status table
