use App\Models\Favori;
use Illuminate\Support\Facades\Auth;

public function index()
{
    $favoris = Favori::with('film')
        ->where('user_id', Auth::id())
        ->get();

    return view('favoris.index', compact('favoris'));
}

