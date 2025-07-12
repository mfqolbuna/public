        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard Perhitungan Lahan</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    overflow-x: hidden;
                }

                .sidebar {
                    background-color: #2196F3;
                    color: #fff;
                    padding: 1em;
                    width: 250px;
                    height: 100vh;
                    position: fixed;
                    top: 0;
                    left: 0;
                    transition: all 0.3s ease;
                    z-index: 100;
                }

                h1 {
                    color: white;
                    text-align: center;
                    margin-bottom: 30px;
                }

                h2 {
                    text-align: center;
                    color: #333;
                    margin-bottom: 25px;
                }

                .sidebar ul {
                    list-style: none;
                    margin: 0;
                    padding: 0;
                }

                .sidebar li {
                    margin-bottom: 10px;
                }

                .sidebar a {
                    color: #fff;
                    text-decoration: none;
                    display: block;
                    padding: 8px 0;
                }

                .sidebar a:hover {
                    text-decoration: underline;
                }

                .sidebar-toggle {
                    font-size: 1.5em;
                    color: #fff;
                    cursor: pointer;
                    display: none;
                    position: fixed;
                    top: 10px;
                    left: 10px;
                    z-index: 999;
                    background: #2196F3;
                    padding: 5px 10px;
                    border-radius: 4px;
                }

                .content {
                    margin-left: 250px;
                    padding: 1em;
                    transition: margin-left 0.3s ease;
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                }

                main {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    padding: 2em;
                }

                footer {
                    background-color: #333;
                    color: #fff;
                    padding: 1em;
                    text-align: center;
                    width: 1000%;
                }

                form {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    width: 100%;
                    max-width: 400px;
                    gap: 15px;
                }

                .form-group {
                    width: 100%;
                }

                label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                }

                input[type="text"], 
                input[type="number"] {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                }

                button {
                    padding: 10px 15px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    width: 100%;
                    max-width: 150px;
                    font-size: 1em;
                    margin-top : 10px;
                    margin-bottom : 10px;

                }

                button:hover {
                    background-color: #45a049;
                }

                #result {
                    margin-top: 20px;
                    font-weight: bold;
                    font-size: 1.1em;
                    text-align: center;
                }

                .success {
                    color: #4CAF50;
                    font-weight: bold;
                    padding: 10px;
                    background-color: #e8f5e9;
                    border-radius: 4px;
                    margin: 10px 0;
                }

                .error {
                    color: #f44336;
                    font-weight: bold;
                    padding: 10px;
                    background-color: #ffebee;
                    border-radius: 4px;
                    margin: 10px 0;
                }

                @media (max-width: 768px) {
                    .sidebar {
                        transform: translateX(-100%);
                    }

                    .sidebar.open {
                        transform: translateX(0);
                    }

                    .content {
                        margin-left: 0;
                    }

                    .sidebar-toggle {
                        display: block;
                    }
                }
                select.form-control {
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        box-sizing: border-box;
                        background-color: white;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        appearance: none;
                }
                select.form-control:focus {
                        outline: none;
                        border-color: #2196F3;
                        box-shadow: 0 0 0 2px rgba(33,150,243,0.2);
                }

                input[type="file"] {
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        box-sizing: border-box;
                        background-color: white;
                }
                </style>
</head>
<body>
    <div class="sidebar-toggle" onclick="toggleSidebar()">&#9776;</div>
    <div class="sidebar" id="sidebar">
        <h1>Menu</h1>
        <ul>
            <li><a href="dashboard.php">Beranda</a></li>
            <li><a href="settings.php">Pengaturan</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
    
    <div class="content">
        <main>
            <h2>Perhitungan Lahan</h2>
            <form id="land-form" action="submit.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="panjang_lahan">Panjang Lahan (meter):</label>
                    <input type="number" id="panjang_lahan" name="panjang_lahan" step="0.01" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_panjang_lahan">Nominal Panjang (Rp):</label>
                    <input type="number" id="nominal_panjang_lahan" name="nominal_panjang_lahan" readonly>
                </div>

                <div class="form-group">
                    <label for="lebar_lahan">Lebar Lahan (meter):</label>
                    <input type="number" id="lebar_lahan" name="lebar_lahan" step="0.01" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_lebar_lahan">Nominal Lebar (Rp):</label>
                    <input type="number" id="nominal_lebar_lahan" name="nominal_lebar_lahan" readonly>
                </div>

                <!-- Bagian Kamar -->
                <div class="form-group">
                    <label for="jumlah_kamar_mandi">Jumlah Kamar Mandi:</label>
                    <input type="number" id="jumlah_kamar_mandi" name="jumlah_kamar_mandi" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_kamar_mandi">Nominal Kamar Mandi (Rp):</label>
                    <input type="number" id="nominal_kamar_mandi" name="nominal_kamar_mandi" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah_kamar_tidur">Jumlah Kamar Tidur:</label>
                    <input type="number" id="jumlah_kamar_tidur" name="jumlah_kamar_tidur" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_kamar_tidur">Nominal Kamar Tidur (Rp):</label>
                    <input type="number" id="nominal_kamar_tidur" name="nominal_kamar_tidur" readonly>
                </div>

                <!-- Bagian Ruangan -->
                <div class="form-group">
                    <label for="jumlah_ruang_dapur">Jumlah Ruang Dapur:</label>
                    <input type="number" id="jumlah_ruang_dapur" name="jumlah_ruang_dapur" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_ruang_dapur">Nominal Ruang Dapur (Rp):</label>
                    <input type="number" id="nominal_ruang_dapur" name="nominal_ruang_dapur" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah_ruang_makan">Jumlah Ruang Makan:</label>
                    <input type="number" id="jumlah_ruang_makan" name="jumlah_ruang_makan" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_ruang_makan">Nominal Ruang Makan (Rp):</label>
                    <input type="number" id="nominal_ruang_makan" name="nominal_ruang_makan" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah_ruang_tamu">Jumlah Ruang Tamu:</label>
                    <input type="number" id="jumlah_ruang_tamu" name="jumlah_ruang_tamu" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_ruang_tamu">Nominal Ruang Tamu (Rp):</label>
                    <input type="number" id="nominal_ruang_tamu" name="nominal_ruang_tamu" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah_ruang_keluarga">Jumlah Ruang Keluarga:</label>
                    <input type="number" id="jumlah_ruang_keluarga" name="jumlah_ruang_keluarga" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_ruang_keluarga">Nominal Ruang Keluarga (Rp):</label>
                    <input type="number" id="nominal_ruang_keluarga" name="nominal_ruang_keluarga" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah_ruang_taman">Jumlah Ruang Taman:</label>
                    <input type="number" id="jumlah_ruang_taman" name="jumlah_ruang_taman" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_ruang_taman">Nominal Ruang Taman (Rp):</label>
                    <input type="number" id="nominal_ruang_taman" name="nominal_ruang_taman" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah_ruang_garasi">Jumlah Ruang Garasi:</label>
                    <input type="number" id="jumlah_ruang_garasi" name="jumlah_ruang_garasi" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_ruang_garasi">Nominal Ruang Garasi (Rp):</label>
                    <input type="number" id="nominal_ruang_garasi" name="nominal_ruang_garasi" readonly>
                </div>

                <!-- Bagian Lantai -->
                <div class="form-group">
                    <label for="jumlah_lantai">Jumlah Lantai:</label>
                    <input type="number" id="jumlah_lantai" name="jumlah_lantai" step="1" required oninput="calculateNominal()">
                </div>
                <div class="form-group">
                    <label for="nominal_jumlah_lantai">Nominal Lantai (Rp):</label>
                    <input type="number" id="nominal_jumlah_lantai" name="nominal_jumlah_lantai" readonly>
                </div>
                <div class="form-group">
                    <label for="total_harga">Total Harga (Rp):</label>
                    <input type="number" id="total_harga" name="total_harga" readonly>
                </div>

                <!-- Bagian Bank -->
                <div class="form-group">
                    <label for="nama_bank">Pilih Bank:</label>
                    <select id="nama_bank" name="nama_bank" class="form-control" required>
                        <option value="">-- Pilih Bank --</option>
                        <option value="BCA">Bank Central Asia (BCA)</option>
                        <option value="BRI">Bank Rakyat Indonesia (BRI)</option>
                        <option value="BNI">Bank Negara Indonesia (BNI)</option>
                        <option value="Mandiri">Bank Mandiri</option>
                        <option value="BSI">Bank Syariah Indonesia (BSI)</option>
                        <option value="CIMB">CIMB Niaga</option>
                        <option value="UOB">United Overseas Bank (UOB)</option>
                        <option value="OCBC">OCBC NISP</option>
                        <option value="Panin">Bank Panin</option>
                        <option value="Danamon">Bank Danamon</option>
                        <option value="Permata">Bank Permata</option>
                        <option value="Maybank">Maybank Indonesia</option>
                    </select>
                </div>

                <!-- Data Pemilik -->
                <div class="form-group">
                    <label for="nama">Nama Pemilik:</label>
                    <input type="text" id="nama" name="nama" pattern="[A-Za-z\s]+" title="Hanya huruf diperbolehkan" required>
                </div>

                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon:</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" pattern="[0-9]{10,13}" title="Nomor telepon 10-13 digit" required>
                </div>

                <div class="form-group">
                    <label for="gambar_lahan">Upload Bukti Transaksi (JPG, max 5MB):</label>
                    <input type="file" id="gambar_lahan" name="gambar_lahan" accept="image/jpeg" onchange="validateFile(this)" required>
                    <small class="error-message" id="file-error"></small>
                </div>
                <button type="submit">Submit</button>
            </form>

            <footer>
                <div class="footer-bottom">
                    <p>&copy;PT. Graha Estetika Indonesia</p>
                </div>
            </footer>
        </main>
    </div>
    <script>
function calculateNominal() {
    const panjangLahan = parseFloat(document.getElementById('panjang_lahan').value) || 0;
    document.getElementById('nominal_panjang_lahan').value = (panjangLahan * 4000).toFixed(2);

    const lebarLahan = parseFloat(document.getElementById('lebar_lahan').value) || 0;
    document.getElementById('nominal_lebar_lahan').value = (lebarLahan * 4000).toFixed(2);

    const kamarMandi = parseInt(document.getElementById('jumlah_kamar_mandi').value) || 0;
    document.getElementById('nominal_kamar_mandi').value = (kamarMandi * 1500000).toFixed(2);

    const kamarTidur = parseInt(document.getElementById('jumlah_kamar_tidur').value) || 0;
    document.getElementById('nominal_kamar_tidur').value = (kamarTidur * 2000000).toFixed(2);

    const ruangRate = 3000000;
    ['dapur', 'makan', 'tamu', 'keluarga', 'taman', 'garasi'].forEach(ruang => {
        const jumlah = parseInt(document.getElementById(`jumlah_ruang_${ruang}`).value) || 0;
        document.getElementById(`nominal_ruang_${ruang}`).value = (jumlah * ruangRate).toFixed(2);
    });

    const lantai = parseInt(document.getElementById('jumlah_lantai').value) || 0;
    document.getElementById('nominal_jumlah_lantai').value = (lantai * 5000000).toFixed(2);

    const nominalFields = [
        'nominal_panjang_lahan', 'nominal_lebar_lahan',
        'nominal_kamar_mandi', 'nominal_kamar_tidur',
        'nominal_ruang_dapur', 'nominal_ruang_makan',
        'nominal_ruang_tamu', 'nominal_ruang_keluarga',
        'nominal_ruang_taman', 'nominal_ruang_garasi',
        'nominal_jumlah_lantai'
    ];

    let totalHarga = 0;
    nominalFields.forEach(fieldId => {
        const value = parseFloat(document.getElementById(fieldId).value) || 0;
        totalHarga += value;
    });

    document.getElementById('total_harga').value = totalHarga.toFixed(2);
}

        function validateFile(input) {
            const file = input.files[0];
            const errorElement = document.getElementById('file-error');
            const validTypes = ['image/jpeg', 'image/jpg'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            errorElement.textContent = '';

            if (!file) return;

            if (!validTypes.includes(file.type)) {
                errorElement.textContent = 'Hanya file JPG/JPEG yang diizinkan!';
                input.value = '';
                return;
            }

            if (file.size > maxSize) {
                errorElement.textContent = 'Ukuran file maksimal 5MB!';
                input.value = '';
                return;
            }

            if (!/^[\w\-]+\.jpe?g$/i.test(file.name)) {
                errorElement.textContent = 'Nama file mengandung karakter tidak valid!';
                input.value = '';
            }
        }

        document.getElementById('land-form').addEventListener('submit', function(e) {
            const fields = [
                'panjang_lahan', 'lebar_lahan', 'jumlah_kamar_mandi',
                'jumlah_kamar_tidur', 'jumlah_ruang_dapur', 'jumlah_ruang_makan',
                'jumlah_ruang_tamu', 'jumlah_ruang_keluarga', 'jumlah_ruang_taman',
                'jumlah_ruang_garasi', 'jumlah_lantai', 'nama_bank', 'nama',
                'nomor_telepon', 'gambar_lahan'
            ];

            for (const field of fields) {
                const el = document.querySelector(`[name="${field}"]`);
                if (!el.value.trim()) {
                    alert(`${el.labels[0].innerText} harus diisi!`);
                    e.preventDefault();
                    return;
                }
            }

            const telp = document.getElementById('nomor_telepon').value;
            if (!/^[0-9]{10,13}$/.test(telp)) {
                alert('Nomor telepon harus 10-13 digit angka!');
                e.preventDefault();
                return;
            }

            const file = document.getElementById('gambar_lahan').files[0];
            if (!file) {
                alert('Harap upload file bukti transaksi!');
                e.preventDefault();
                return;
            }

            if (!['image/jpeg', 'image/jpg'].includes(file.type)) {
                alert('File harus dalam format JPG!');
                e.preventDefault();
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 5MB!');
                e.preventDefault();
            }
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>
    <script>
    const fields = [
        'panjang_lahan', 'lebar_lahan', 'jumlah_kamar_mandi',
        'jumlah_kamar_tidur', 'jumlah_ruang_dapur', 'jumlah_ruang_makan',
        'jumlah_ruang_tamu', 'jumlah_ruang_keluarga', 'jumlah_ruang_taman',
        'jumlah_ruang_garasi', 'jumlah_lantai', 'nama_bank', 'nama',
        'nomor_telepon', 'gambar_lahan'
    ];

    for (const field of fields) {
        const el = document.querySelector(`[name="${field}"]`);
        if (!el.value.trim()) {
            alert(`${el.labels[0].innerText} harus diisi!`);
            return;
        }
    }

    // Kumpulkan data
    const bankSelect = document.getElementById('nama_bank');
    const formData = {
        panjang_lahan: document.getElementById('panjang_lahan').value,
        nominal_panjang_lahan: document.getElementById('nominal_panjang_lahan').value,
        lebar_lahan: document.getElementById('lebar_lahan').value,
        nominal_lebar_lahan: document.getElementById('nominal_lebar_lahan').value,
        jumlah_kamar_mandi: document.getElementById('jumlah_kamar_mandi').value,
        nominal_kamar_mandi: document.getElementById('nominal_kamar_mandi').value,
        jumlah_kamar_tidur: document.getElementById('jumlah_kamar_tidur').value,
        nominal_kamar_tidur: document.getElementById('nominal_kamar_tidur').value,
        jumlah_ruang_dapur: document.getElementById('jumlah_ruang_dapur').value,
        nominal_ruang_dapur: document.getElementById('nominal_ruang_dapur').value,
        jumlah_ruang_makan: document.getElementById('jumlah_ruang_makan').value,
        nominal_ruang_makan: document.getElementById('nominal_ruang_makan').value,
        jumlah_ruang_tamu: document.getElementById('jumlah_ruang_tamu').value,
        nominal_ruang_tamu: document.getElementById('nominal_ruang_tamu').value,
        jumlah_ruang_keluarga: document.getElementById('jumlah_ruang_keluarga').value,
        nominal_ruang_keluarga: document.getElementById('nominal_ruang_keluarga').value,
        jumlah_ruang_taman: document.getElementById('jumlah_ruang_taman').value,
        nominal_ruang_taman: document.getElementById('nominal_ruang_taman').value,
        jumlah_ruang_garasi: document.getElementById('jumlah_ruang_garasi').value,
        nominal_ruang_garasi: document.getElementById('nominal_ruang_garasi').value,
        jumlah_lantai: document.getElementById('jumlah_lantai').value,
        nominal_jumlah_lantai: document.getElementById('nominal_jumlah_lantai').value,
        total_harga: document.getElementById('total_harga').value,
        nama_bank: bankSelect.options[bankSelect.selectedIndex].text,
        nama: document.getElementById('nama').value,
        nomor_telepon: document.getElementById('nomor_telepon').value,
        gambar_lahan: document.getElementById('gambar_lahan').files[0].name
    };

    localStorage.setItem('formData', JSON.stringify(formData));
    
    window.location.href = 'dashboard.php';
;
</script>

</body>
</html>