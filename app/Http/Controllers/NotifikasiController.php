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

    // Kurangi jumlah notifikasi unread admin sebanyak 1
    public function reduceUnread(Request $request)
    {
        $user = Auth::user();
        $notif = Notifikasi::where('user_id', $user->id)
            ->where('is_read', false)
            ->orderBy('created_at', 'asc')
            ->first();
        if ($notif) {
            $notif->is_read = true;
            $notif->save();
        }
        return response()->json(['success' => true]);
    }

    // Hapus notifikasi
    public function destroy($id)
    {
        $user = Auth::user();
        $notif = Notifikasi::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $notif->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Notifikasi berhasil dihapus');
    }
}
