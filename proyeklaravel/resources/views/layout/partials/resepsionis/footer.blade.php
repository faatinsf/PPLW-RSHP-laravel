<footer class="footer mt-5">
    <div class="container-fluid">
        <div class="row py-4 border-top">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-muted">
                    <i class="fas fa-copyright me-1"></i>
                    {{ date('Y') }} <strong>Klinik Hewan</strong>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 text-muted">
                    Version 1.0.0 | 
                    <a href="#" class="text-decoration-none">Privacy Policy</a> | 
                    <a href="#" class="text-decoration-none">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        background: white;
        margin-top: auto;
    }

    .footer a {
        color: #64748b;
        transition: color 0.2s;
    }

    .footer a:hover {
        color: var(--primary-color);
    }
</style>