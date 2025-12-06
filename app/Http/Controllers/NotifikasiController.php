<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifs = Notifikasi::where('user_id', $user->id)->orderBy('created_at','desc')->paginate(30);
        return view('notifikasi.index', ['notifikasis' => $notifs]);
    }

    public function markRead($id)
    {
        $user = Auth::user();
        $n = Notifikasi::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $n->is_read = true;
        $n->save();
        return back();
    }
}
