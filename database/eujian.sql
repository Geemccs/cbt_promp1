-- ============================================================
--  CBT MTsN 1 Mesuji – database seed (eujian.sql)
--  Default admin: asminpratama@mtsn1mesuji.sch.id / admin123
--  Password hash: bcrypt('admin123')
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table: admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(255)    NOT NULL,
  `email`          VARCHAR(255)    NOT NULL UNIQUE,
  `password`       VARCHAR(255)    NOT NULL,
  `remember_token` VARCHAR(100)    NULL,
  `created_at`     TIMESTAMP       NULL,
  `updated_at`     TIMESTAMP       NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`name`, `email`, `password`, `created_at`, `updated_at`) VALUES
('Asmin Pratama', 'asminpratama@mtsn1mesuji.sch.id', '$2y$10$No7jMeneINJC.QhOLafx4e3Qqqley7tsdCFDwq43L0g7nZ916QEt6', NOW(), NOW());

-- ----------------------------
-- Table: gurus
-- ----------------------------
DROP TABLE IF EXISTS `gurus`;
CREATE TABLE `gurus` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(255)    NOT NULL,
  `nik`            VARCHAR(16)     NOT NULL UNIQUE,
  `password`       VARCHAR(255)    NOT NULL,
  `remember_token` VARCHAR(100)    NULL,
  `created_at`     TIMESTAMP       NULL,
  `updated_at`     TIMESTAMP       NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gurus` (`name`, `nik`, `password`, `created_at`, `updated_at`) VALUES
('Budi Santoso', '1234567890123456', '$2y$10$No7jMeneINJC.QhOLafx4e3Qqqley7tsdCFDwq43L0g7nZ916QEt6', NOW(), NOW()),
('Siti Rahayu',  '9876543210987654', '$2y$10$No7jMeneINJC.QhOLafx4e3Qqqley7tsdCFDwq43L0g7nZ916QEt6', NOW(), NOW());

-- ----------------------------
-- Table: siswas
-- ----------------------------
DROP TABLE IF EXISTS `siswas`;
CREATE TABLE `siswas` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(255)    NOT NULL,
  `nisn`           VARCHAR(10)     NOT NULL UNIQUE,
  `password`       VARCHAR(255)    NOT NULL,
  `remember_token` VARCHAR(100)    NULL,
  `created_at`     TIMESTAMP       NULL,
  `updated_at`     TIMESTAMP       NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `siswas` (`name`, `nisn`, `password`, `created_at`, `updated_at`) VALUES
('Ahmad Fauzi',   '0123456789', '$2y$10$No7jMeneINJC.QhOLafx4e3Qqqley7tsdCFDwq43L0g7nZ916QEt6', NOW(), NOW()),
('Dewi Lestari',  '9876543210', '$2y$10$No7jMeneINJC.QhOLafx4e3Qqqley7tsdCFDwq43L0g7nZ916QEt6', NOW(), NOW()),
('Rizky Pratama', '1122334455', '$2y$10$No7jMeneINJC.QhOLafx4e3Qqqley7tsdCFDwq43L0g7nZ916QEt6', NOW(), NOW());

-- ----------------------------
-- Table: kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode`       VARCHAR(255)    NOT NULL UNIQUE,
  `nama_kelas` VARCHAR(255)    NOT NULL,
  `created_at` TIMESTAMP       NULL,
  `updated_at` TIMESTAMP       NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kelas` (`kode`, `nama_kelas`, `created_at`, `updated_at`) VALUES
('VII-A',  'Kelas VII A',  NOW(), NOW()),
('VII-B',  'Kelas VII B',  NOW(), NOW()),
('VIII-A', 'Kelas VIII A', NOW(), NOW()),
('VIII-B', 'Kelas VIII B', NOW(), NOW()),
('IX-A',   'Kelas IX A',   NOW(), NOW()),
('IX-B',   'Kelas IX B',   NOW(), NOW());

-- ----------------------------
-- Table: mapels
-- ----------------------------
DROP TABLE IF EXISTS `mapels`;
CREATE TABLE `mapels` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode`       VARCHAR(255)    NOT NULL UNIQUE,
  `nama_mapel` VARCHAR(255)    NOT NULL,
  `created_at` TIMESTAMP       NULL,
  `updated_at` TIMESTAMP       NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mapels` (`kode`, `nama_mapel`, `created_at`, `updated_at`) VALUES
('MTK',  'Matematika',           NOW(), NOW()),
('IPA',  'Ilmu Pengetahuan Alam', NOW(), NOW()),
('IPS',  'Ilmu Pengetahuan Sosial', NOW(), NOW()),
('BIN',  'Bahasa Indonesia',     NOW(), NOW()),
('BING', 'Bahasa Inggris',       NOW(), NOW()),
('PAI',  'Pendidikan Agama Islam', NOW(), NOW()),
('PKn',  'PPKn',                 NOW(), NOW()),
('PJOK', 'PJOK',                 NOW(), NOW());

-- ----------------------------
-- Table: guru_kelas (pivot)
-- ----------------------------
DROP TABLE IF EXISTS `guru_kelas`;
CREATE TABLE `guru_kelas` (
  `guru_id`  BIGINT UNSIGNED NOT NULL,
  `kelas_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`guru_id`, `kelas_id`),
  CONSTRAINT `fk_gk_guru`  FOREIGN KEY (`guru_id`)  REFERENCES `gurus`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_gk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: guru_mapel (pivot)
-- ----------------------------
DROP TABLE IF EXISTS `guru_mapel`;
CREATE TABLE `guru_mapel` (
  `guru_id`  BIGINT UNSIGNED NOT NULL,
  `mapel_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`guru_id`, `mapel_id`),
  CONSTRAINT `fk_gm_guru`  FOREIGN KEY (`guru_id`)  REFERENCES `gurus`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_gm_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mapels`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: bank_soals
-- ----------------------------
DROP TABLE IF EXISTS `bank_soals`;
CREATE TABLE `bank_soals` (
  `id`                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `guru_id`             BIGINT UNSIGNED NULL,
  `nama_soal`           VARCHAR(255)    NOT NULL,
  `mapel_id`            BIGINT UNSIGNED NOT NULL,
  `waktu_mengerjakan`   INT             NOT NULL,
  `bobot_pg`            DECIMAL(5,2)    NOT NULL DEFAULT 0,
  `bobot_essay`         DECIMAL(5,2)    NOT NULL DEFAULT 0,
  `bobot_menjodohkan`   DECIMAL(5,2)    NOT NULL DEFAULT 0,
  `bobot_benar_salah`   DECIMAL(5,2)    NOT NULL DEFAULT 0,
  `created_at`          TIMESTAMP       NULL,
  `updated_at`          TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_bs_guru`  FOREIGN KEY (`guru_id`)  REFERENCES `gurus`(`id`)  ON DELETE SET NULL,
  CONSTRAINT `fk_bs_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mapels`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: soals
-- ----------------------------
DROP TABLE IF EXISTS `soals`;
CREATE TABLE `soals` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_soal_id` BIGINT UNSIGNED NOT NULL,
  `jenis_soal`   ENUM('pg','essay','benar_salah','menjodohkan') NOT NULL,
  `pertanyaan`   TEXT            NOT NULL,
  `opsi_a`       TEXT            NULL,
  `opsi_b`       TEXT            NULL,
  `opsi_c`       TEXT            NULL,
  `opsi_d`       TEXT            NULL,
  `opsi_e`       TEXT            NULL,
  `jawaban_benar` TEXT           NOT NULL,
  `urutan`       INT             NOT NULL DEFAULT 0,
  `created_at`   TIMESTAMP       NULL,
  `updated_at`   TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_soal_bs` FOREIGN KEY (`bank_soal_id`) REFERENCES `bank_soals`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: ruang_ujians
-- ----------------------------
DROP TABLE IF EXISTS `ruang_ujians`;
CREATE TABLE `ruang_ujians` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_ruang`     VARCHAR(255)    NOT NULL,
  `guru_id`        BIGINT UNSIGNED NULL,
  `bank_soal_id`   BIGINT UNSIGNED NOT NULL,
  `token`          VARCHAR(10)     NOT NULL UNIQUE,
  `waktu_hentikan` INT             NOT NULL DEFAULT 0,
  `batas_keluar`   INT             NOT NULL DEFAULT 3,
  `tanggal_mulai`  DATETIME        NOT NULL,
  `batas_akhir`    DATETIME        NOT NULL,
  `acak_soal`      TINYINT(1)      NOT NULL DEFAULT 0,
  `acak_jawaban`   TINYINT(1)      NOT NULL DEFAULT 0,
  `created_at`     TIMESTAMP       NULL,
  `updated_at`     TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ru_guru` FOREIGN KEY (`guru_id`)      REFERENCES `gurus`(`id`)      ON DELETE SET NULL,
  CONSTRAINT `fk_ru_bs`   FOREIGN KEY (`bank_soal_id`) REFERENCES `bank_soals`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: ruang_ujian_kelas (pivot)
-- ----------------------------
DROP TABLE IF EXISTS `ruang_ujian_kelas`;
CREATE TABLE `ruang_ujian_kelas` (
  `ruang_ujian_id` BIGINT UNSIGNED NOT NULL,
  `kelas_id`       BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`ruang_ujian_id`, `kelas_id`),
  CONSTRAINT `fk_ruk_ru`    FOREIGN KEY (`ruang_ujian_id`) REFERENCES `ruang_ujians`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ruk_kelas` FOREIGN KEY (`kelas_id`)       REFERENCES `kelas`(`id`)        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: ujian_siswas
-- ----------------------------
DROP TABLE IF EXISTS `ujian_siswas`;
CREATE TABLE `ujian_siswas` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ruang_ujian_id` BIGINT UNSIGNED NOT NULL,
  `siswa_id`       BIGINT UNSIGNED NOT NULL,
  `status`         ENUM('belum','sedang','selesai') NOT NULL DEFAULT 'belum',
  `waktu_mulai`    DATETIME        NULL,
  `waktu_selesai`  DATETIME        NULL,
  `jumlah_benar`   INT             NOT NULL DEFAULT 0,
  `jumlah_salah`   INT             NOT NULL DEFAULT 0,
  `nilai`          DECIMAL(5,2)    NULL,
  `jumlah_keluar`  INT             NOT NULL DEFAULT 0,
  `created_at`     TIMESTAMP       NULL,
  `updated_at`     TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_us_ru`    FOREIGN KEY (`ruang_ujian_id`) REFERENCES `ruang_ujians`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_us_siswa` FOREIGN KEY (`siswa_id`)       REFERENCES `siswas`(`id`)       ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: jawaban_siswas
-- ----------------------------
DROP TABLE IF EXISTS `jawaban_siswas`;
CREATE TABLE `jawaban_siswas` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ujian_siswa_id` BIGINT UNSIGNED NOT NULL,
  `soal_id`       BIGINT UNSIGNED NOT NULL,
  `jawaban`       TEXT            NULL,
  `is_benar`      TINYINT(1)      NULL,
  `created_at`    TIMESTAMP       NULL,
  `updated_at`    TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_js_us`   FOREIGN KEY (`ujian_siswa_id`) REFERENCES `ujian_siswas`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_js_soal` FOREIGN KEY (`soal_id`)        REFERENCES `soals`(`id`)        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: pengumumans
-- ----------------------------
DROP TABLE IF EXISTS `pengumumans`;
CREATE TABLE `pengumumans` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `isi`        TEXT            NOT NULL,
  `created_at` TIMESTAMP       NULL,
  `updated_at` TIMESTAMP       NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: pengumuman_kelas (pivot)
-- ----------------------------
DROP TABLE IF EXISTS `pengumuman_kelas`;
CREATE TABLE `pengumuman_kelas` (
  `pengumuman_id` BIGINT UNSIGNED NOT NULL,
  `kelas_id`      BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`pengumuman_id`, `kelas_id`),
  CONSTRAINT `fk_pk_pengumuman` FOREIGN KEY (`pengumuman_id`) REFERENCES `pengumumans`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pk_kelas`      FOREIGN KEY (`kelas_id`)      REFERENCES `kelas`(`id`)       ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `key`        VARCHAR(255)    NOT NULL UNIQUE,
  `value`      TEXT            NULL,
  `created_at` TIMESTAMP       NULL,
  `updated_at` TIMESTAMP       NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
('seb_enabled', '0', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
