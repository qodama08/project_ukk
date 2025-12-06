<?php
namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;


class SiswaController extends Controller
{
public function index()
{

	// Only show real siswa (users with nisn - admin/system users have no nisn)
	$siswa = User::with(['kelas','jurusan'])
		->whereNotNull('nisn')
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
		'nisn' => 'required|unique:users,nisn',
		'name' => 'required',
	]);

	$payload = $validated + $request->only(['kelas_id','jurusan_id','absen','umur','nomor_hp','alamat','nama_ayah','nama_ibu','nama_wali','hubungan_wali','nomor_hp_wali']);
	$payload['password'] = bcrypt($request->input('password', 'password'));
	$payload['role'] = $payload['role'] ?? 'user';

	User::create($payload);

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
	
	return view('user.siswa.edit', compact('siswa','kelasJurusanOptions'));
}


public function update(Request $request, User $siswa)
{
	$validated = $request->validate([
		'nisn' => 'required|unique:users,nisn,' . $siswa->id,
		'name' => 'required',
	]);

	$siswa->update($validated + $request->only(['kelas_id','jurusan_id','absen','umur','nomor_hp','alamat','nama_ayah','nama_ibu','nama_wali','hubungan_wali','nomor_hp_wali']));

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