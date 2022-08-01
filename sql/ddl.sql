CREATE DATABASE leifcommunity;
USE leifcommunity;

CREATE TABLE Role(
  id_role INT(3) PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(63) NOT NULL,
  upper_id INT(3),
  FOREIGN KEY (upper_id) REFERENCES Role(id_role)
);

CREATE TABLE Jemaat(
  username VARCHAR(31) PRIMARY KEY,
  nama_lengkap VARCHAR(255) NOT NULL,
  tahun_bergabung INT(4) NOT NULL,
  jenis_kelamin INT(1) NOT NULL,
  tanggal_lahir DATE NOT NULL,
  tempat_lahir VARCHAR(255) NOT NULL,
  telepon VARCHAR(15) NOT NULL,
  password VARCHAR(255) NOT NULL,
  photo_path VARCHAR(255),
  id_role INT,
  is_verified INT,
  FOREIGN KEY (id_role) REFERENCES Role(id_role)
);

CREATE TABLE Kota(
  id_kota INT(3) PRIMARY KEY AUTO_INCREMENT,
  nama_kota VARCHAR(255) NOT NULL
);

CREATE TABLE Alamat(
  id_alamat INT(6) PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(31) NOT NULL,
  jalan VARCHAR(255) NOT NULL,
  kelurahan VARCHAR(63),
  kecamatan VARCHAR(63),
  id_kota INT(3),
  kode_pos VARCHAR(6),
  is_alamat_utama INT(1),
  FOREIGN KEY (username) REFERENCES Jemaat(username),
  FOREIGN KEY (id_kota) REFERENCES Kota(id_kota)
);

CREATE TABLE Pelayanan(
  id_pelayanan INT(3) PRIMARY KEY AUTO_INCREMENT,
  nama VARCHAR(63) NOT NULL,
  divisi INT(3),
  photo_path VARCHAR(63),
  FOREIGN KEY (divisi) REFERENCES Role(id_role)
);

CREATE TABLE Pelayanan_Jemaat(
  id_pelayanan INT(3), 
  username VARCHAR(31),
  FOREIGN KEY (id_pelayanan) REFERENCES Pelayanan(id_pelayanan),
  FOREIGN KEY (username) REFERENCES Jemaat(username)
);

INSERT INTO Role VALUES(1, 'Server Owner', NULL);
INSERT INTO Role VALUES(2, 'Ketua', 1);
INSERT INTO Role VALUES(3, 'Sekretaris/Bendahara', 2);
INSERT INTO Role VALUES(4, 'Pilar Penyembahan (P1)', 3);
INSERT INTO Role VALUES(5, 'Pilar Persekutuan (P2)', 3);
INSERT INTO Role VALUES(6, 'Pilar Pemuridan (P3)', 3);
INSERT INTO Role VALUES(7, 'Pilar Pelayanan (P4)', 3);
INSERT INTO Role VALUES(8, 'Pilar Penginjilan (P5)', 3);
INSERT INTO Role VALUES(9, 'Tim Kerja Kepengurusan', 3);
INSERT INTO Role VALUES(10, 'Jemaat', 3);


INSERT INTO Kota(nama_kota) VALUES('Kota Bandung');
INSERT INTO Kota(nama_kota) VALUES('Kab. Bandung');
INSERT INTO Kota(nama_kota) VALUES('Kab. Bandung Barat');
INSERT INTO Kota(nama_kota) VALUES('Kab. Bekasi');
INSERT INTO Kota(nama_kota) VALUES('Kab. Cianjur');
INSERT INTO Kota(nama_kota) VALUES('Kota Cirebon');
INSERT INTO Kota(nama_kota) VALUES('Kab. Garut');
INSERT INTO Kota(nama_kota) VALUES('Kota Jakarta');
INSERT INTO Kota(nama_kota) VALUES('Kota Yogyakarta');

INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Bass', 4, 'bass.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Design', 7, 'design.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Drum', 4, 'drum.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Guitar', 4, 'guitar.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Multimedia', 4, 'mulmed.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('PCG', 5, 'pcg.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Keyboard', 4, 'piano.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Singer', 4, 'singer.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Usher', 4, 'usher.jpg');
INSERT INTO Pelayanan(nama, divisi, photo_path) VALUES('Worship Leader', 4, 'worship-leader.jpg');