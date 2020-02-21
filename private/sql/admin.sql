-- Create the SUPER_ADMIN user
-- password: $2y$12$KNgoQ8SeOUhi./O/SyE6n.UQaB1/DW9GM.phGyUe9seTUeNXOufm2 (root)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `surname`, `birthday`, `phone`, `mobile`, `created_at`, `updated_at`) VALUES
('e74f3acd-18fa-4510-97be-45f560c978ae', 'hello@jjpeleato.com', 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', '$2y$12$KNgoQ8SeOUhi./O/SyE6n.UQaB1/DW9GM.phGyUe9seTUeNXOufm2', 'José Javier', 'Peleato Pradel', '1989-09-28', NULL, NULL, now(), now());
