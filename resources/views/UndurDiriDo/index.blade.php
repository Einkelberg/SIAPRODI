@extends('layouts.app')

@section('content')
    <div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h3 class="h5 font-weight-bold">Daftar Mahasiswa Undur Diri/DO</h3>
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
                        <a href="{{ route('undur-diri.export') }}" class="btn btn-info">Export to Excel</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="undurDiriTable" class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Nama Mahasiswa</th>
                                <th class="text-center">Ket</th>
                                <th class="text-center">Tanggal Pengajuan</th>
                                <th class="text-center">Tanggal Persetujuan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Alasan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($undur_diri_do as $data)
                                <tr>
                                    <td class="text-center">{{ $data->nim }}</td>
                                    <td class="text-center">{{ $data->mahasiswa->nama_mahasiswa }}</td>
                                    <td class="text-center text-truncate"
                                        style="max-width: 200px; white-space: nowrap; overflow: hidden;">
                                        {{ $data->keterangan }}
                                    </td>
                                    <td class="text-center">{{ $data->tanggal_pengajuan }}</td>
                                    <td class="text-center">{{ $data->tanggal_disetujui ?? '-' }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $data->status_pengajuan == 'Disetujui' ? 'bg-success' : ($data->status_pengajuan == 'Ditolak' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ $data->status_pengajuan }}
                                        </span>
                                    </td>
                                    <td class="text-left text-truncate"
                                        style="max-width: 200px; white-space: nowrap; overflow: hidden;">
                                        {{ $data->alasan }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-info"
                                                onclick="showDetailModal(
                                                '{{ $data->mahasiswa->nama_mahasiswa }}',
                                                '{{ $data->nim }}',
                                                '{{ $data->tanggal_pengajuan }}',
                                                '{{ $data->status_pengajuan }}',
                                                '{{ $data->keterangan }}',
                                                '{{ $data->alasan }}')">
                                                Detail
                                            </button>
                                            <button class="btn btn-sm btn-warning"
                                                onclick="editData(
                                                '{{ $data->id_undur_diri_do }}',
                                                '{{ $data->nim }}',
                                                '{{ $data->tanggal_pengajuan }}',
                                                '{{ $data->alasan }}',
                                                '{{ $data->keterangan }}',
                                                '{{ $data->status_pengajuan }}',
                                                '{{ $data->tanggal_disetujui ?? '' }}')">
                                                Edit
                                            </button>
                                            <form id="delete-form-{{ $data->id_undur_diri_do }}"
                                                action="{{ route('undur-diri.destroy', $data->id_undur_diri_do) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('{{ $data->id_undur_diri_do }}', '{{ $data->mahasiswa->nama_mahasiswa }}')">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Undur Diri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('undur-diri.store') }}" method="POST">
                        @csrf

                        <!-- NIM -->
                        <div class="mb-3">
                            <label for="nim" class="form-label d-block">NIM</label>
                            <select class="select2nim w-100" name="nim" required>
                                <option style="display: none" value="" disabled selected>Cari Mahasiswa...</option>
                                @foreach ($mahasiswas as $mhs)
                                    <option value="{{ $mhs->nim }}">{{ $mhs->nama_mahasiswa }} ({{ $mhs->nim }})
                                    </option>
                                @endforeach
                            </select>
                            <span id="nim-error" class="text-danger"></span>
                        </div>




                        <!-- Tanggal Pengajuan -->
                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan"
                                required>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <select class="form-control" id="keterangan" name="keterangan" required>
                                <option value="" selected disabled>-</option>
                                <option value="DO">DO</option>
                                <option value="Undur Diri">Undur Diri</option>
                            </select>
                        </div>

                        <!-- Alasan -->
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan</label>
                            <textarea class="form-control" id="alasan" name="alasan" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status_pengajuan" class="form-label">Status Pengajuan</label>
                            <select class="form-control" id="status_pengajuan" name="status_pengajuan" required
                                onchange="toggleTanggalDisetujui()">
                                <option value="Menunggu Persetujuan">Menunggu Persetujuan</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-3" id="tanggal_disetujui_container" style="display: none;">
                            <label for="tanggal_disetujui" class="form-label">Tanggal Disetujui</label>
                            <input type="date" class="form-control" id="tanggal_disetujui" name="tanggal_disetujui">
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Undur Diri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id_undur_diri_do">

                        <div class="mb-3">
                            <label for="edit_nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="edit_nim" name="nim" required readonly>
                        </div>

                        <div class="mb-3">
                            <label for="edit_tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" id="edit_tanggal_pengajuan"
                                name="tanggal_pengajuan" required>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <select class="form-control" id="edit_keterangan" name="keterangan" required>
                                <option value="" selected disabled>-</option>
                                <option value="DO">DO</option>
                                <option value="Undur Diri">Undur Diri</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_alasan" class="form-label">Alasan</label>
                            <textarea class="form-control" id="edit_alasan" name="alasan" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit_status_pengajuan" class="form-label">Status Pengajuan</label>
                            <select class="form-control" id="edit_status_pengajuan" name="status_pengajuan" required>
                                <option value="Menunggu Persetujuan">Menunggu Persetujuan</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-3" id="edit_tanggal_disetujui_container" style="display: none;">
                            <label for="edit_tanggal_disetujui" class="form-label">Tanggal Disetujui</label>
                            <input type="date" class="form-control" id="edit_tanggal_disetujui"
                                name="tanggal_disetujui">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal detail --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pengunduran Diri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <td id="detail_nama"></td>
                        </tr>
                        <tr>
                            <th>NIM</th>
                            <td id="detail_nim"></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td id="detail_tanggal_pengajuan"></td>
                        </tr>
                        <tr>
                            <th>Status Pengajuan</th>
                            <td id="detail_status"></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td id="detail_keterangan"></td>
                        </tr>
                        <tr>
                            <th>Alasan</th>
                            <td id="detail_alasan"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    @php
        $nimList = \App\Models\Mahasiswa::pluck('nim')->toArray();
    @endphp

    {{-- cek nim  --}}
    <script>
        let nimList = @json($nimList);

        // function checkNIM() {
        //     let nimInput = document.getElementById("nim");
        //     let nimError = document.getElementById("nim-error");

        //     if (!nimList.includes(nimInput.value)) {
        //         nimError.innerText = "NIM tidak ditemukan";
        //     } else {
        //         nimError.innerText = "";
        //     }
        // }
    </script>

    <script>
        $(document).ready(function() {
            $('#addModal').on('shown.bs.modal', function() {
                $('.select2nim').select2({
                    minimumInputLength: 1,
                    dropdownParent: $('#addModal')
                });
            });

            $('.select2nim').select2({
                placeholder: "Cari Mahasiswa...",
                allowClear: true,
                minimumResultsForSearch: 0,
                width: '100%'
            });
        });
    </script>

    {{-- datatable --}}
    <script>
        $(document).ready(function() {
            $('#undurDiriTable').DataTable({
                responsive: true,
                paging: true,
                ordering: true,
                info: true,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "→",
                        previous: "←"
                    }
                }
            });
        });
    </script>
    {{-- visibility tanggal disetujui --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusPengajuan = document.getElementById("status_pengajuan");
            const tanggalDisetujuiContainer = document.getElementById("tanggal_disetujui_container");

            // Tampilkan Tanggal Disetujui Jika Status "Disetujui"
            statusPengajuan.addEventListener("change", function() {
                if (this.value === "Disetujui") {
                    tanggalDisetujuiContainer.style.display = "block";
                } else {
                    tanggalDisetujuiContainer.style.display = "none";
                }
            });
        });

        function toggleTanggalDisetujui() {
            let statusPengajuan = document.getElementById("status_pengajuan").value;
            let tanggalDisetujuiContainer = document.getElementById("tanggal_disetujui_container");
            let tanggalDisetujuiInput = document.getElementById("tanggal_disetujui");

            if (statusPengajuan === "Disetujui") {
                tanggalDisetujuiContainer.style.display = "block";
                tanggalDisetujuiInput.setAttribute("required", "required");
            } else {
                tanggalDisetujuiContainer.style.display = "none";
                tanggalDisetujuiInput.removeAttribute("required");
                tanggalDisetujuiInput.value = ""; // Kosongkan jika tidak perlu
            }
        }
    </script>

    {{-- modal edit --}}
    <script>
        function editData(id, nim, tanggal_pengajuan, alasan, keterangan, status_pengajuan, tanggal_disetujui) {
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_nim").value = nim;
            document.getElementById("edit_tanggal_pengajuan").value = tanggal_pengajuan;
            document.getElementById("edit_alasan").value = alasan;
            document.getElementById("edit_keterangan").value = keterangan;
            document.getElementById("edit_status_pengajuan").value = status_pengajuan;
            document.getElementById("edit_tanggal_disetujui").value = tanggal_disetujui ?? '';

            let tanggalDisetujuiContainer = document.getElementById("edit_tanggal_disetujui_container");
            if (status_pengajuan === "Disetujui") {
                tanggalDisetujuiContainer.style.display = "block";
            } else {
                tanggalDisetujuiContainer.style.display = "none";
                document.getElementById("edit_tanggal_disetujui").value = '';
            }

            document.getElementById("editForm").action = "/undur-diri/" + id;
            new bootstrap.Modal(document.getElementById("editModal")).show();
        }

        document.getElementById("edit_status_pengajuan").addEventListener("change", function() {
            let tanggalDisetujuiContainer = document.getElementById("edit_tanggal_disetujui_container");
            if (this.value === "Disetujui") {
                tanggalDisetujuiContainer.style.display = "block";
            } else {
                tanggalDisetujuiContainer.style.display = "none";
                document.getElementById("edit_tanggal_disetujui").value = '';
            }
        });
    </script>

    {{-- modal detail --}}
    <script>
        function showDetailModal(nama, nim, tanggal, status, keterangan, alasan) {
            document.getElementById('detail_nama').innerText = nama;
            document.getElementById('detail_nim').innerText = nim;
            document.getElementById('detail_tanggal_pengajuan').innerText = tanggal;
            document.getElementById('detail_status').innerText = status;
            document.getElementById('detail_keterangan').innerText = keterangan;
            document.getElementById('detail_alasan').innerText = alasan;

            var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
            detailModal.show();
        }
    </script>

    {{-- delete --}}
    <script>
        function confirmDelete(id, nama) {
            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data mahasiswa " + nama + " akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
