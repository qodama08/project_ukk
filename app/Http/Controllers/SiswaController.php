<?php
namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Role;
use Illuminate\Http\Request;


class SiswaController extends Controller
{
public function index()
{

	// Only show real siswa (users with 'user' role - admin/system users have different roles)
	$siswa = User::with(['kelas','jurusan'])
		->whereHas('roles', function($q) {
			$q->where('nama_role', 'user');
		})
		->paginate(15);
	return view('user.siswa.index', compact('siswa'));
}

public function create()
{
	$kelasJurusanOptions = Kelas::with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
	
	return view('user.siswa.create', compact('kelasJurusanOptions'));
}


public function store(Request $request)
{
	$validated = $request->validate([
		'name' => 'required',
		'email' => 'required|email|unique:users,email',
		'kelas_id' => 'required',
		'absen' => [
			'required',
			'numeric',
			function ($attribute, $value, $fail) use ($request) {
				$exists = User::where('kelas_id', $request->kelas_id)
					->where('absen', $value)
					->whereHas('roles', function($q) {
						$q->where('nama_role', 'user');
					})
					->exists();
				if ($exists) {
					$fail('Nomor absen ' . $value . ' sudah ada di kelas ini.');
				}
			},
		],
		'umur' => 'nullable|numeric',
		'nomor_hp' => 'required|numeric|unique:users,nomor_hp',
		'alamat' => 'nullable',
		'nama_ayah' => 'nullable',
		'nama_ibu' => 'nullable',
		'nama_wali' => 'nullable',
		'hubungan_wali' => 'nullable',
		'nomor_hp_wali' => 'nullable|numeric',
	]);

	$payload = $validated + $request->only(['jurusan_id']);
	$payload['password'] = bcrypt($request->input('password', 'password'));
	$payload['role'] = $payload['role'] ?? 'user';

	$user = User::create($payload);

	// Assign 'user' role to the student
	$userRole = Role::where('nama_role', 'user')->first();
	if ($userRole) {
		$user->roles()->attach($userRole->id);
	} else {
		// Create the 'user' role if it doesn't exist
		$userRole = Role::create([
			'nama_role' => 'user',
			'deskripsi' => 'Pengguna umum',
			'is_multi' => false
		]);
		$user->roles()->attach($userRole->id);
	}

	return redirect()->route('siswa.index')->with('success','Siswa berhasil ditambahkan');
}

public function show(User $siswa)
{
	$siswa->load(['kelas','jurusan']);
	return view('user.siswa.show', compact('siswa'));
}

public function edit(User $siswa)
{
	$kelasJurusanOptions = Kelas::with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
	$daftarSiswa = User::with('kelas')->whereHas('roles', function($q) {
		$q->where('nama_role', 'user');
	})->get();
	
	return view('user.siswa.edit', compact('siswa','kelasJurusanOptions','daftarSiswa'));
}


public function update(Request $request, User $siswa)
{
	$validated = $request->validate([
		'name' => 'required',
		'email' => 'required|email|unique:users,email,' . $siswa->id,
		'kelas_id' => 'required',
		'absen' => [
			'required',
			'numeric',
			function ($attribute, $value, $fail) use ($request, $siswa) {
				$exists = User::where('kelas_id', $request->kelas_id)
					->where('absen', $value)
					->where('id', '!=', $siswa->id)
					->whereHas('roles', function($q) {
						$q->where('nama_role', 'user');
					})
					->exists();
				if ($exists) {
					$fail('Nomor absen ' . $value . ' sudah ada di kelas ini.');
				}
			},
		],
		'umur' => 'nullable|numeric',
		'nomor_hp' => 'required|numeric|unique:users,nomor_hp,' . $siswa->id,
		'alamat' => 'nullable',
		'nama_ayah' => 'nullable',
		'nama_ibu' => 'nullable',
		'nama_wali' => 'nullable',
		'hubungan_wali' => 'nullable',
		'nomor_hp_wali' => 'nullable|numeric',
	]);

	$siswa->update($validated + $request->only(['jurusan_id']));

	return redirect()->route('siswa.index')->with('success','Siswa berhasil diperbarui');
}


public function destroy(User $siswa)
{
	// Prevent deleting the currently authenticated user to avoid accidental logout
	if (auth()->check() && auth()->id() === $siswa->id) {
		return redirect()->route('siswa.index')->withErrors(['error' => 'Tidak dapat menghapus user yang sedang aktif.']);
	}

	$siswa->delete();
	return redirect()->route('siswa.index')->with('success','Siswa dihapus');
}
}