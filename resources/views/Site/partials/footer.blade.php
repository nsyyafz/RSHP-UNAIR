<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row g-4">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-logo-section">
                        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png" alt="Logo Unair" class="footer-logo">
                        <h5 class="footer-title">RSHP Unair</h5>
                        <p class="footer-text">Rumah Sakit Hewan Pendidikan Universitas Airlangga memberikan pelayanan kesehatan hewan terbaik dengan fasilitas modern dan tenaga profesional.</p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Menu</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('layanan-umum') }}">Layanan Umum</a></li>
                        <li><a href="{{ route('visi-misi') }}">Visi & Misi</a></li>
                        <li><a href="{{ route('struktur') }}">Struktur</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Layanan</h5>
                    <ul class="footer-links">
                        <li><a href="#">Pelayanan Medis</a></li>
                        <li><a href="#">Rawat Inap</a></li>
                        <li><a href="#">Vaksinasi</a></li>
                        <li><a href="#">Bedah & Operasi</a></li>
                        <li><a href="#">Grooming</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Kontak Kami</h5>
                    <ul class="footer-contact">
                        <li>
                            <i>📍</i>
                            <span>Kampus C Universitas Airlangga<br>Surabaya 60115, Jawa Timur</span>
                        </li>
                        <li>
                            <i>📞</i>
                            <span>(031) 5927832</span>
                        </li>
                        <li>
                            <i>📧</i>
                            <span>rshp@fkh.unair.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2025 RSHP Universitas Airlangga. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Powered by <strong>Universitas Airlangga</strong></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    background: linear-gradient(135deg, #003366 0%, #001f3f 100%);
    color: #fff;
    margin-top: 5rem;
}

.footer-top {
    padding: 4rem 0 2rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
}

.footer-logo-section {
    padding-right: 2rem;
}

.footer-logo {
    width: 60px;
    height: 60px;
    margin-bottom: 1rem;
}

.footer-title {
    color: #ffd700;
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
    position: relative;
    padding-bottom: 0.5rem;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: #ffd700;
}

.footer-text {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.8;
    font-size: 0.95rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.8rem;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    position: relative;
}

.footer-links a::before {
    content: '›';
    margin-right: 0.5rem;
    color: #ffd700;
    font-weight: bold;
}

.footer-links a:hover {
    color: #ffd700;
    transform: translateX(5px);
}

.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    margin-bottom: 1.2rem;
    display: flex;
    align-items: start;
    gap: 0.8rem;
}

.footer-contact i {
    font-style: normal;
    font-size: 1.2rem;
    margin-top: 0.2rem;
}

.footer-contact span {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    font-size: 0.95rem;
}

.footer-bottom {
    padding: 1.5rem 0;
    background: rgba(0, 0, 0, 0.2);
}

.footer-bottom p {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .footer-top {
        padding: 3rem 0 1.5rem;
    }
    
    .footer-logo-section {
        padding-right: 0;
        margin-bottom: 2rem;
    }
    
    .footer-bottom .col-md-6 {
        margin-bottom: 0.5rem;
    }
}
</style>