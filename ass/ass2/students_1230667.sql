 -- Managers 
INSERT INTO users (name, email, password, user_type) VALUES
('Manar Mahmoud', 'manger@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'manager'),
('Ali Al-Fares', 'ali.manager@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'manager'),
('Rana Odeh', 'rana.manager@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'manager');
 
-- Customers 
INSERT INTO users (name, email, password, user_type) VALUES
('Tamer Hassan', 'cust@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Fresh Drinking Store', 'fresh@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Mazen AlJamel', 'mazen@birzeit.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Sara Yousef', 'sara.y@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Khaled Nasser', 'khaled.n@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Lina Odeh', 'lina.o@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Omar Barghouti', 'omar.b@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Dina Salah', 'dina.s@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Yousef Zahran', 'yousef.z@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer'),
('Nour Habash', 'nour.h@gmail.com', '$2b$10$NafllsRI8M28RH97usaxEeoR3T1s0fvSZre97w8x/jX874A3LtHAC', 'customer');
 
-- Staff
INSERT INTO users (name, email, password, user_type) VALUES
('Maher Ahmed', 'maher.a@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Ala Al-Masri', 'ala.m@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Rami Kanaan', 'rami.k@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Huda Rimawi', 'huda.r@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Fadi Salman', 'fadi.s@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Mona Freij', 'mona.f@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Ziad Kort', 'ziad.k@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Reem Awad', 'reem.a@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Basel Hijazi', 'basel.h@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff'),
('Layla Nazzal', 'layla.n@gmail.com', '$2b$10$v7AegfqW0mBdssGGaoZihuZjs2mtdT.skh/q3hojaCuwoSA8qk1dq', 'staff');
 
-- TICKETS

INSERT INTO tickets (customer_id, customer_name, email, location, description, submitted_date, status, emergency_level, assigned_date, assigned_staff, image_name) VALUES
(4, 'Tamer Hassan', 'cust@gmail.com', 'Room 101', 'Leaky Faucet in Room 101', '2026-10-18 09:00:00', 'Pending', 'High', NULL, NULL, NULL),
(5, 'Fresh Drinking Store', 'fresh@gmail.com', 'Main Office', 'Air Conditioning Malfunction in Office', '2026-10-19 10:30:00', 'Pending', 'Medium', NULL, NULL, NULL),
(6, 'Mazen AlJamel', 'mazen@birzeit.com', 'Room 305', 'Air conditioning in the room is not working', '2026-10-19 11:00:00', 'Pending', 'High', NULL, NULL, NULL),
(7, 'Sara Yousef', 'sara.y@gmail.com', 'Lab 2', 'Broken projector screen', '2026-09-01 08:15:00', 'Active', 'Medium', '2026-09-02 09:00:00', 'Maher Ahmed', NULL),
(8, 'Khaled Nasser', 'khaled.n@gmail.com', 'Cafeteria', 'Water leakage near entrance', '2026-08-20 14:00:00', 'Completed', 'High', '2026-08-21 10:00:00', 'Ala Al-Masri', NULL),
(9, 'Lina Odeh', 'lina.o@gmail.com', 'Room 210', 'Flickering lights', '2026-09-03 13:20:00', 'Pending', 'Low', NULL, NULL, NULL),
(10, 'Omar Barghouti', 'omar.b@gmail.com', 'Library', 'Door lock is broken', '2026-08-25 09:45:00', 'Active', 'High', '2026-08-26 11:30:00', 'Rami Kanaan', NULL),
(11, 'Dina Salah', 'dina.s@gmail.com', 'Room 401', 'Heating not working', '2026-09-04 16:00:00', 'Pending', 'Medium', NULL, NULL, NULL),
(12, 'Yousef Zahran', 'yousef.z@gmail.com', 'Parking Lot', 'Broken gate sensor', '2026-08-15 12:00:00', 'Completed', 'Low', '2026-08-16 08:00:00', 'Huda Rimawi', NULL),
(13, 'Nour Habash', 'nour.h@gmail.com', 'Room 150', 'Ceiling leak after rain', '2026-09-05 07:30:00', 'Pending', 'High', NULL, NULL, NULL);
 