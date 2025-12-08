<div class="modal fade" id="quickRegisterModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Registrasi Cepat Pemilik & Hewan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('resepsionis.appointment.quickRegister') }}" method="POST" id="quickRegisterForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Info:</strong> Form ini untuk registrasi cepat. Setelah menyimpan, Anda akan diarahkan ke form appointment.
                    </div>

                    <div class="row">
                        <!-- Data Pemilik -->
                        <div class="col-md-6">
                            <div class="card border-success mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Data Pemilik</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="qr_nama_pemilik" class="form-label">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="qr_nama_pemilik" 
                                               name="nama_pemilik" 
                                               required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="qr_no_wa" class="form-label">
                                            No. WhatsApp <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="qr_no_wa" 
                                               name="no_wa" 
                                               placeholder="08xxxxxxxxxx"
                                               required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="qr_email" class="form-label">Email</label>
                                        <input type="email" 
                                               class="form-control" 
                                               id="qr_email" 
                                               name="email">
                                        <small class="text-muted">Opsional - untuk notifikasi</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="qr_alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" 
                                                  id="qr_alamat" 
                                                  name="alamat" 
                                                  rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Hewan -->
                        <div class="col-md-6">
                            <div class="card border-primary mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-paw me-2"></i>Data Hewan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="qr_nama_pet" class="form-label">
                                            Nama Hewan <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="qr_nama_pet" 
                                               name="nama_pet" 
                                               required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="qr_idras_hewan" class="form-label">
                                            Ras Hewan <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" 
                                                id="qr_idras_hewan" 
                                                name="idras_hewan" 
                                                required>
                                            <option value="">-- Pilih Ras --</option>
                                            @php
                                                $ras_list = DB::table('ras_hewan as rh')
                                                    ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
                                                    ->select('rh.idras_hewan', 'rh.nama_ras', 'jh.nama_jenis_hewan')
                                                    ->orderBy('jh.nama_jenis_hewan')
                                                    ->orderBy('rh.nama_ras')
                                                    ->get()
                                                    ->groupBy('nama_jenis_hewan');
                                            @endphp
                                            @foreach($ras_list as $jenis => $ras_items)
                                                <optgroup label="{{ $jenis }}">
                                                    @foreach($ras_items as $ras)
                                                        <option value="{{ $ras->idras_hewan }}">{{ $ras->nama_ras }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="qr_jenis_kelamin" class="form-label">
                                                Jenis Kelamin <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" 
                                                    id="qr_jenis_kelamin" 
                                                    name="jenis_kelamin" 
                                                    required>
                                                <option value="">-- Pilih --</option>
                                                <option value="J">Jantan</option>
                                                <option value="B">Betina</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="qr_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" 
                                                   class="form-control" 
                                                   id="qr_tanggal_lahir" 
                                                   name="tanggal_lahir"
                                                   max="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="qr_warna_tanda" class="form-label">Warna / Tanda Khusus</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="qr_warna_tanda" 
                                               name="warna_tanda"
                                               placeholder="Contoh: Coklat dengan bintik putih di dahi">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Simpan & Buat Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format phone number
    document.getElementById('qr_no_wa')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });

    // Auto generate email if empty
    document.getElementById('qr_nama_pemilik')?.addEventListener('blur', function() {
        const emailField = document.getElementById('qr_email');
        if (!emailField.value && this.value) {
            const cleanName = this.value.toLowerCase().replace(/\s+/g, '');
            emailField.value = cleanName + '@temp.com';
        }
    });
});
</script>