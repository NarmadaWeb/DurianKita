CREATE DATABASE IF NOT EXISTS duriancare;
USE duriancare;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS diseases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(100),
    description TEXT,
    solution TEXT,
    prevention TEXT,
    maintenance TEXT
);

CREATE TABLE IF NOT EXISTS symptoms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category ENUM('Daun', 'Batang', 'Buah', 'Akar')
);

CREATE TABLE IF NOT EXISTS rules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    disease_id INT,
    symptom_id INT,
    FOREIGN KEY (disease_id) REFERENCES diseases(id) ON DELETE CASCADE,
    FOREIGN KEY (symptom_id) REFERENCES symptoms(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS diagnosis_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_name VARCHAR(100) NOT NULL,
    disease_id INT,
    selected_symptoms TEXT,
    diagnosis_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (disease_id) REFERENCES diseases(id) ON DELETE SET NULL
);

-- Reset tables to ensure fresh data
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE rules;
TRUNCATE TABLE symptoms;
TRUNCATE TABLE diseases;
TRUNCATE TABLE admins;
SET FOREIGN_KEY_CHECKS = 1;

-- Default Admin Account (password: admin123)
INSERT INTO admins (username, password, full_name) VALUES
('admin', '$2y$10$s/tDWm1jGMlhwJPgHGUDDu9y9OkSPWUWno6l.ZZpdW8sLFgIkQPM6', 'Administrator');

-- Diseases Data
INSERT INTO diseases (id, name, scientific_name, description, solution, prevention, maintenance) VALUES
(1, 'Kanker Batang', 'Phytophthora palmivora', 'Penyakit yang menyerang kulit batang durian, menyebabkan keluarnya lendir kemerahan atau coklat.', 'Kupas bagian kulit yang sakit, lalu oleskan fungisida berbahan aktif tembaga atau metalaksil.', 'Gunakan bibit yang sehat, perbaiki drainase lahan agar tidak tergenang air, dan hindari luka pada batang saat pemeliharaan.', 'Lakukan pemantauan rutin pada batang tanaman, bersihkan gulma di sekitar pangkal batang, dan lakukan pemangkasan rutin untuk menjaga sirkulasi udara.'),
(2, 'Busuk Akar', 'Pythium complectens', 'Menyerang sistem perakaran sehingga tanaman menjadi layu dan daun menguning secara bertahap.', 'Perbaiki drainase tanah, gunakan agen hayati Trichoderma, dan aplikasikan fungisida sistemik.', 'Pastikan sistem drainase berjalan baik, gunakan media tanam yang steril, dan aplikasikan agen hayati secara preventif sejak dini.', 'Lakukan penggemburan tanah secara berkala, berikan pupuk organik yang sudah matang sempurna, dan hindari pemberian air berlebih saat musim hujan.'),
(3, 'Jamur Upas', 'Corticium salmonicolor', 'Ditandai dengan adanya lapisan jamur berwarna merah muda pada cabang atau ranting.', 'Potong cabang yang terinfeksi berat dan oleskan fungisida atau bubur Bordeaux pada bagian yang terserang.', 'Atur jarak tanam agar sirkulasi udara lancar dan sinar matahari dapat masuk ke sela-sela tajuk tanaman.', 'Bersihkan cabang dan ranting yang sudah tua atau mati secara berkala, serta lakukan pembersihan area kebun dari sisa-sisa tanaman yang terinfeksi.'),
(4, 'Bercak Daun', 'Colletotrichum sp.', 'Muncul bercak-bercak coklat pada daun yang dapat menyebabkan daun berlubang atau rontok.', 'Semprotkan fungisida berbahan aktif mankozeb atau karbendazim secara rutin terutama saat musim hujan.', 'Hindari penggunaan sistem penyiraman overhead (dari atas) pada sore hari dan lakukan sanitasi daun yang gugur.', 'Lakukan pemupukan seimbang untuk meningkatkan daya tahan tanaman dan aplikasikan fungisida preventif saat muncul daun muda di musim hujan.'),
(5, 'Busuk Buah', 'Phytophthora palmivora', 'Buah durian membusuk dimulai dari bagian ujung atau samping, sering muncul spora putih.', 'Lakukan sanitasi kebun, bungkus buah sejak kecil, dan semprotkan fungisida pada buah.', 'Bungkus buah durian sejak dini dengan plastik transparan atau jaring, serta lakukan sanitasi buah yang rontok dan busuk.', 'Jaga kebersihan area bawah pohon, pangkas dahan yang terlalu rendah agar buah tidak bersentuhan dengan tanah atau kelembaban tinggi.'),
(6, 'Penggerek Batang', 'Batocera sp.', 'Larva kumbang mengebor ke dalam batang, menciptakan lubang dan mengeluarkan kotoran seperti serbuk gergaji.', 'Suntikkan insektisida sistemik ke dalam lubang gerekan atau bersihkan larva secara manual.', 'Tutup lubang bekas potongan cabang dengan cat atau parafin, dan gunakan perangkap lampu untuk menangkap kumbang dewasa.', 'Pantau secara teliti adanya serbuk kayu di sekitar batang pohon dan segera lakukan tindakan jika ditemukan lubang gerekan baru.'),
(7, 'Penggerek Buah', 'Tirathaba sp.', 'Ulat menyerang bagian dalam buah sehingga buah menjadi busuk dan tidak layak konsumsi.', 'Lakukan pembungkusan buah dan semprotkan insektisida nabati atau kimia sesuai dosis.', 'Lakukan pembungkusan buah dengan benar sejak buah masih kecil dan pasang perangkap feromon jika diperlukan.', 'Kumpulkan dan musnahkan buah yang terserang agar ulat di dalamnya tidak menjadi dewasa dan menyerang buah lainnya.'),
(8, 'Kutu Loncat', 'Allocaridara malayensis', 'Hama yang menyerang daun muda, menyebabkan daun mengeriting dan tertutup embun jelaga.', 'Gunakan insektisida berbahan aktif imidakloprid atau abamektin.', 'Pantau pertumbuhan daun muda secara intensif dan hindari penggunaan pestisida yang berlebihan agar musuh alami tetap lestari.', 'Lakukan penyiraman air dengan tekanan tinggi pada daun muda untuk mengusir koloni kutu dan bersihkan embun jelaga yang menempel.'),
(9, 'Antraknosa', 'Colletotrichum gloeosporioides', 'Menyebabkan bercak melingkar pada buah atau daun, sering terjadi pada kondisi lembab.', 'Kurangi kelembaban kebun dengan pemangkasan dan aplikasikan fungisida tembaga.', 'Lakukan pemangkasan tajuk agar sinar matahari masuk secara merata dan hindari kelembaban yang terlalu tinggi di dalam kebun.', 'Aplikasi fungisida secara rutin sesuai dosis anjuran, terutama saat pergantian musim atau cuaca ekstrim.'),
(10, 'Mati Pucuk', 'Rhizoctonia solani', 'Ujung pucuk tanaman mengering dan mati, sering merambat ke bagian bawah.', 'Potong bagian yang mati dan aplikasikan fungisida sistemik.', 'Gunakan bibit yang sehat dan bebas dari jamur patogen, serta jaga kebersihan alat pemangkasan.', 'Segera potong bagian pucuk yang mulai layu hingga 10-15 cm di bawah bagian yang sakit, lalu oleskan fungisida pada bekas potongan.');

-- Symptoms Data
INSERT INTO symptoms (id, name, category) VALUES
(1, 'Luka lendir coklat kemerahan pada batang', 'Batang'),
(2, 'Daun menguning secara tidak wajar', 'Daun'),
(3, 'Akar berwarna coklat dan membusuk', 'Akar'),
(4, 'Lapisan jamur berwarna merah muda pada ranting', 'Batang'),
(5, 'Bercak coklat pada permukaan daun', 'Daun'),
(6, 'Lubang gerekan pada kulit buah', 'Buah'),
(7, 'Buah membusuk dengan spora putih di permukaan', 'Buah'),
(8, 'Lubang pada batang yang mengeluarkan serbuk kayu', 'Batang'),
(9, 'Ujung pucuk tanaman mengering dan mati', 'Daun'),
(10, 'Daun muda mengeriting dan berubah bentuk', 'Daun'),
(11, 'Adanya lapisan hitam (embun jelaga) pada daun', 'Daun'),
(12, 'Pertumbuhan tanaman terlihat kerdil', 'Daun'),
(13, 'Ranting atau cabang mudah patah', 'Batang'),
(14, 'Bunga rontok secara massal sebelum mekar', 'Buah'),
(15, 'Bercak konsentris (melingkar) pada buah', 'Buah'),
(16, 'Akar terasa berlendir dan berbau tidak sedap', 'Akar'),
(17, 'Daun tiba-tiba layu meskipun tanah lembab', 'Daun'),
(18, 'Lubang-lubang kecil pada helaian daun', 'Daun'),
(19, 'Kulit batang pecah-pecah dan mengelupas', 'Batang'),
(20, 'Ditemukan ulat di dalam daging buah', 'Buah');

-- Rules Data (Linking Symptoms to Diseases)
INSERT INTO rules (disease_id, symptom_id) VALUES
-- Kanker Batang
(1, 1), (1, 19), (1, 2),
-- Busuk Akar
(2, 3), (2, 16), (2, 17),
-- Jamur Upas
(3, 4), (3, 13),
-- Bercak Daun
(4, 5), (4, 18),
-- Busuk Buah
(5, 7), (5, 15),
-- Penggerek Batang
(6, 8), (6, 1),
-- Penggerek Buah
(7, 6), (7, 20),
-- Kutu Loncat
(8, 10), (8, 11), (8, 12),
-- Antraknosa
(9, 15), (9, 5), (9, 14),
-- Mati Pucuk
(10, 9), (10, 17), (10, 13);
