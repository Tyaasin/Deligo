<div class="container-fluid pt-2">
    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body">
                    <h4><b>Tambah Data</b></h4>

                    @isset($user)
                        <form action="/admin/user/{{ $user->id }}" method="POST">
                            @method('put')
                    @else
                    <form action="/admin/user" method="POST">
                    @endisset

                        @csrf
                        <!-- // Name -->
                        <div class="form-group">
                            <label for=""><b>Nama Lengkap</b></label>
                            <input type="text" class="form-control @error('name')  is-invalid @enderror" name="name" placeholder="Nama Lengkap" value="{{  isset($user) ? $user->name : '' }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email users -->
                        <div class="form-group">
                            <label for=""><b>Email</b></label>
                            <input type="text" class="form-control @error('email')  is-invalid @enderror" name="email" placeholder="Email" value="{{  isset($user) ? $user->email : '' }}">

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        </div>

                        <!-- Role users -->
                        <div class="form-group">
                            <label for=""><b>Role</b></label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror">

                                <option value="">-- Pilih Role --</option>
                                    @foreach($role as $role)
                                        <option value="{{ $role }}"
                                            {{ (old('role', $user->role ?? '') == $role) ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                            </select>

                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for=""><b>Password</b></label>
                            <input type="password" class="form-control @error('password')  is-invalid @enderror" name="password" placeholder="Password">

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for=""><b>Konfirmasi Password</b></label>
                            <input type="password" class="form-control @error('re_password')  is-invalid @enderror" name="re_password" placeholder="Password">
                            @error('re_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        </div>

                        <a href="/admin/user" class="btn bg-red"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>