@extends('layouts.dashboard.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold topbar-title">Manajemen Pengguna</h3>
        <button class="btn btn-purple-refined" data-bs-toggle="modal" data-bs-target="#addPenggunaModal">
            <i class="bi bi-person-plus me-2"></i> Tambah Pengguna
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-transparent border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengguna as $index => $item)
                        <tr class="shadow-sm mb-2">
                            <td class="fw-medium text-muted">{{ $pengguna->firstItem() + $index }}</td>
                            <td>
                                <div class="rounded-circle overflow-hidden shadow-sm border border-2 border-white" style="width: 45px; height: 45px;">
                                    @if($item->foto_p)
                                        <img src="{{ asset('assets/uploads/'.$item->foto_p) }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 bg-purple-ultra-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person text-purple-600"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-bold">{{ $item->nama_p }}</td>
                            <td><span class="text-muted">@</span>{{ $item->username_p }}</td>
                            <td>
                                @if($item->role_p === 'admin')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-bold" style="font-size: 0.7rem;">ADMIN</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold" style="font-size: 0.7rem;">KASIR</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-light text-primary rounded-pill px-3 me-1" data-bs-toggle="modal" data-bs-target="#editPenggunaModal{{ $item->id_p }}">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                                <form action="{{ route('admin.pengguna.destroy', $item->id_p) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger rounded-pill px-3" onclick="return confirm('Hapus pengguna ini?')">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editPenggunaModal{{ $item->id_p }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content modal-content-refined shadow-lg">
                                    <form action="{{ route('admin.pengguna.update', $item->id_p) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-0 p-4 pb-0">
                                            <h5 class="fw-bold text-purple-600">Edit Pengguna</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-muted small uppercase">Nama Lengkap</label>
                                                <input type="text" name="nama_p" class="form-control rounded-4 border-2 p-3" value="{{ $item->nama_p }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-muted small uppercase">Username</label>
                                                <input type="text" name="username_p" class="form-control rounded-4 border-2 p-3" value="{{ $item->username_p }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-muted small uppercase">Password (Biarkan kosong jika tidak diubah)</label>
                                                <input type="password" name="password_p" class="form-control rounded-4 border-2 p-3">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-muted small uppercase">Role</label>
                                                <select name="role_p" class="form-select rounded-4 border-2 p-3" required>
                                                    <option value="admin" {{ $item->role_p === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="kasir" {{ $item->role_p === 'kasir' ? 'selected' : '' }}>Kasir</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-muted small uppercase">Foto Profil (Opsional)</label>
                                                <input type="file" name="foto_p" class="form-control rounded-4 border-2 p-2">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 pt-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-purple-refined px-4">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted bg-white rounded-4">Belum ada pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $pengguna->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addPenggunaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-refined shadow-lg">
            <form action="{{ route('admin.pengguna.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold text-purple-600">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Nama Lengkap</label>
                        <input type="text" name="nama_p" class="form-control rounded-4 border-2 p-3" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Username</label>
                        <input type="text" name="username_p" class="form-control rounded-4 border-2 p-3" placeholder="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Password</label>
                        <input type="password" name="password_p" class="form-control rounded-4 border-2 p-3" placeholder="••••••••" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Role</label>
                        <select name="role_p" class="form-select rounded-4 border-2 p-3" required>
                            <option value="kasir">Kasir</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Foto Profil</label>
                        <input type="file" name="foto_p" class="form-control rounded-4 border-2 p-2">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-purple-refined px-4">Tambah Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
